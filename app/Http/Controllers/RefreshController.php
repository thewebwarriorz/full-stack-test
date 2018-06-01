<?php

/**
 * Refresh Controller
 *
 * Refresh the servers and server statuses by user request
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Servers;
use App\ServersStatistic;
use GuzzleHttp\Client;

class RefreshController extends Controller
{
    // Fetch data from this URL
    private static $serversUrl = "https://jbanew.staging.joybusinessacademy.com/api/v2/assignment/servers";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('refresh');
    }

    /**
     * Refresh the servers and servers statuses.
     *
     * @return \Illuminate\Http\Response
     */
    public function doRefresh()
    {

        $client = new Client();
        $response = $client->get(self::$serversUrl);
        $responseStatusCode = $response->getStatusCode();
        $responseObject = \GuzzleHttp\json_decode($response->getBody());

        // Check the request was successful
        if ($responseStatusCode !== 200 || $responseObject->code !== 200) {

            // Something wrong, set an error message and go back to the refresh page
            session()->flash('message_important', 'The refresh was not successful. The remote server has given an error code: ' . $responseStatusCode);
            return view('refresh');

        }

        // Collect the error if have any
        $serverErrors = [];
        $updateServerData = [];

        // Start parsing the servers and get the statistics
        foreach ($responseObject->source->rows as $serverData) {

            $serverId = $serverData->id;
            $serverName = $serverData->name;

            // Get the server statistics
            $serverResponse = self::getServerStatistic($serverId);
            $serverResponseCode = $serverResponse['status'];

            // If an error happened when we fetch the server status, we skip for the update cycle, and set an error message
            if ($serverResponse['status'] !== 200) {
                $serverErrors[] = 'The following server: ' . $serverId . '-' . $serverName . ' refresh was not successful. The remote server has given an error code: ' . $serverResponseCode;
                continue;
            }

            $data = $serverResponse["data"];

            $updateServerData[$serverId] = $data->source->data->value;

        }

        // Clean the servers table
        Servers::truncate();

        // Refresh the servers table
        $saveToDb = [];
        foreach ($responseObject->source->rows as $serverData) {

            $saveToDb[] = ["id" => $serverData->id, "server_name" => $serverData->name];

        }
        Servers::insert($saveToDb);

        // Clean the servers statistics table
        ServersStatistic::truncate();

        // Refresh the servers table
        foreach ($updateServerData as $serverId => $serverData) {

            $saveToDb = [];
            foreach ($serverData as $data) {

                $saveToDb[] = ["servers_statistics_server_id" => $serverId, "servers_statistics_value" => $data];

            }

            ServersStatistic::insert($saveToDb);

        }

        // Implode the errors, if have any
        if (!empty($serverErrors)) {
            session()->flash('message_important', implode("\n\r | ", $serverErrors));
        }

        return view('refresh');
    }

    /**
     * Get the given server statistic
     *
     * @param int $id
     * @return array
     */
    private function getServerStatistic(int $id)
    {

        $client = new Client();
        $response = $client->get(self::$serversUrl . "/$id");
        $responseStatusCode = $response->getStatusCode();
        $responseObject = \GuzzleHttp\json_decode($response->getBody());

        // Check the request was successful
        if ($responseStatusCode !== 200 || $responseObject->code !== 200) {

            // Something wrong, set an error message and go back to the refresh page

            return ["status" => $responseStatusCode, "data" => null];

        }

        return ["status" => $responseStatusCode, "data" => $responseObject];

    }

}
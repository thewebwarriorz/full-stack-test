@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div id="accordion">
                    @foreach($servers as $key => $server)
                        <div class="card text-white bg-dark">
                            <div class="card-header" id="heading-{{$server->id}}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{$server->id}}" aria-expanded="true" aria-controls="collapse-{{$server->id}}">
                                        {{$server->server_name}}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse-{{$server->id}}" class="@if ($key === 0) show @endif collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    {{$server->id}} Servers statistic, comes here.
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

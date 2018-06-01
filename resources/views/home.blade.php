@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card text-white bg-dark">
                    <div class="card-header">Welcome to Timefly server administration!</div>

                    <div class="card-body">
                        @auth
                            {{--// The user is authenticated...--}}
                            <h3>Welcome on board :)</h3>
                            <p>Choose the function on the top menu.</p>
                        @endauth

                        @guest
                            {{--The user is not authenticated...--}}
                            <div>You are not logged in! Please register or login!</div>
                        @endguest
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
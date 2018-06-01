@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card text-white bg-dark">
                    <div class="card-header">Refresh the data!</div>

                    <div class="card-body">

                        {{--// The user is authenticated...--}}
                        <h3>Press the button and enjoy the new data :)</h3>
                        <form method="get" action="/refresh/do-refresh">
                            {{csrf_field()}}

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Refresh the database</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

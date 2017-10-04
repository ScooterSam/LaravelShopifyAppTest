@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Install Application</div>

                    <div class="panel-body">

                        @if(session()->has('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>
                        @endif

                        <form action="{{route('auth.install')}}" method="post">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="store_url" id="store_url" class="form-control"
                                               placeholder="https://mystore.shopify.com">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-default btn-block">
                                        Install App
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

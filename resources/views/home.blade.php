@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">

                    <h2>{{ Auth::user()->name }}</h2>
                    @if(Auth::user()->is_active)
                        <p style="background: green; color: white">active in database</p>
                    @else
                        <p style="background: red; color: white">Not active in database</p>
                    @endif
                    <img src="{{ Auth::user()->avatar }}" alt="useravatar" class="avatar">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

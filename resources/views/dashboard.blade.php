@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <noscript>
        This site uses javascript to serve its full functionality. Please enable javascript . Thank You :)
    </noscript>
        <div class="row">
            <div class="col-md-2 ">
                <button id="edit" class="btn btn-primary">Edit Permissions</button>

                <button id="add" class="btn btn-primary" style="margin-top: 3%;">Add New User</button>
            </div>

            <span id="showMessage" style="background-color: #ddffdd"></span>
            <div id="showUI" class="col-md-10 "></div>
        </div>
@endsection
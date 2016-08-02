@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <noscript>
        This site uses javascript to serve its full functionality. Please enable javascript . Thank You :)
    </noscript>
        <div class="row">
            <div class="col-md-2 ">
                <button id="add" class="btn btn-primary">Add New User</button>
                <button id="edit" class="btn btn-primary" style="margin-top: 3%;">Edit Permissions</button>
            </div>

            <span id="showMessage" style="background-color: #ddffdd"></span>
            <span id="addUserUI" style="background-color: #ddffdd">

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">

                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    {!! Form::open(array('url' => 'dashboard/addUser', 'method' => 'POST','id' => 'addUser-form', 'class' => 'form-horizontal','files' => true )) !!}
                    <fieldset>
                        <legend>Add User</legend>
                        <div class="well">

                            <!-- Input field for Name -->
                            <div class="form-group">
                                {!! Form::label('firstName', 'Name') !!}
                                <div>
                                    {!! Form::text('firstName', '',array('class' => 'form-control input-md','placeholder' => 'First Name')) !!}
                                </div>
                            </div>

                            <!-- Input field for email -->
                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                <div>
                                    {!! Form::text('email', '',array('class' => 'form-control input-md','placeholder' => 'example@mail.com')) !!}
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="submit" value="ADD" class="btn btn-primary">
                            </div>
                        </div>
                    </fieldset>
                    {!! Form::hidden('prefix','mr') !!}
                    {!! Form::hidden('middleName','') !!}
                    {!! Form::hidden('lastName','') !!}
                    {!! Form::hidden('mobile','') !!}
                    {!! Form::hidden('landline','') !!}
                    {!! Form::hidden('gender','male') !!}
                    {!! Form::hidden('maritalStatus','married') !!}
                    {!! Form::hidden('password','password') !!}
                    {!! Form::hidden('employment','employed') !!}
                    {!! Form::hidden('employer','') !!}
                    {!! Form::hidden('dob','') !!}
                    {!! Form::hidden('stackId','') !!}
                    {!! Form::hidden('note','') !!}
                    {!! Form::hidden('residenceStreet','') !!}
                    {!! Form::hidden('residenceCity','') !!}
                    {!! Form::hidden('residenceState','') !!}
                    {!! Form::hidden('residenceZip','') !!}
                    {!! Form::hidden('residenceFax','') !!}
                    {!! Form::hidden('officeStreet','') !!}
                    {!! Form::hidden('officeCity','') !!}
                    {!! Form::hidden('officeState','') !!}
                    {!! Form::hidden('officeZip','') !!}
                    {!! Form::hidden('officeFax','') !!}
                    {!! Form::close() !!}
                </div>
            </span>
            <div id="showUI" class="col-md-10 "></div>
        </div>
@endsection
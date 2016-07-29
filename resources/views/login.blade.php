@extends('layouts.app')
@section('title','Log In')
@section('content')
    <noscript>
        This site uses javascript to serve its full functionality. Please enable javascript . Thank You :)
    </noscript>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">

                <!-- Display Validation Errors -->
                @include('common.errors')

                {!! Form::open(array('url' => route('do-login'), 'method' => 'POST','id' => 'login-form', 'class' => 'form-horizontal','files' => true )) !!}
                    <fieldset>
                        <legend>Log In</legend>
                        <div class="well">
                            <!-- Input field for email -->
                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                <div>
                                    {!! Form::text('email', '',array('class' => 'form-control input-md','placeholder' => 'example@mail.com')) !!}
                                </div>
                            </div>
                            <!-- Input field for password -->
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                <div>
                                    {!! Form::password('password', array('class' => 'form-control input-md','placeholder' => 'Password')) !!}
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="submit" value="LOGIN" class="btn btn-primary">
                            </div>
                        </div>
                    </fieldset>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
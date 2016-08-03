@extends('layouts.app')
@section('title','Reset Password')
@section('content')
    <noscript>
        This site uses javascript to serve its full functionality. Please enable javascript . Thank You :)
    </noscript>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">

                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 ">

                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    {!! Form::open(array('url' => 'resetPassword/do-reset', 'method' => 'POST','id' => 'reset-form', 'class' => 'form-horizontal','files' => true )) !!}
                    <fieldset>
                        <legend>Reset Password</legend>
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
                                <input type="submit" name="submit" value="SUBMIT" class="btn btn-primary">
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

@endsection
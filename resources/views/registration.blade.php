@extends('layouts.app')
@section('title',ucfirst(explode('/',\Request::getPathInfo())[1]))
@section('content')
    <noscript>
        This site uses javascript to serve its full functionality. Please enable javascript . Thank You :)
    </noscript>

    <div class="container">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <h1>{{ ucfirst(explode('/',\Request::getPathInfo())[1]) }}</h1>
        <!-- New Task Form -->
        {!! Form::open(array('url' => route($route), 'method' => 'POST','id' => 'registration-form', 'class' => 'form-horizontal','files' => true )) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <fieldset>
                    <legend>Personal Details</legend>
                    <div class="well">
                        <!-- Select dropdown for prefix -->
                        <div class="form-group">
                            {!! Form::label('prefix', 'Prefix', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!!  Form::select('prefix',array('mr' => 'Mr', 'miss' => 'Miss'), '',['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Text Input for First Name -->
                        <div class="form-group">
                            {!! Form::label('firstName', 'First Name', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('firstName', $user->firstName,['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                            </div>
                        </div>

                        <!-- Text Input for Middle Name -->
                        <div class="form-group">
                            {!! Form::label('middleName', 'Middle Name', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('middleName', $user->middleName,['class' => 'form-control', 'placeholder' => 'Middle Name']) !!}
                            </div>
                        </div>

                        <!-- Text Input for Last Name -->
                        <div class="form-group">
                            {!! Form::label('lastName', 'Last Name', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('lastName', $user->lastName,['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                            </div>
                        </div>

                        <!-- Radio Input for Gender -->
                        <div class="form-group">
                            {!! Form::label('gender', 'Gender', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">

                                {!! Form::radio('gender', 'male', true,array('id' => 'male')) !!}
                                {!! Form::label('male', 'Male') !!}


                                {!! Form::radio('gender', 'female',$user->isFemale,array('id' => 'female')) !!}
                                {!! Form::label('female', 'Female') !!}


                                {!! Form::radio('gender', 'others',$user->isOthers,array('id' => 'others')) !!}
                                {!! Form::label('others', 'Others') !!}
                            </div>
                        </div>

                        <!-- Input for D.O.B -->
                        <div class="form-group">
                            {!! Form::label('dob', 'D.O.B', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::date('dob',$user->dob,array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <!-- Number input for mobile number -->
                        <div class="form-group">
                            {!! Form::label('mobile', 'Mobile', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('mobile',$user->mobile,array('class' => 'form-control','placeholder' => '9999999999')) !!}
                            </div>
                        </div>

                        <!-- Number input for landline number -->
                        <div class="form-group">
                            {!! Form::label('landline', 'Landline', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('landline', $user->landline,array('class' => 'form-control','placeholder' => '9999999999')) !!}
                            </div>
                        </div>

                        <!-- Input for Email field -->
                        <div class="form-group">
                            {!! Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('email',$user->email,array('class' => 'form-control','placeholder' => 'example@mail.com')) !!}
                            </div>
                        </div>

                        <!-- Input for Password field -->
                        <div class="form-group">
                            {!! Form::label('password', 'Password', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::password('password', array('class' => 'form-control','placeholder' => 'Password')) !!}
                            </div>
                        </div>

                        <!-- Radio Input for Marital status -->
                        <div class="form-group">
                            {!! Form::label('maritalStatus', 'Marital Status', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">

                                {!! Form::radio('maritalStatus', 'married', true,array('id' => 'married')) !!}
                                {!! Form::label('married', 'Married') !!}


                                {!! Form::radio('maritalStatus', 'unmarried',$user->isUnmarried,array('id' => 'unmarried')) !!}
                                {!! Form::label('unmarried', 'Unmarried') !!}
                            </div>
                        </div>

                        <!-- Radio Input for Employment -->
                        <div class="form-group">
                            {!! Form::label('employment', 'Employment', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">

                                {!! Form::radio('employment', 'employed', true,array('id' => 'employed')) !!}
                                {!! Form::label('employed', 'Employed') !!}


                                {!! Form::radio('employment', 'unemployed',$user->isUnemployed,array('id' => 'unemployed')) !!}
                                {!! Form::label('unemployed', 'Unemployed') !!}
                            </div>
                        </div>

                        <!-- Input for Employer -->
                        <div class="form-group">
                            {!! Form::label('employer', 'Employer', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('employer',$user->employer,array('class' => 'form-control','placeholder' => 'Employer')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('stackId', 'StackoverflowId', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('stackId',$user->stackId,array('class' => 'form-control','placeholder' => 'StackOverflow Id')) !!}
                            </div>
                        </div>

                        <!-- Input for photo -->
                        <div class="form-group">
                            {!! Form::label('photo', 'Photo', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::file('photo') !!}
                                @if ( $user->photo != '' )
                                    <img src="/images/{{ $user->photo }} " alt="profile pic"  height="100px" width="100px">
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <fieldset>
                    <legend>Residence Address</legend>
                    <div class="well">

                        <!-- Input for Residence Street -->
                        <div class="form-group">
                            {!! Form::label('residenceStreet', 'Street', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('residenceStreet',$user->residenceStreet,['class' => 'form-control', 'placeholder' => 'Street']) !!}
                            </div>
                        </div>

                        <!-- Input for Residence City -->
                        <div class="form-group">
                            {!! Form::label('residenceCity', 'City', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('residenceCity',$user->residenceCity,['class' => 'form-control', 'placeholder' => 'City']) !!}
                            </div>
                        </div>

                        <!-- Select dropdown for Residence State -->
                        <div class="form-group">
                            {!! Form::label('residenceState', 'State', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!!  Form::select('residenceState',config('constants.states'), $user->residenceState,['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Input for Residence Zip -->
                        <div class="form-group">
                            {!! Form::label('residenceZip', 'Zip', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('residenceZip',$user->residenceZip,['class' => 'form-control', 'placeholder' => 'Zip']) !!}
                            </div>
                        </div>

                        <!-- Input for Residence Fax -->
                        <div class="form-group">
                            {!! Form::label('residenceFax', 'Fax', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('residenceFax',$user->residenceFax,['class' => 'form-control', 'placeholder' => 'Fax']) !!}
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Office Address</legend>
                    <div class="well">

                        <!-- Input for Office Street -->
                        <div class="form-group">
                            {!! Form::label('officeStreet', 'Street', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('officeStreet',$user->officeStreet,['class' => 'form-control', 'placeholder' => 'Street']) !!}
                            </div>
                        </div>

                        <!-- Input for Office City -->
                        <div class="form-group">
                            {!! Form::label('officeCity', 'City', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('officeCity',$user->officeCity,['class' => 'form-control', 'placeholder' => 'City']) !!}
                            </div>
                        </div>

                        <!-- Select dropdown for Office State -->
                        <div class="form-group">
                            {!! Form::label('officeState', 'State', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!!  Form::select('officeState',config('constants.states'),$user->officeState,['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Input for Residence Zip -->
                        <div class="form-group">
                            {!! Form::label('officeZip', 'Zip', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('officeZip',$user->officeZip,['class' => 'form-control', 'placeholder' => 'Zip']) !!}
                            </div>
                        </div>

                        <!-- Input for Residence Fax -->
                        <div class="form-group">
                            {!! Form::label('officeFax', 'Fax', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('officeFax',$user->officeFax,['class' => 'form-control', 'placeholder' => 'Fax']) !!}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <fieldset>
                    <legend>Other Details</legend>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                                <!-- Input for Note field -->
                                <div class="form-group">
                                    {!! Form::label('note', 'Note',  array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-7">
                                        {!! Form::textarea('note',$user->note,['rows' => '3','class' => 'form-control', 'placeholder' => 'Note']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2">
                                        {!! Form::label('commMedium', 'Communication Medium',  array('class' => 'col-md-3 control-label')) !!}
                                    </div>
                                    <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                                        <div class="checkbox-inline">
                                            {!! Form::checkbox('commMed[]','mail',$user->commEmail,array('id' => 'mail') )!!}
                                            {!! Form::label('mail', 'Mail') !!}
                                        </div>

                                        <div class="checkbox-inline">
                                            {!! Form::checkbox('commMed[]','phone',$user->call,array('id' => 'phone') )!!}
                                            {!! Form::label('phone', 'Phone') !!}
                                        </div>

                                        <div class="checkbox-inline">
                                            {!! Form::checkbox('commMed[]','msg',$user->msg,array('id' => 'msg') )!!}
                                            {!! Form::label('msg', 'Msg') !!}
                                        </div>

                                        <div class="checkbox-inline">
                                            {!! Form::checkbox('commMed[]','any',$user->any,array('id' => 'any') )!!}
                                            {!! Form::label('any', 'Any') !!}
                                        </div>
                                        {!! Form::hidden('id', $user->id) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-offset-3 col-sm-6">
                <!-- Add Task Submit Button -->
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>

                <!-- Add Task Reset Button -->
                <button type="reset" class="btn btn-danger">
                    Reset
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection
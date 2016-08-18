@extends('layouts.app')
@section('title','Home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 ">
                @include('common.errors')
                {!! Form::open(array('url' => route('create-token'), 'method' => 'POST','id' => 'api-form', )) !!}
                <div class="form-group">
                    {!! Form::text('token', Auth::user()->api_token, array('class' => 'form-control input-md','placeholder' => 'API TOKEN')) !!}
                    <input type="submit" name="submit" value="Create Token" class="btn btn-primary">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('title','Home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 text-center">
            <?php
                //Create a greeting message with respect to time of the day
                $time = date("H");
                if( $time < 12 ) {

                $wish = 'Good morning';
                } else if ( $time >= 12 && $time < 16) {

                $wish = 'Good afternoon';
                } else if ( $time >= 16 ) {

                $wish = 'Good evening';
                }
            ?>
            @if ( Auth::check() )
                <h2>Welcome back {{ Auth::user()->firstName }} , {{ $wish }}</h2>
            @else
                @if ( Session::get('userLogout') == '1')
                    <h2>Thanks for stopping by!
                    <br>
                    We hope to see you again soon
                    </h2>
                @else
                    <h2>Welcome to employee registration portal</h2>
                @endif
            @endif

            </div>
        </div>
    </div>
@endsection
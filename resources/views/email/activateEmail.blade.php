<h3>
    @if ( $isAddUser == 'true' )
        Your account is created in our website. Your login details are : <br>
        Email : {{ $emailAddress }} <br>
        Password : {{ $password }} <br>
        Please change your password after you login. <br>
        <a href="{{ URL::to('verifyUser/'.$email.'/'.$code) }}"  target="_blank">
            Click here to activate your account
        </a>
    @else
        @if ( $isReset == 'true')
            <a href="{{ URL::to('verifyUser/'.$email.'/'.$code.'/true') }}"  target="_blank">
                Click here to reset your password
            </a>
        @else
        <a href="{{ URL::to('verifyUser/'.$email.'/'.$code) }}"  target="_blank">
            Click here to activate your account
        </a>
        @endif
    @endif

</h3>
@if (count($errors) > 0)
    <!-- Display Message for validation errors -->
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong!</strong>

        <br><br>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Success message for registration -->
@if ( Session::get('message') == '1' )

    <div class="alert alert-success">
        <strong>Registration Successful. Please verify your email to access your account.</strong>
    </div>
@endif

<!-- Message for failed registration -->
@if ( Session::get('message') == '0' )

    <div class="alert alert-danger">
        <strong>Sorry, We have encountered some problem while trying to get your account registered. Please try after sometime.</strong>
    </div>
@endif

<!-- Success message for email verification -->
@if ( Session::get('message') == '2' )

    <div class="alert alert-success">
        <strong>Your email is verified . Please login to access your account.</strong>
    </div>
@endif

<!-- Message for invalid login -->
@if ( Session::get('message') == '3' )

    <div class="alert alert-danger">
        <strong>Invalid login credentials.</strong>
    </div>
@endif

<!-- Message for invalid login -->
@if ( Session::get('unauthorised') == '1' )

    <div class="alert alert-danger">
        <strong>Sorry ! You are not authorised.</strong>
    </div>
@endif

<!-- Message for account delete failed -->
@if ( Session::get('deletefailed') == '1' )

    <div class="alert alert-danger">
        <strong>Sorry ! We encounted some problem while trying to delete your account.Please try after some time.</strong>
    </div>
@endif

<!-- Message for account update success -->
@if ( Session::get('updateSuccess') == '1' )

    <div class="alert alert-success">
        <strong>Update was successful</strong>
    </div>
@endif

<!-- Message for account update failed -->
@if ( Session::get('updateFailed') == '1' )

    <div class="alert alert-danger">
        <strong>Update failed please try again after some time</strong>
    </div>
@endif

<!-- Message for Add user success -->
@if ( Session::get('addUser') == '1' )

    <div class="alert alert-success">
        <strong>User successfully added</strong>
    </div>
@endif

<!-- Message for invalid reset details -->
@if ( Session::get('resetDetails') == '0' )

    <div class="alert alert-danger">
        <strong>Invalid First Name or Email</strong>
    </div>
@endif

<!-- Message for reset failed -->
@if ( Session::get('resetFailed') == '1' )

    <div class="alert alert-danger">
        <strong>Sorry! We have encountered some problem. Please try after some time.</strong>
    </div>
@endif

<!-- Message for reset success -->
@if ( Session::get('resetSuccess') == '1' )

    <div class="alert alert-success">
        <strong>We have sent a link to your email,please click on it and update your password.</strong>
    </div>
@endif

<!-- Message for reset password -->
@if ( Session::get('resetMessage') == '1' )

    <div class="alert alert-success">
        <strong>Please reset your password</strong>
    </div>
@endif

<!-- Message for Login Failed-->
@if ( Session::get('loginFailed') == '1' )

    <div class="alert alert-danger">
        <strong>Login Failed ! Please try after sometime</strong>
    </div>
@endif

<!-- Message for Update details -->
@if ( Session::get('updateDetails') == '1' )

    <div class="alert alert-success">
        <strong>Please Update your details</strong>
    </div>
@endif

<!-- Message for email required -->
@if ( Session::get('email_required') == '1' )

    <div class="alert alert-danger">
        <strong>Please provide an email in your social media account and try again.</strong>
    </div>
@endif

































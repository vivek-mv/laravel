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


































<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Home Route
 */
Route::get('/',['as' => 'home', function () {
    return view('welcome');
}]);

/**
 * Route to show Registration Page
 */
Route::get('register', ['as' => 'register', 'uses' => 'RegistrationController@register']);

/**
 * Route to process user Registration
 */
Route::post('do-register', ['as' => 'do-register', 'uses' => 'RegistrationController@doRegister']);

/**
 * Route to show login page
 */
Route::get('login', ['as' => 'login', 'uses' => 'LoginController@login']);

/**
 * Route for login with FB
 */
Route::get('fbLogin',['as' => 'fbLogin', function () {
    return Socialize::with('facebook')->redirect();
}]);

/**
 * Route for login with Google
 */
Route::get('googleLogin',['as' => 'googleLogin', function () {
    return Socialize::with('google')->redirect();
}]);


/**
 * Route for callback url from fb
 */
Route::get('loginWithOthers/{google?}',['as' => 'loginWithOthers', 'uses' => 'LoginController@loginWithOthers']);


/**
 * Route to process user Login
 */
Route::post('do-login', ['as' => 'do-login', 'uses' => 'LoginController@doLogin']);

/**
 * Route to verify user's email
 */
Route::get('verifyUser/{email}/{activationCode}/{isReset?}', ['as' => 'verifyUser', 'uses' => 'VerifyUserController@verifyUser']);

/**
 * Route to show reset password
 */
Route::get('resetPassword', ['as' => 'resetPassword', 'uses' => 'HelperController@showReset']);

/**
 * Route to do reset password
 */
Route::post('resetPassword/do-reset', ['as' => 'do-reset', 'uses' => 'HelperController@doReset']);

/**
 * Logout the user
 */
Route::get('/logout',['as' => 'logout', function () {
    Auth::logout();
    return redirect()->route('home')->with('userLogout','1');
}]);

/**
 * Grouped route to check users permissions
 */
Route::group(['middleware' => 'authenticateUser'], function () {

    Route::get('/details', 'DatatablesController@getIndex');

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@showDashboard']);

    Route::get('delete/{id}','HelperController@delete');

    Route::get('update/{id}','HelperController@update');

    /**
     * Route to process user Update
     */
    Route::post('do-update', ['as' => 'do-update', 'uses' => 'HelperController@doUpdate']);

    /**
     * Route to display all the available permissions in the dashboard
     */
    Route::post('dashboard/getPermissions', 'DashboardController@getPermissions');

    /**
     * Route to change the permissions in the dashboard
     */
    Route::post('dashboard/setPermissions', 'DashboardController@setPermissions');

    /**
     * Route to add new user
     */
    Route::post('dashboard/addUser', 'DashboardController@addUser');
});







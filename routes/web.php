<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Set the locale
$languages = Config::get('app.available_locales');
$allLanguages = Config::get('app.locales');
$locale = Request::segment(1);

if (in_array($locale, $languages)) {
    App::setLocale($locale);
} else {
    // fall back to the default locale (en)
    $locale = null;
}

Route::group(['prefix' => $locale, 'before' => 'ssl.force|csrf'], function() {
   Route::get('/switch-language/{locale}', 'HomeController@switchLanguage')->name('switch-language')->where('locale', '(en|cn)');
});

Route::group(['prefix' => $locale, 'after' => 'setLocale', 'before' => 'ssl.force|csrf'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/our-story', 'HomeController@ourStory')->name('our-story');
    Route::get('/how-we-hire', 'HomeController@howWeHire')->name('how-we-hire');
    Route::get('/teams', 'HomeController@businessDevelopment')->name('teams');
    Route::any('/jobs', 'HomeController@jobs')->name('jobs');
    Route::any('/jobs/loadmore', 'HomeController@ajaxGetResults')->name('jobs.ajax');
    Route::get('/jobs/detail/{id}', array('as' => 'jobs-detail', 'uses' => 'HomeController@jobsDetail'))->where(array('id' => '[0-9]+'));
    Route::get('/jobs/apply', array('as' => 'jobs-apply', 'uses' => 'HomeController@jobsApply'));
    Route::post('/jobs/apply-submit', array('as' => 'jobs-apply-submit', 'uses' => 'HomeController@jobsApplySubmit'));
    Route::get('/jobs/apply-question/{id}', array('as' => 'jobs-apply-question', 'uses' => 'HomeController@JobsApplyQuestion'))->where(array('id' => '[0-9]+'));
    Route::any('/jobs/apply-complete', 'HomeController@JobsApplyComplete')->name('jobs-apply-complete');

    Route::get('/sync/sync-greenhouse-jobs', 'SyncController@syncGreenhouseJobsByJobboard')->name('sync-greenhouse-jobs');
    Route::get('/sync/sync-greenhouse-jobs-status', 'SyncController@syncJobsStatusByJobboard')->name('sync-greenhouse-jobs-status');
    Route::get('/sync/generate-search-index', 'SyncController@generateSearchIndex')->name('generate-search-index');


});







/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| We don't use Auth::routes() helper here, but manually add the routes as we
| don't want the registration routes
*/

Route::group(['prefix' => 'comasy'], function () {

    // Auth::routes();

    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('comasy.login');
    Route::post('login', 'Auth\LoginController@login')->name('comasy.login.post');
    Route::get('logout', 'Auth\LoginController@logout')->name('comasy.logout');

    // Registration Routes...
    // Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    // Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('comasy.password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('comasy.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('comasy.password.reset.token');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('comasy.password.reset.post');

});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'comasy', 'middleware' => 'auth'], function () {

    Route::get('/', 'Admin\AdminController@showDashboard')->name('comasy.dashboard');

    Route::get('jobs/data', 'Admin\JobsController@getDatatableData')->name('comasy.jobs.data');
    Route::get('application/data', 'Admin\ApplicationController@getDatatableData')->name('comasy.application.data');
    Route::get('user/data', 'Admin\UserController@getDatatableData')->name('comasy.user.data');

    // Search
    Route::get('/search/re-index', 'Admin\AdminController@generateSearchIndex')->name('comasy.search.index');


    // Jobs CRUD
    Route::resource('jobs', 'Admin\JobsController', ['names' => [
        'index'     => 'comasy.jobs.index',
        'create'    => 'comasy.jobs.create',
        'store'     => 'comasy.jobs.store',
        'show'      => 'comasy.jobs.show',
        'edit'      => 'comasy.jobs.edit',
        'update'    => 'comasy.jobs.update',
        'destroy'   => 'comasy.jobs.destroy',
    ]]);

    // Apply CRUD
    Route::resource('application', 'Admin\ApplicationController', ['names' => [
        'index'     => 'comasy.application.index',
        'create'    => 'comasy.application.create',
        'store'     => 'comasy.application.store',
        'show'      => 'comasy.application.show',
        'edit'      => 'comasy.application.edit',
        'update'    => 'comasy.application.update',
        'destroy'   => 'comasy.application.destroy',
    ]]);

    // User CRUD
    Route::resource('user', 'Admin\UserController', ['names' => [
        'index'     => 'comasy.user.index',
        'create'    => 'comasy.user.create',
        'store'     => 'comasy.user.store',
        'show'      => 'comasy.user.show',
        'edit'      => 'comasy.user.edit',
        'update'    => 'comasy.user.update',
        'destroy'   => 'comasy.user.destroy',
    ]]);


});

// Auth::routes();








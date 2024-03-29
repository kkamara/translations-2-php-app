<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Mail\Test as TestMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\TestJob;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/job', function() {
    Log::debug('here');
    TestJob::dispatch()
        ->onConnection('redis')
        ->onQueue('stuff');
    return response('Success');
});

Route::get('/email', function () {
    Log::debug('test');
    
    $email = new TestMail();
    Mail::to('recipient@localhost')->send($email);
    return $email;
});

// Route::view('/{path?}', 'layouts.app')->where('path', '.*');

Route::get("/set-locale", function(Request $request) {
    App::setLocale("es");
    $request->session()->put("lang", "es");
    $locale = App::getLocale();
    return "Success: ".$locale;
});

Route::get("/", function(Request $request) {
    $locale = $request->session()->get("lang");
    return $locale;
});

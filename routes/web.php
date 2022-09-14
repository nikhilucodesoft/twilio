<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get(
    '/',
    ['as' => 'home', function () {
        return response()->view('index');
    }]
);
Route::post(
    '/token',
    ['uses' => 'TokenController@newToken', 'as' => 'new-token']
);
Route::get(
    '/dashboard',
    ['uses' => 'DashboardController@dashboard', 'as' => 'dashboard']
);
Route::post(
    '/ticket',
    ['uses' => 'TicketController@newTicket', 'as' => 'new-ticket']
);
Route::post(
    '/support/call',
    ['uses' => 'CallController@newCall', 'as' => 'new-call']
);

// ----------------IVR Calling----------------------------------------------------------//
Route::group(
    ['prefix' => 'ivr'],
    function () {
        Route::post(
            '/welcome',
            [
                'as' => 'welcome',
                'uses' => 'IvrController@showWelcome'
            ]
        );
        Route::get(
            '/main-menu',
            [
                'as' => 'main-menu',
                'uses' => 'MainMenuController@showMenuResponse'
            ]
        );
        Route::get(
            '/main-menu-redirect',
            [
                'as' => 'main-menu-redirect',
                'uses' => 'MainMenuController@showMainMenuRedirect'
            ]
        );
        Route::get(
            '/extension',
            [
                'as' => 'extension-connection',
                'uses' => 'ExtensionController@showExtensionConnection'
            ]
        );
        Route::post(
            '/agent/{agent}/voicemail',
            [
                'as' => 'agent-voicemail',
                'uses' => 'AgentCallController@agentVoicemail'
            ]
        );
        Route::post(
            '/agent/screen-call',
            [
                'as' => 'screen-call',
                'uses' => 'AgentCallController@screenCall'
            ]
        );
        Route::get(
            '/agent/connect-message',
            [
                'as' => 'connect-message',
                'uses' => 'AgentCallController@showConnectMessage'
            ]
        );
        Route::get(
            '/agent/hangup',
            [
                'as' => 'hangup',
                'uses' => 'AgentCallController@showHangup'
            ]
        );
        Route::post(
            '/agent/{agent}/recording',
            [
                'as' => 'store-recording',
                'uses' => 'RecordingController@storeRecording'
            ]
        );
    }
);
Route::get(
    '/recording',
    [
        'as' => 'agent-recordings',
        'uses' => 'RecordingController@indexByAgent'
    ]
);

//------------------------ Survey-------------------------------------------------------//

Route::group(
    ['prefix' => 'survey'],
    function () {
        Route::get(
            '/{survey}/results',
            ['as' => 'survey.results', 'uses' => 'Survey\SurveyController@showResults']
        );
        Route::get(
            '/',
            ['as' => 'root', 'uses' => 'Survey\SurveyController@showFirstSurveyResults']
        );
        Route::post(
            '/voice/connect',
            ['as' => 'voice.connect', 'uses' => 'Survey\SurveyController@connectVoice']
        );
        Route::post(
            '/sms/connect',
            ['as' => 'sms.connect', 'uses' => 'Survey\SurveyController@connectSms']
        );
        Route::get(
            '/{id}/voice',
            ['as' => 'survey.show.voice', 'uses' => 'Survey\SurveyController@showVoice']
        );
        Route::get(
            '/{id}/sms',
            ['as' => 'survey.show.sms', 'uses' => 'Survey\SurveyController@showSms']
        );
        Route::get(
            '/{survey}/question/{question}/voice',
            ['as' => 'question.show.voice', 'uses' => 'Survey\QuestionController@showVoice']
        );
        Route::get(
            '/{survey}/question/{question}/sms',
            ['as' => 'question.show.sms', 'uses' => 'Survey\QuestionController@showSms']
        );
        Route::post(
            '/{survey}/question/{question}/response/voice',
            ['as' => 'response.store.voice', 'uses' => 'Survey\QuestionResponseController@storeVoice']
        );
        Route::post(
            '/{survey}/question/{question}/response/sms',
            ['as' => 'response.store.sms', 'uses' => 'Survey\QuestionResponseController@storeSms']
        );
        Route::post(
            '/{survey}/question/{question}/response/transcription',
            ['as' => 'response.transcription.store', 'uses' => 'Survey\QuestionResponseController@storeTranscription']
        );
    }
);

//------------------------SMS Functionality----------------------------------------------// 

Route::group(
    ['prefix' => 'sms'],
    function () {
        Route::get('/', 'Sms\HomeController@show');
        Route::post('/', 'Sms\HomeController@storePhoneNumber');
        Route::post('/custom', 'Sms\HomeController@sendCustomMessage')->name('sms.custom');
    }
);

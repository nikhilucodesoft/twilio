<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Twilio\TwiML\VoiceResponse;

class IvrController extends Controller
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function showWelcome()
    {
        $response = new VoiceResponse();
        $gather = $response->gather(
            ['numDigits' => 1,
             'action' => route('main-menu', [], false),
             'method' => 'GET']
        );

        // $gather->play(
        //     'https://deved-sample-assets-2691.twil.io/et-phone.mp3',
        //     ['loop' => 1]
        // );
        $gather->say(
            'Press 1 to listen the instruction' .
            ' Press 2 to call our customer executive',
            ['voice' => 'alice', 'language' => 'en-GB']
        );


        return $response;
    }
}

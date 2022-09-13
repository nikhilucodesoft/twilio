<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use Twilio\TwiML\VoiceResponse;
 


class ExtensionController extends Controller
{
    /**
     * Responds with a <Dial> to the caller's planet
     *
     * @return \Illuminate\Http\Response
     */
    public function showExtensionConnection(Request $request)
    {  
        $selectedOption = $request->input('Digits');
        try {
            $agent = $this->_getAgentForDigit($selectedOption);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('main-menu-redirect');
        }
        $numberToDial = $agent->phone_number;
        $response = new VoiceResponse();
        $response->say(
            "You'll be connected shortly to your planet. " .
                $this->_thankYouMessage,
            ['voice' => 'alice', 'language' => 'en-GB']
        );
        $dialCommand = $response->dial($numberToDial, ['action' => '/ivr/agent/'.$selectedOption.'/voicemail',
        'method' => 'POST']);
        // $dialCommand = $response->dial(
        //     [
        //         'action' => route('agent-voicemail', ['agent' => $agent->id], false),
        //         'method' => 'POST'
        //     ]
        // );
        $dialCommand->number($numberToDial);
         
    
        return $response;
    }

    private function _getAgentForDigit($digit)
    {
        $planetExtensions = [
            '2' => 'Brodo',
            '3' => 'Dagobah',
            '4' => 'Oober'
        ];
        $planetExtensionExists = isset($planetExtensions[$digit]);

        if ($planetExtensionExists) {
            $agent = Agent::where(
                'extension',
                '=',
                $planetExtensions[$digit]
            )->firstOrFail();

            return $agent;
        } else {
            throw new ModelNotFoundException;
        }
    }
}

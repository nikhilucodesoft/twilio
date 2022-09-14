<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\UsersPhoneNumber;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class HomeController extends Controller
{

    /**
     * Show the forms with users phone number details.
     *
     * @return Response
     */
    public function show()
    {
        $users = UsersPhoneNumber::all();
        return view('sms.welcome', compact("users"));
    }

    /**
     * Store a new user phone number.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storePhoneNumber(Request $request)
    {
        //run validation on data sent in
        $validatedData = $request->validate([
            'phone_number' => 'required|unique:users_phone_number|numeric',
        ]);

        $user_phone_number_model = new UsersPhoneNumber($request->all());
        $this->sendMessage('User registration successfull!!', $request->phone_number);
        $user_phone_number_model->save();
        return back()->with(['success' => "{$request->phone_number} registered"]);
    }

    /**
     * Send message to a selected users
     */
    public function sendCustomMessage(Request $request)
    {
        $validatedData = $request->validate([
            'users' => 'required|array',
            'body' => 'required',
        ]);
        $recipients = $validatedData["users"];
        // iterate over the arrray of recipients and send a twilio request for each
        foreach ($recipients as $recipient) {
            $this->sendMessage($validatedData["body"], $recipient);
        }
        return back()->with(['success' => "Messages on their way!"]);
    }

    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recepientv
     */
    private function sendMessage($message, $recipient)
    {
        $account_sid = config('services.twilio')['accountSid'];
        $auth_token =config('services.twilio')['token'];
        $twilio_number =config('services.twilio')['number'];
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipient, array('from' => $twilio_number, 'body' => $message));
    }
}

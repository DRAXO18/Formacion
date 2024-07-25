<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $client = new Client();
        $apiKey = env('OPENAI_API_KEY');
        $message = $request->input('message');

        try {
            $response = $client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'prompt' => $message,
                    'max_tokens' => 150,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $reply = $data['choices'][0]['text'];

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

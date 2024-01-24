<?php

namespace App\Http\Controllers;

use App\Models\telegrambot;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo "ok";
        // file_put_contents("C:\Users\kazaev\Desktop\asdsdfsadf\access.log", file_get_contents("C:\Users\kazaev\Desktop\asdsdfsadf\access.log") . "\n" . json_encode(request()->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        $data = request()->all();
        $chat_id = $data['message']['chat']['id'];
        $text = $data['message']['text'];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(telegrambot $telegrambot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, telegrambot $telegrambot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(telegrambot $telegrambot)
    {
        //
    }
}

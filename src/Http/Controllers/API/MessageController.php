<?php

namespace Ariefadjie\Laravai\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use OpenAI\Laravel\Facades\OpenAI;

class MessageController extends Controller
{
    public function handleTelegram(Request $request)
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

        // Create an instance
        $botman = BotManFactory::create(config('botman'));

        // Give the bot something to listen for.
        $botman->hears('{message}', function (BotMan $bot, $message) {
            $bot->reply($this->openAiReply($message));
        });

        // Start listening
        $botman->listen();
    }

    public function openAiReply($message)
    {
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $message]
            ],
            'max_tokens' => 256,
        ]);

        return $result['choices'][0]['message']['content'];
    }
}

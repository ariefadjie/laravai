<?php

namespace Ariefadjie\Laravai\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use OpenAI\Laravel\Facades\OpenAI;
use Ariefadjie\Laravai\Services\Scraper;
use Ariefadjie\Laravai\Services\Tokenizer;
use Ariefadjie\Laravai\Services\Ai;

class MessageController extends Controller
{
    protected Scraper $scraper;
    protected Tokenizer $tokenizer;
    protected Ai $ai;

    public function __construct(Scraper $scraper, Tokenizer $tokenizer, Ai $ai)
    {
        $this->scraper = $scraper;
        $this->tokenizer = $tokenizer;
        $this->ai = $ai;
    }

    public function debug(): array
    {
        $url = 'https://www.detik.com/sumut/berita/d-6998827/daftar-pasangan-bakal-capres-dan-cawapres-pilpres-2024-siapa-saja';

        $content = $this->scraper->get($url);

        $wordChunks = $this->tokenizer->wordChunks($content);

        $context = $wordChunks[0];

        $question = 'Siapa wakil prabowo di 2024?';

        $response = $this->ai->askQuestionByContext($context, $question);
        return [
            'url' => $url,
            'context' => $context,
            'question' => $question,
            'response' => $response,
        ];
    }

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

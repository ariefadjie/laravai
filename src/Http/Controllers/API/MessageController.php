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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

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

    public function debug(): JsonResponse
    {
        $url = 'https://www.detik.com/sumut/berita/d-6998827/daftar-pasangan-bakal-capres-dan-cawapres-pilpres-2024-siapa-saja';

        $content = $this->scraper->get($url);

        $wordChunks = $this->tokenizer->wordChunks($content);

        $context = $wordChunks[0];

        $question = 'Siapa wakil prabowo di 2024?';

        $response = $this->ai->askQuestionByContext($context, $question);
        return response()->json([
            'url' => $url,
            'context' => $context,
            'question' => $question,
            'response' => $response,
        ]);
    }

    public function handleTelegram(Request $request)
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

        // Create an instance
        $botman = BotManFactory::create(config('botman'));

        // Give the bot something to listen for.
        $botman->hears('{message}', function (BotMan $bot, $message) {
            $bot->reply($this->ai->askQuestion($message));
        });

        // Start listening
        $botman->listen();
    }

    public function handleChat(Request $request, string $embed): JsonResponse
    {
        $question = $request->input('message');

        $answer = $this->ai->askQuestion($question);

        return response()->json([
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function handleChatByContext(Request $request, string $embed): JsonResponse
    {
        $question = $request->input('message');
        $questionVector = json_encode($this->ai->getVector($question));

        $chunks = DB::table('embedding_chunks')
        ->select("text")
        ->selectSub("vector <=> '{$questionVector}'::vector", "distance")
        ->where('embedding_guid', $embed)
        ->orderBy('distance', 'asc')
        ->limit(1)
        ->get();
        $context = $chunks->map(function ($chunk) {
            return $chunk->text;
        })->implode(' ');

        $answer = $this->ai->askQuestionByContext($context, $question);

        return response()->json([
            'context' => $context,
            'question' => $question,
            'answer' => $answer,
        ]);
    }
}

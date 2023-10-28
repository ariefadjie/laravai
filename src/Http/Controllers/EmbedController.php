<?php

namespace Ariefadjie\Laravai\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ariefadjie\Laravai\Services\Scraper;
use Ariefadjie\Laravai\Services\Tokenizer;
use Ariefadjie\Laravai\Services\Ai;
use Ariefadjie\Laravai\Models\Embedding;

class EmbedController extends Controller
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

    public function create()
    {
        return view('laravai::embed');
    }

    public function store(Request $request)
    {
        $scraper = $this->scraper->get($request->input('url'));

        $wordChunks = $this->tokenizer->wordChunks($scraper['body']);

        $embedding = Embedding::create([
            'title' => $scraper['title'],
            'url' => $request->input('url'),
        ]);

        foreach($wordChunks as $text) {
            try {
                $vector = $this->ai->getVector($text);

                $embedding->chunks()->create([
                   'text' => $text,
                   'vector' =>  json_encode($vector),
                ]);
            } catch (\Throwable $th) {
                \Log::warning($th->getMessage());
            }
        }

        return redirect()->route('ariefadjie.laravai.chat.show', ['embed' => $embedding->getKey()]);
    }
}

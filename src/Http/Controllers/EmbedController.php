<?php

namespace Ariefadjie\Laravai\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ariefadjie\Laravai\Services\Scraper;
use Ariefadjie\Laravai\Services\Tokenizer;
use Ariefadjie\Laravai\Services\Ai;

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
        $content = $this->scraper->get($request->input('url'));

        $wordChunks = $this->tokenizer->wordChunks($content);

        return $wordChunks;
    }
}

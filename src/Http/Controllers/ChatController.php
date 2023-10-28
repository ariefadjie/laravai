<?php

namespace Ariefadjie\Laravai\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ariefadjie\Laravai\Models\Embedding;

class ChatController extends Controller
{
    public function show(Request $request, string $embed)
    {
        $embedding = Embedding::findOrFail($embed);

        return view('laravai::chat', compact('embedding'));
    }
}

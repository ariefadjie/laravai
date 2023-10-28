<?php

namespace Ariefadjie\Laravai\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    public function show(Request $request)
    {
        return view('laravai::chat');
    }
}

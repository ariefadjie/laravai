<?php

namespace Ariefadjie\Laravai\Services;

class Tokenizer
{
    public function tokenize(string $text, int $chunk = 256): array
    {
        $tokens = explode(' ', $text);

        return array_chunk($tokens, $chunk);
    }

    public function wordChunks(string $text, int $chunk = 256): array
    {
        $tokens = $this->tokenize($text, $chunk);

        return collect($tokens)->map(function ($wordChunk) {
            return implode(' ', $wordChunk);
        })->all();
    }
}

<?php

namespace Ariefadjie\Laravai\Services;

use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\StreamResponse;

class Ai
{
    public function askQuestion(string $question, $maxToken = 256): string
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $question]
            ],
            'max_tokens' => $maxToken,
        ]);

        return $response['choices'][0]['message']['content'];
    }

    public function askQuestionStream(string $question, $maxToken = 256): StreamResponse
    {
        $responses = OpenAI::chat()->createStreamed([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $question]
            ],
            'max_tokens' => $maxToken,
        ]);

        return $responses;
    }

    public function askQuestionByContext(string $context, string $question): string
    {
        $system_template = "
        Use the following pieces of context to answer the users question. 
        If you don't know the answer, just say that you don't know, don't try to make up an answer.
        ----------------
        {context}
        ";
        $system_prompt = str_replace("{context}", $context, $system_template);

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            // 'temperature' => 0.8,
            'messages' => [
                ['role' => 'system', 'content' => $system_prompt],
                ['role' => 'user', 'content' => $question],
            ],
        ]);

        return $response['choices'][0]['message']['content'];
    }

    public function getVector(string $text): array
    {
        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => $text,
        ]);

        return $response['data'][0]['embedding'];
    }
}

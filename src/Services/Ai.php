<?php

namespace Ariefadjie\Laravai\Services;

use OpenAI\Laravel\Facades\OpenAI;

class Ai
{
    public function askQuestionByContext(string $context, string $question)
    {
        $system_template = "
        Use the following pieces of context to answer the users question. 
        If you don't know the answer, just say that you don't know, don't try to make up an answer.
        ----------------
        {context}
        ";
        $system_prompt = str_replace("{context}", $context, $system_template);

        $openAi = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            // 'temperature' => 0.8,
            'messages' => [
                ['role' => 'system', 'content' => $system_prompt],
                ['role' => 'user', 'content' => $question],
            ],
        ]);

        return response()->json($openAi);
    }
}

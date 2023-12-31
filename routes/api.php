<?php

use Ariefadjie\Laravai\Http\Controllers\API\MessageController;

Route::post('api/messages/telegram', [MessageController::class, 'handleTelegram']);
Route::post('api/chat/{embed}', [MessageController::class, 'handleChatStream']);

Route::get('api/debug', [MessageController::class, 'debug']);

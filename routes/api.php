<?php

Route::post('api/messages/telegram', [Ariefadjie\Laravai\Http\Controllers\API\MessageController::class, 'handleTelegram']);
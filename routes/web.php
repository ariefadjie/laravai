<?php

use Ariefadjie\Laravai\Http\Controllers\EmbedController;
use Ariefadjie\Laravai\Http\Controllers\ChatController;

Route::middleware('web')->name('ariefadjie.laravai.')->group(function () {
    Route::get('embed', [EmbedController::class, 'create'])->name('embed.create');
    Route::post('embed', [EmbedController::class, 'store'])->name('embed.store');
    Route::get('chat/{embed}', [ChatController::class, 'show'])->name('chat.show');
});

<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

 
Artisan::command('news:publish-scheduled', function () {
    $count = \App\Models\News::where('status', 'scheduled')
        ->where('is_published', false)
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->update(['status' => 'published', 'is_published' => true]);

    $this->info("Noticias publicadas: {$count}");
})->purpose('Publicar noticias programadas cuya fecha ya llegó');

\Illuminate\Support\Facades\Schedule::command('news:publish-scheduled')->everyMinute()->withoutOverlapping();

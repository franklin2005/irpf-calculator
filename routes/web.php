<?php

use App\Domain\Irpf\ValueObjects\Region;
use App\Livewire\Irpf\IrpfCalculatorPage;
use App\Livewire\Irpf\RegionInfoPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/ui', function () {
    return view('ui');
});

Route::get('/aviso-legal', function () {
    return view('legal.notice');
})->name('legal.notice');

Route::get('/politica-privacidad', function () {
    return view('legal.privacy');
})->name('legal.privacy');

Route::get('/politica-cookies', function () {
    return view('legal.cookies');
})->name('legal.cookies');

Route::get('/robots.txt', function () {
    $robotsPath = public_path('robots.txt');
    $content = file_exists($robotsPath)
        ? file_get_contents($robotsPath)
        : "User-agent: *\nDisallow:\nSitemap: ".url('/sitemap.xml')."\n";

    return response($content, 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
});

Route::get('/sitemap.xml', function () {
    $years = IrpfCalculatorPage::SUPPORTED_YEARS;
    $urls = [route('home')];

    foreach ($years as $year) {
        $urls[] = route('irpf.calculator', ['year' => $year]);

        foreach (Region::cases() as $region) {
            $urls[] = route('irpf.region.show', [
                'year' => $year,
                'regionSlug' => $region->value,
            ]);
        }
    }

    $urls = array_values(array_unique($urls));

    $lastmod = now()->toDateString();
    $urlNodes = collect($urls)->map(function (string $location) use ($lastmod): string {
        return <<<XML
    <url>
        <loc>{$location}</loc>
        <lastmod>{$lastmod}</lastmod>
    </url>
XML;
    })->implode("\n");

    $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{$urlNodes}
</urlset>
XML;

    return response($xml, 200)
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::get('/calculadora-irpf/{year}', IrpfCalculatorPage::class)
    ->whereNumber('year')
    ->whereIn('year', ['2025', '2026'])
    ->name('irpf.calculator');

Route::get('/irpf/{year}/{regionSlug}', RegionInfoPage::class)
    ->whereNumber('year')
    ->whereIn('year', ['2025', '2026'])
    ->name('irpf.region.show');

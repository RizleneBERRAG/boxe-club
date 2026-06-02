<?php

$base = 'http://127.0.0.1:8000';

$pages = [
    '/'                => 'docs/index.html',
    '/le-club'         => 'docs/le-club/index.html',
    '/cours-horaires'  => 'docs/cours-horaires/index.html',
    '/tarifs'          => 'docs/tarifs/index.html',
    '/contact'         => 'docs/contact/index.html',
];

foreach ($pages as $url => $path) {

    $html = @file_get_contents($base . $url);

    if ($html === false) {
        echo "Erreur : $url\n";
        continue;
    }

    // Remplace TOUTES les urls Laravel locales
    $html = str_replace(
        'http://127.0.0.1:8000',
        '/boxe-club',
        $html
    );

    // Corrige les assets
    $html = str_replace(
        'href="/assets/',
        'href="/boxe-club/assets/',
        $html
    );

    $html = str_replace(
        'src="/assets/',
        'src="/boxe-club/assets/',
        $html
    );

    $fullPath = __DIR__ . '/' . $path;

    @mkdir(dirname($fullPath), 0777, true);

    file_put_contents($fullPath, $html);

    echo "OK : $path\n";
}

echo "Export terminé.\n";

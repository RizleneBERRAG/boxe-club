<?php

$base = 'http://127.0.0.1:8000';
$repoBase = '/boxe-club';

$pages = [
    '/' => 'docs/index.html',
    '/le-club' => 'docs/le-club/index.html',
    '/cours-horaires' => 'docs/cours-horaires/index.html',
    '/tarifs' => 'docs/tarifs/index.html',
    '/contact' => 'docs/contact/index.html',
];

@mkdir(__DIR__ . '/docs', 0777, true);

foreach ($pages as $url => $path) {
    $html = @file_get_contents($base . $url);

    if ($html === false) {
        echo "Erreur : $url\n";
        continue;
    }

    // Assets CSS / JS / images / vidéos
    $html = str_replace($base . '/assets/', $repoBase . '/assets/', $html);
    $html = str_replace('/assets/', $repoBase . '/assets/', $html);

    // Liens internes
    $html = str_replace($base . '/le-club', $repoBase . '/le-club/', $html);
    $html = str_replace($base . '/cours-horaires', $repoBase . '/cours-horaires/', $html);
    $html = str_replace($base . '/tarifs', $repoBase . '/tarifs/', $html);
    $html = str_replace($base . '/contact', $repoBase . '/contact/', $html);
    $html = str_replace($base . '/', $repoBase . '/', $html);

    $html = str_replace('href="/le-club"', 'href="' . $repoBase . '/le-club/"', $html);
    $html = str_replace('href="/cours-horaires"', 'href="' . $repoBase . '/cours-horaires/"', $html);
    $html = str_replace('href="/tarifs"', 'href="' . $repoBase . '/tarifs/"', $html);
    $html = str_replace('href="/contact"', 'href="' . $repoBase . '/contact/"', $html);
    $html = str_replace('href="/"', 'href="' . $repoBase . '/"', $html);

    $fullPath = __DIR__ . '/' . $path;
    @mkdir(dirname($fullPath), 0777, true);

    file_put_contents($fullPath, $html);

    echo "OK : $path\n";
}

echo "Export terminé.\n";

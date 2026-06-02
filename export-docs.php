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

    // Corrige les chemins assets pour GitHub Pages
    $html = str_replace($base . '/assets/', $repoBase . '/assets/', $html);
    $html = str_replace($base . '/storage/', $repoBase . '/storage/', $html);

    // Corrige les chemins absolus Laravel
    $html = str_replace('href="/assets/', 'href="' . $repoBase . '/assets/', $html);
    $html = str_replace('src="/assets/', 'src="' . $repoBase . '/assets/', $html);

    $html = str_replace('href="/storage/', 'href="' . $repoBase . '/storage/', $html);
    $html = str_replace('src="/storage/', 'src="' . $repoBase . '/storage/', $html);

    // Corrige les data-base utilisés par certains scripts/images
    $html = str_replace('data-base="/assets/', 'data-base="' . $repoBase . '/assets/', $html);

    // Corrige les liens internes
    $html = str_replace('href="/le-club"', 'href="' . $repoBase . '/le-club/"', $html);
    $html = str_replace('href="/cours-horaires"', 'href="' . $repoBase . '/cours-horaires/"', $html);
    $html = str_replace('href="/tarifs"', 'href="' . $repoBase . '/tarifs/"', $html);
    $html = str_replace('href="/contact"', 'href="' . $repoBase . '/contact/"', $html);
    $html = str_replace('href="/"', 'href="' . $repoBase . '/"', $html);

    // Sécurité : enlève le doublon si jamais il apparaît
    $html = str_replace('/boxe-club/boxe-club/', '/boxe-club/', $html);

    $fullPath = __DIR__ . '/' . $path;
    @mkdir(dirname($fullPath), 0777, true);

    file_put_contents($fullPath, $html);

    echo "OK : $path\n";
}

echo "Export terminé.\n";

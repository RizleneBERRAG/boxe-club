<?php

$base = 'http://127.0.0.1:8000';

$pages = [
    '/' => 'docs/index.html',
    '/le-club' => 'docs/le-club/index.html',
    '/cours-horaires' => 'docs/cours-horaires/index.html',
    '/tarifs' => 'docs/tarifs/index.html',
    '/contact' => 'docs/contact/index.html',
    '/mentions-legales' => 'docs/mentions-legales/index.html',
];

@mkdir(__DIR__ . '/docs', 0777, true);

foreach ($pages as $url => $path) {
    $html = file_get_contents($base . $url);

    if ($html === false) {
        echo "Erreur : $url\n";
        continue;
    }

    $fullPath = __DIR__ . '/' . $path;
    @mkdir(dirname($fullPath), 0777, true);

    file_put_contents($fullPath, $html);

    echo "OK : $path\n";
}

echo "Export terminé.\n";

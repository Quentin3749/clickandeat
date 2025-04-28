<?php
// Script pour trouver toutes les occurrences de 'rôle' (avec accent) dans le projet
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__)) as $file) {
    if ($file->isFile() && in_array($file->getExtension(), ['php', 'blade.php'])) {
        $lines = file($file->getPathname());
        foreach ($lines as $num => $line) {
            if (mb_strpos($line, 'rôle') !== false) {
                echo $file->getPathname() . ' (ligne ' . ($num+1) . ') : ' . trim($line) . PHP_EOL;
            }
        }
    }
}

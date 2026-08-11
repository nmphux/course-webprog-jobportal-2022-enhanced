<?php
$dir = __DIR__ . '/src/Views';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($it as $file) {
    if ($file->getExtension() !== 'php') continue;
    $c = file_get_contents($file->getPathname());
    if (strpos($c, 'JobPortal') !== false) {
        echo $file->getPathname() . " => " . substr_count($c, 'JobPortal') . " matches\n";
    }
}
// Also check header.php for brand
$header = file_get_contents(__DIR__ . '/src/Views/layouts/header.php');
if (strpos($header, 'JobPortal') !== false) {
    echo "\nheader.php brand line:\n";
    foreach (explode("\n", $header) as $i => $line) {
        if (strpos($line, 'JobPortal') !== false) {
            echo "  Line " . ($i+1) . ": " . trim($line) . "\n";
        }
    }
}
// Check login/register
foreach (['login.php', 'register.php'] as $f) {
    $fp = __DIR__ . '/src/Views/auth/' . $f;
    if (file_exists($fp)) {
        $c = file_get_contents($fp);
        if (strpos($c, 'JobPortal') !== false) {
            echo "\n$f brand lines:\n";
            foreach (explode("\n", $c) as $i => $line) {
                if (strpos($line, 'JobPortal') !== false) {
                    echo "  Line " . ($i+1) . ": " . trim($line) . "\n";
                }
            }
        }
    }
}
echo "\nDone.\n";

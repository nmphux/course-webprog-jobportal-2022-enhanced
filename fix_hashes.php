<?php
$sql = file_get_contents(__DIR__ . '/database.sql');
$old = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
$new = '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS';
$count = 0;
$sql = str_replace($old, $new, $sql, $count);
if ($count === 0) {
    echo "WARNING: No replacements made. Checking if old hash exists...\n";
    echo "Old hash exists: " . (strpos($sql, $old) !== false ? 'YES' : 'NO') . "\n";
}
file_put_contents(__DIR__ . '/database.sql', $sql);
echo "Replaced $count occurrences.\n";

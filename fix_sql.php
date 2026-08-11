<?php
$sql = file_get_contents(__DIR__ . '/database.sql');

$hash = '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS';

// Windows line endings
$search = "'seeker1@gmail.com', '" . $hash . "', 0),\r\n\r\n(5, 'Rajesh Sharma'";
$replace = "'seeker1@gmail.com', '" . $hash . "', 0),\r\n(3, 'Cao Thi Quynh Dao', 'seeker2@gmail.com', '" . $hash . "', 0),\r\n(4, 'Nguyen Minh Quan', 'employer1@gmail.com', '" . $hash . "', 1),\r\n(5, 'Rajesh Sharma'";

if (strpos($sql, $search) !== false) {
    $sql = str_replace($search, $replace, $sql);
    file_put_contents(__DIR__ . '/database.sql', $sql);
    echo "Fixed successfully!\n";
} else {
    echo "Pattern not found.\n";
    // Try with \n only
    $search2 = "'seeker1@gmail.com', '" . $hash . "', 0),\n\n(5, 'Rajesh Sharma'";
    if (strpos($sql, $search2) !== false) {
        echo "Found with \\n line endings.\n";
    }
    $pos = strpos($sql, 'Vo Hoang Nhat Anh');
    if ($pos !== false) {
        $ctx = substr($sql, $pos, 300);
        echo "Context: " . $ctx . "\n";
        echo "Bytes: ";
        for ($i = 0; $i < strlen($ctx); $i++) {
            $b = ord($ctx[$i]);
            if ($b < 32) echo "[$b]";
            else echo $ctx[$i];
        }
        echo "\n";
    }
}

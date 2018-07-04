<?php


require_once dirname(__FILE__) . '/base.php';

$summary = [];
foreach(['css', 'js'] as $subdir) {
    $dir = opendir(PUBLIC_CACHE_DIR . '/' . $subdir);

    while ($f = readdir($dir)) {
        if (!in_array($f, ['.', '..'])) {
            @unlink(PUBLIC_CACHE_DIR . '/' . $subdir . '/' . $f);
            $summary[] = $f;
        }
    }

}
echo "Deleted files: \n";
echo join("\n", $summary);
echo "\n";
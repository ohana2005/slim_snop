<?php



require_once dirname(__FILE__) . '/base.php';

$dir = opendir(CACHE_DIR);

$summary = [];
while($f = readdir($dir)){
    if(!in_array($f, ['.', '..'])){
        @unlink(CACHE_DIR . '/' . $f);
        $summary[] = $f;
    }
}

echo "Deleted files: \n";
echo join("\n", $summary);
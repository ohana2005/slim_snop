<?php


    require_once dirname(__FILE__) . '/base.php';

    $lang = !empty($argv[1]) ? $argv[1] : 'en';

    $path = CACHE_DIR . '/' . $lang . '.lang';

    if(!file_exists($path)){

        die('no such cache file ' . $path);

    }

    $data = unserialize(file_get_contents($path));

    $count = 0;
    foreach($data as $key => $value){
        if(!$value){

            $query = "SELECT * FROM `text_block` WHERE `name`=':name' and `application`='frontend'";
            $stmt = $pdo->query($query);
            $stmt->bindParam(':name', $key, PDO::PARAM_STR);
            $row = $stmt->fetch();
            if(!$row){
                $count++;
                $query = "INSERT INTO `text_block`(`name`, `application`) VALUES(:name, :application)";
                $stmt = $pdo->prepare($query);
                $application = 'frontend';
                $stmt->bindParam(':name', $key, PDO::PARAM_STR);
                $stmt->bindParam(':application', $application, PDO::PARAM_STR);

                $stmt->execute();

                $id = $pdo->lastInsertId();

                $query2 = "INSERT INTO `text_block_translation`(`id`, `text`, `lang`) VALUES(:id, :text, :lang)";
                $stmt2 = $pdo->prepare($query2);
                $stmt2->bindParam(':id', $id);
                $stmt2->bindParam(':text', $key, PDO::PARAM_STR);
                $stmt2->bindParam(':lang', $lang, PDO::PARAM_STR);

                $stmt2->execute();

            }

        }

    }

    echo "$count inserted";


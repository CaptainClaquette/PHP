<?php

function ScanDirectoryToTab($Directory) {
    $dirs = array();
    $MyDirectory = @opendir($Directory) or die('Erreur scan dir');
    while ($Entry = @readdir($MyDirectory)) {
        if (is_dir($Directory . '/' . $Entry) && $Entry != '.' && $Entry != '..') {
            array_push($dirs, $Entry);
            ScanDirectoryToTab($Directory . '/' . $Entry);
        }
    }
    @closedir($MyDirectory);
    sort($dirs);
    return $dirs;
}

function ScanDirectoryFileToTab($Directory) {
    $files = array();
    $MyDirectory = @opendir($Directory) or die('Erreur scan file');
    while ($Entry = @readdir($MyDirectory)) {
        if (is_dir($Directory . '/' . $Entry) && $Entry != '.' && $Entry != '..') {
            array_push($dirs, $Entry);
            ScanDirectory($Directory . '/' . $Entry, $gestion);
        } else {
			
            }
        }
    }
    @closedir($MyDirectory);
    return $files;
}

function createDirectory($dir) {
    $canCreate = "ok";
    $dirs = ScanDirectoryToTab("path_to_root_dir");
    for ($i = 0; $i < count($dirs); $i++) {
        if ($dirs[$i] == $dir) {
            $canCreate = "ko";
        }
    }
    if ($canCreate) {
        mkdir("path_to_root" . ucfirst($dir), 0755);
    }
    return $canCreate;
}

function deleteDirectory($Directory) {
    $MyDirectory = opendir($Directory) or die('Erreur delete');
    while ($Entry = @readdir($MyDirectory)) {
        if ($Entry != '.' && $Entry != '..') {
            if (is_dir($Directory . '/' . $Entry)) {
                deleteDirectory($Directory . '/' . $Entry);
                rmdir($Directory . '/' . $Entry);
            } else {
                unlink($Directory . '/' . $Entry);
            }
        }
    }
    rmdir($Directory);
}

?>

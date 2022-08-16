<?php

$fileUrls = unserialize(file_get_contents("files_config.txt"));

foreach (glob($fileUrls['folder_from'] . '\*') as $file) {
    copy($file, $fileUrls['folder_to'] . "/" . basename($file));
    unlink($file);
}

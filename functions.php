<?php
// показывать или нет выполненные задачи
include_once 'userdata.php';

function countProjectTasks($arTasks, $projectName) {
    $quantity = 0;
    if ($projectName == 'Все') {
        return count($arTasks);
    }
    foreach ($arTasks as $task) {
        if($task['category'] == $projectName) {
            $quantity++;
        }
    }
    return $quantity;
}

function renderTemplate($templatePath, $templateData) {

    if(file_exists($templatePath)) {
        ob_start('ob_gzhandler');
        require $templatePath;
        $html = ob_get_clean();

        return $html;
    }

    return '';
}

function isErrorDate($date) {
    return !strtotime($date) || $date != date("d.m.Y", strtotime($date));
}

function saveFile($file) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = finfo_file($finfo, $file_name);
    $file_url = $_SERVER['DOCUMENT_ROOT'].'/'. $file['name'];

  move_uploaded_file($file_name, $file_url);

  return $file_url;
}


function getUserFingerprint ($includeIp = true, $includeCity = true) {
    $ipAddr = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $geo_data = file_get_contents('https://freegeoip.net/json/' . $ipAddr);
    $geoData = json_decode($geo_data, true);
    $parts = [$userAgent, $geoData['country_code']];

    if($includeIp) {
        $parts[] = $ipAddr;
    }
    if($includeCity) {
        $parts[] = $geoData['city'];
    }

    $finger = implode('', $parts);
    $fingerPrint = md5($finger);

    return $fingerPrint;
}

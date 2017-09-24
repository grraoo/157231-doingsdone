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

/**
 * Проверяет неправильность введённой даты
 *
 * @param $date string присланная формой дата
 *
 * @return boolean true - неверный формат даты
 */

function isErrorDate($date) {
    return !strtotime($date) || $date != date("d.m.Y", strtotime($date));
}

/**
 * Сохраняет присланный файл в корень
 *
 * @param $file file присланный файл
 *
 * @return $file_url string путь к файлу
 */

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

/**
 * Ищет пользователя в массиве данных по e-mail
 *
 * @param $email string E-mail для поиска пользователя
 * @param array $users массив пользователей
 *
 * @return найденный пользователь
 */
function getUserByEmail ($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
 function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }


        $values = array_merge([$stmt, $types], $stmt_data);
        // print_r($values);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}


/**
 * Запрос на чтение данных из базы
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return $rows массив данных по запросу
 */
function selectDB ($con, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

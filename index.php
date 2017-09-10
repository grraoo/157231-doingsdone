<?php

require_once 'config.php';
require_once 'data.php';
require_once 'functions.php';

session_start();
if(isset($_GET['success'])) {
    array_unshift($tasks, $_SESSION['task']);
}

if(isset($_GET['project']) && !isset($projects[$_GET['project']])) {
    http_response_code(404);
}

if(isset($_GET['logout'])) {
    $_SESSION = [];
}

$login = isset($_GET['login']);
$isLoggedUser = isset($_SESSION['user']);
$userName = isset($_SESSION['user']) ? $_SESSION['user']['name'] : '';

$guestData  = [
    'login' => $login,
    'users' => $users
];

$category = isset($_GET['project']) ? $_GET['project'] : '';

$indexData = [
    'tasks' => $tasks,
    'projects' => $projects,
    'category' => $category
];

if(!$isLoggedUser) {
    $content = renderTemplate('templates/guest.php', $guestData);
} else {
    $content = renderTemplate('templates/index.php',$indexData);
}

$headerData = [
    'logged' => $isLoggedUser,
    'userName' => $userName,
];

$header = renderTemplate('templates/header.php', $headerData);

$loginData = [
    'login' => $login,
    'users' => $users
];

$loginModal = renderTemplate('templates/login_modal.php', $loginData);

$add = isset($_GET['add']);
$activeProject = isset($_GET['project']) ? $_GET['project'] : 0;
$title = $isLoggedUser ? 'Список задач' : 'Дела в порядке';

$layoutData = [
    'login' => $login,
    'header' => $header,
    'title' => $title,
    'projects' => $projects,
    'tasks' => $tasks,
    'content' => $content,
    'add' => $add,
    'category' => $activeProject,
    'userName' => $userName,
    'logged' => $isLoggedUser,
    'loginModal' => $loginModal
];

print(renderTemplate('templates/layout.php', $layoutData));

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

$isLoggedUser = isset($_SESSION['user']);

$guestData  = [
    'login' => isset($_GET['login']),
    'users' => $users
];

if(!$isLoggedUser) {
    print(renderTemplate('templates/guest.php', $guestData));
    die();
}

$showAll = isset($_GET['show_completed']) ? $_GET['show_completed'] : $show_complete_tasks;
$category = isset($_GET['project']) ? $_GET['project'] : '';

$indexData = [
    'tasks' => $tasks,
    'projects' => $projects,
    'showAll' => $showAll,
    'category' => $category
];

$content = renderTemplate('templates/index.php',$indexData);

$header = renderTemplate('templates/header.php', $headerData);

$add = isset($_GET['add']);
$activeProject = isset($_GET['project']) ? $_GET['project'] : 0;

$layoutData = [
    'header' => $header,
    'title' => 'Список задач',
    'projects' => $projects,
    'tasks' => $tasks,
    'content' => $content,
    'add' => $add,
    'category' => $activeProject,
    'userName' => $_SESSION['user']['name']
];

print(renderTemplate('templates/layout.php', $layoutData));

<?php

require_once 'config.php';
require_once 'data.php';
require_once 'functions.php';

if(isset($_GET['success'])) {
    array_unshift($tasks, [
        'name' => $_GET['name'],
        'date' => $_GET['date'],
        'category' => $_GET['category'],
        'isDone' => false
    ]);
}

if(isset($_GET['project']) && !isset($projects[$_GET['project']])) {
    http_response_code(404);
}

$showAll = isset($_GET['show_completed']) ? $_GET['show_completed'] : $show_complete_tasks;
$category = isset($_GET['project']) ? $_GET['project'] : '';

$indexData = [
    'tasks' => $tasks,
    'projects' => $projects,
    'showAll' => $showAll,
    'category' => $category
];

$content = renderTemplate('templates/index.php',$indexData );

$add = isset($_GET['add']);
$activeProject = isset($_GET['project']) ? $_GET['project'] : 0;

$layoutData = [
    'title' => 'Список задач',
    'user' => 'Grraoo',
    'projects' => $projects,
    'tasks' => $tasks,
    'content' => $content,
    'add' => $add,
    'category' => $activeProject
];

print(renderTemplate('templates/layout.php', $layoutData));

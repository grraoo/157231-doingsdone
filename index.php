<?php
ini_set('display_errors', 1);
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

    $indexData = [
        'tasks' => $tasks,
        'projects' => $projects,
        'showAll' => $show_complete_tasks
    ];

    $content = renderTemplate('templates/index.php',$indexData );

    $add = isset($_GET['add']);

    $layoutData = [
        'title' => 'Список задач',
        'user' => 'Grraoo',
        'projects' => $projects,
        'tasks' => $tasks,
        'content' => $content,
        'add' => $add
    ];

    print(renderTemplate('templates/layout.php', $layoutData));
?>

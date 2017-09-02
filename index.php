<?php
    require_once 'functions.php';

    if(!isset($projects[$_GET['project']])) {
        http_response_code(404);
    }

    $indexData = [
        'tasks' => $tasks,
        'projects' => $projects,
        'showAll' => $show_complete_tasks
    ];

    $content = renderTemplate('templates/index.php',$indexData );

    $layoutData = [
        'title' => 'Список задач',
        'user' => 'Grraoo',
        'projects' => $projects,
        'tasks' => $tasks,
        'content' => $content
    ];

    print(renderTemplate('templates/layout.php', $layoutData));
?>

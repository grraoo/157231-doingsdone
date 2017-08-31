<?php
    require_once 'functions.php';
    $indexData = ['tasks' => $tasks, 'showAll' => $show_complete_tasks];
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

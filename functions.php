<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$days = rand(-3, 3);
$task_deadline_ts = strtotime("+" . $days . " day midnight"); // метка времени даты выполнения задачи
$current_ts = strtotime('now midnight'); // текущая метка времени

// запишите сюда дату выполнения задачи в формате дд.мм.гггг
$date_deadline =   date("d.m.Y", $task_deadline_ts) ;

// в эту переменную запишите кол-во дней до даты задачи
$days_until_deadline = ($current_ts - $task_deadline_ts) / (60 * 60 * 24);

$projects = [
  "Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"
];

$tasks = [
  [
      'name' => 'Собеседование в IT компании',
      'date' => '01.06.2018',
      'category' => 'Работа',
      'isDone' => false
  ],
  [
      'name' => 'Выполнить тестовое задание',
      'date' => '25.05.2018',
      'category' => 'Работа',
      'isDone' => false
  ],
  [
      'name' => 'Сделать задание первого раздела',
      'date' => '21.04.2018',
      'category' => 'Учеба',
      'isDone' => true
  ],
  [
      'name' => 'Встреча с другом',
      'date' => '22.04.2018',
      'category' => 'Входящие',
      'isDone' => false
  ],
  [
      'name' => 'Купить корм для кота',
      'date' => '',
      'category' => 'Домашние дела',
      'isDone' => false
  ],
  [
      'name' => 'Заказать пиццу',
      'date' => '',
      'category' => 'Домашние дела',
      'isDone' => false
  ]
];

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

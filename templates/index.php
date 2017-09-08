<?php
    $tasks = $templateData['tasks'];
    $projects = $templateData['projects'];
    $category = $templateData['category'];

    $show_complete_tasks = isset($_GET['show_completed']) ? $_GET['show_completed'] : (isset($_COOKIE['showAll']) ? $_COOKIE['showAll'] : 0);

    setcookie("showAll", $show_complete_tasks, time()+3600, "/");
?>
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <div class="radio-button-group">
        <label class="radio-button">
            <input class="radio-button__input visually-hidden" type="radio" name="radio" checked="">
            <span class="radio-button__text">Все задачи</span>
        </label>

        <label class="radio-button">
            <input class="radio-button__input visually-hidden" type="radio" name="radio">
            <span class="radio-button__text">Повестка дня</span>
        </label>

        <label class="radio-button">
            <input class="radio-button__input visually-hidden" type="radio" name="radio">
            <span class="radio-button__text">Завтра</span>
        </label>

        <label class="radio-button">
            <input class="radio-button__input visually-hidden" type="radio" name="radio">
            <span class="radio-button__text">Просроченные</span>
        </label>
    </div>

    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input id="show-complete-tasks" class="checkbox__input visually-hidden" type="checkbox" <?= $show_complete_tasks ? 'checked' : '' ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($tasks as $key => $task):?>

        <?php $showComplete = ($show_complete_tasks || !$task['isDone']);?>
        <?php $currentCat = (!isset($_GET['project']) || $task['category'] === $projects[$category]);?>

        <?php if($showComplete && $currentCat): ?>

            <tr class="tasks__item task <?= $task['isDone'] ? ' task--completed' : '' ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox">
                        <span class="checkbox__text"><?=$task['name']?></span>
                    </label>
                </td>

                <td class="task__date">
                    <?=$task['date']?>
                </td>

                <td class="task__controls">
                    <?php if(!$task['isDone']): ?>
                        <button class="expand-control" type="button" name="button"><?=$task['name']?></button>

                        <ul class="expand-list hidden">
                            <li class="expand-list__item">
                                <a href="#">Выполнить</a>
                            </li>

                            <li class="expand-list__item">
                                <a href="#">Удалить</a>
                            </li>
                        </ul>
                    <?php endif;?>
                </td>
            </tr>
        <?php endif;?>
    <?php endforeach;?>

</table>

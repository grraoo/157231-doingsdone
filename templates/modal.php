<div class="modal">
<button class="modal__close" type="button" name="button">Закрыть</button>
<?php
$required = ['name', 'project', 'date'];
$errors = [];

$taskName = isset($_POST['name']) ? ($_POST['name']) : '';
$date = isset($_POST['date']) ? ($_POST['date']) : '';
$category = isset($_POST['project']) ? $_POST['project'] : '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {

    foreach($_POST as $key => $value) {
        if(in_array($key, $required) && $value == '') {
            $errors[] = $key;
        }
    }

    if(isErrorDate($date)) {
        $errors[] = 'date';
    }

    $name = isset($_POST['name']) ? urlencode(htmlspecialchars($_POST['name'])) : '';

    if(!count($errors)) {
        $preview = isset($_FILES['preview']) ? $_FILES['preview'] : false;
        if($preview){
            saveFile($preview);
        }

        header("Location: index.php?success=true&name=$name&date=$date&category=$category");
    }
}
?>
<h2 class="modal__heading">Добавление задачи</h2>
<form class="form" action="index.php?add=true" method="post" enctype="multipart/form-data">
    <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>
    <input class="form__input<?= in_array('name', $errors) ? ' form__input--error' : ''?>" type="text" name="name" id="name" value="<?=$taskName?>" placeholder="Введите название">
    <?php if(in_array('name', $errors)): ?>
        <span class="form__error">Напишите название задачи</span>
    <?php endif;?>
    </div>

    <div class="form__row">
    <label class="form__label" for="project">Проект <sup>*</sup></label>

    <select class="form__input form__input--select" name="project" id="project">
        <?php foreach($projects as $project):?>
            <?php if($project !== 'Все'): ?>
                <option value="<?= $project?>" <?= ($project == $category) ? 'selected' : ''?>><?=$project?></option>
            <?php endif;?>
        <?php endforeach;?>
    </select>

    </div>

    <div class="form__row">
    <label class="form__label" for="date">Дата выполнения <sup>*</sup></label>

    <input class="form__input form__input--date<?= in_array('date', $errors) ? ' form__input--error' : '' ?>" type="text" name="date" id="date" value="<?=$date?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?php if(in_array('date', $errors)): ?>
        <span class="form__error">Напишите дату задачи в формате <i>ДД.ММ.ГГГГ</i></span>
    <?php endif;?>
    </div>

    <div class="form__row">
    <label class="form__label">Файл</label>
    <div class="form__input-file">
        <input class="visually-hidden" type="file" name="preview" id="preview" value="">

        <label class="button button--transparent" for="preview">
            <span>Выберите файл</span>
        </label>
    </div>
    </div>

    <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
</div>

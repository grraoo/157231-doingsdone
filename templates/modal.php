
<div class="modal">
<button class="modal__close" type="button" name="button">Закрыть</button>
<?php
$required = ['name', 'project', 'date'];
$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $name = isset($_POST['name']) ? urlencode(htmlspecialchars($_POST['name'])) : '';
    $date = isset($_POST['date']) ? urlencode(htmlspecialchars($_POST['date'])) : '';
    $project = isset($_POST['project']) ? $_POST['project'] : '';
    $preview = isset($_FILES['preview']) ? $_FILES['preview'] : '';
    if(!strtotime($date) || $date != date("d.m.Y", strtotime($date))) {
        $errors[] = 'date';
    }
    foreach($_POST as $key => $value) {
        if(in_array($key, $required) && $value == '') {
            $errors[] = $key;
        }
    }
    if(!count($errors)) {
        if (isset($_FILES['preview'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_name = $_FILES['preview']['tmp_name'];
            $file_size = $_FILES['preview']['size'];
            $file_type = finfo_file($finfo, $file_name);
            $file_url = $_SERVER['DOCUMENT_ROOT'].'/'. $_FILES['preview']['name'];

          move_uploaded_file($file_name, $file_url);
        }
        header("Location: index.php?success=true&name=$name&date=$date&category=$project");
    }
}
?>
<h2 class="modal__heading">Добавление задачи</h2>
<form class="form" action="index.php?add=true" method="post" enctype="multipart/form-data">
    <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>

    <input class="form__input<?= in_array('name', $errors) ? ' form__input--error' : ''?>" type="text" name="name" id="name" value="<?=$_POST['name']?>" placeholder="Введите название">
    <?php if(in_array('name', $errors)) {?>
        <span class="form__error">Напишите название задачи</span>
    <?php }?>
    </div>

    <div class="form__row">
    <label class="form__label" for="project">Проект <sup>*</sup></label>

    <select class="form__input form__input--select" name="project" id="project">
        <?php foreach($projects as $project) {
            if($project !== 'Все') {?>
                <option value="<?= $project?>" <?= ($project == $_POST['project']) ? 'selected' : ''?>><?=$project?></option>
            <?php }
        }?>
    </select>

    </div>

    <div class="form__row">
    <label class="form__label" for="date">Дата выполнения <sup>*</sup></label>

    <input class="form__input form__input--date<?= in_array('date', $errors) ? ' form__input--error' : ''?>" type="text" name="date" id="date" value="<?= $_POST['date']?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?php if(in_array('date', $errors)) {?>
        <span class="form__error">Напишите дату задачи в формате <i>ДД.ММ.ГГГГ</i></span>
    <?php }?>
    </div>

    <div class="form__row">
    <label class="form__label">Файл</label>
    <div class="form__input-file">

        <label style="position: relative" class="button button--transparent" >
            <input class="visually-hidden" type="file" name="preview" value="">
            <span>Выберите файл</span>
        </label>

    </div>
    </div>

    <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
</div>

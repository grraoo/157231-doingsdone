<?php
  $login = $templateData['login'];
  $users = $templateData['users'];

  $required = ['email', 'password'];
  $errors = [];
  $email = isset($_POST['email']) ? ($_POST['email']) : '';
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {

    foreach($_POST as $key => $value) {
        if(in_array($key, $required) && $value == '') {
            $errors[] = $key;
        }
    }
    $incomingPassword = isset($_POST['password']) ? ($_POST['password']) : '';

    $passwordHash = password_hash($incomingPassword, PASSWORD_DEFAULT);

    $currentUser = getUserByEmail($email, $users);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$currentUser) {
        $errors[] = 'email';
    }

    if(!password_verify($incomingPassword, $currentUser['password'])) {
        $errors[] = 'password';
    }

    if(!count($errors)) {
        session_start();
        $_SESSION['user'] = $currentUser;
        header("Location: index.php");
    }
  }
?>

<div class="modal" <?= $login ? '' : 'hidden'?>>
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" class="" action="index.php?login" method="post">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input<?= in_array('email', $errors) ? ' form__input--error' : ''?>" type="text" name="email" id="email" value="<?=$email?>" placeholder="Введите e-mail">
            <?php if(in_array('email', $errors)):?>
                <p class="form__message">E-mail введён некорректно</p>
            <?php endif;?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            <?php if(in_array('password', $errors)):?>
                <p class="form__message">Вы ввели неверный пароль</p>
            <?php endif;?>
        </div>

        <div class="form__row">
            <label class="checkbox">
            <input class="checkbox__input visually-hidden" type="checkbox" checked>
            <span class="checkbox__text">Запомнить меня</span>
            </label>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
        </div>
    </form>
</div>

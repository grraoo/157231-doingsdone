<?php $logged = $templateData['logged'];?>
<?php $userName = $templateData['userName'];?>

<?php if($logged) : ?>

<header class="main-header">
    <a href="#">
        <img src="img/logo.png" width="153" height="42" alt="Логитип Дела в порядке">
    </a>

    <div class="main-header__side">
        <a class="main-header__side-item button button--plus" href="?add=true">Добавить задачу</a>

        <div class="main-header__side-item user-menu">
            <div class="user-menu__image">
                <img src="img/user-pic.jpg" width="40" height="40" alt="Пользователь">
            </div>

            <div class="user-menu__data">
                <p><?=$userName?></p>

                <a href="?logout=true">Выйти</a>
            </div>
        </div>
    </div>
</header>

<?php else : ?>

<header class="main-header">
    <a href="#">
        <img src="img/logo.png" width="153" height="42" alt="Логитип Дела в порядке">
    </a>

    <div class="main-header__side">
        <a class="main-header__side-item button button--transparent" href="?login">Войти</a>
    </div>
</header>

<?php endif;?>

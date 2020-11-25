
    <main>
        <nav class="nav">
            <ul class="nav__list container">
                <!--заполните этот список из массива категорий-->
                <?php foreach ($category_description as $value): ?>
                    <li class="nav__item">
                        <a href="pages/all-lots.html"><?=check_data($value['cat_name'] ?? "");?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php $classname = isset($errors) ? "form--invalid" : "";?>
        <form class="form container <?=$classname;?>" action="sign-up.php" method="post" autocomplete="off" enctype="multipart/form-data"> <!-- form invalid -->
            <h2>Регистрация нового аккаунта</h2>
            <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";?>
            <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
                <label for="email">E-mail <sup>*</sup></label>
                <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email') ?? "";?>">
                <span class="form__error"><?=$errors['email'] ?? "";?></span>
            </div>
            <?php $classname = isset($errors['username']) ? "form__item--invalid" : "";?>
            <div class="form__item <?=$classname;?>">
                <label for="username">Имя <sup>*</sup></label>
                <input id="username" type="text" name="username" placeholder="Введите имя" value="<?=getPostVal('username') ?? "";?>">
                <span class="form__error"><?=$errors['username'] ?? "";?></span>
            </div>
            <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";?>
            <div class="form__item <?=$classname;?>">
                <label for="password">Пароль <sup>*</sup></label>
                <input id="password" type="password" name="password" placeholder="Введите пароль">
                <span class="form__error"><?=$errors['password'] ?? "";?></span>
            </div>
            <?php $classname = isset($errors['contact']) ? "form__item--invalid" : "";?>
            <div class="form__item <?=$classname;?>">
                <label for="contact">Контактные данные <sup>*</sup></label>
                <textarea id="contact" name="contact" placeholder="Напишите как с вами связаться"><?=getPostVal('contact') ?? "";?></textarea>
                <span class="form__error"><?=$errors['contact'] ?? "";?></span>
            </div>
            <?php $classname = isset($errors) ? "Пожалуйста, исправьте ошибки в форме" : "";?>
            <span class="form__error form__error--bottom"><?=$classname;?></span>
            <button type="submit" class="button">Зарегистрироваться</button>
            <a class="text-link" href="#">Уже есть аккаунт</a>
        </form>
    </main>

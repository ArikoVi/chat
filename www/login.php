<script src="/public/js/login.js"></script>

<div class="login" style="height: 267px;">

    <h1>Вход<a href="/"><img class="img-exit" src="./public/img/close.png"></a></h1>

    <form class="login-form" action="model/signin.php" method="post">
        <label for="login-name">Логин </label> <input type="text" id="login-name" name="name" maxlength="30"/>
        <p class="message" id="name-message"></p>
        <br>
        <label class="login-password-label" for="login-password">Пароль </label> <input id="login-password" name="password" type="password" maxlength="30"/>
        <p class="message" id="password-message"></p>

        <div id="btn-div">
            <input type="submit" id="signin" value="Вход"/>
            <a id="registr" href="/?page=registr">Регистрация</a>
        </div>
    </form>

</div>

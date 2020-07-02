<script src="/public/js/registr.js"></script>

<div style="height: 425px" class="login">

    <h1>Регистрация<a href="/"><img class="img-exit" src="./public/img/close.png"></a></h1>

    <form class="login-form" action="model/model.php" method="post">
        <label for="login-name">Логин </label> <input type="text" id="login-name" name="name" maxlength='30'/>
        <p class="message" id="name-message"></p>
        <br>
        <label for="login-email">Email </label> <input type="Email" id="login-email" name="email" maxlength='30'/>
        <p class="message" id="email-message"></p>
        <br>
        <label class="login-password-label" for="login-password">Пароль </label> <input id="login-password" name="password" type="password" maxlength='30'/>
        <p class="message" id="password-message"></p>
        <br>
        <label class="login-password-label" style="height: 40px; line-height: 1.3; margin-bottom: 0px;" for="login-password-repeat">Повторите пароль </label>
        <input id="login-password-repeat" name="password" type="password" maxlength='30'/>
        <p class="message" id="password-repeat-message"></p>

        <div id="btn-div">
            <input type="submit" id="registr" name="submit" style="height: 100%; width: 160px; float: left; margin-left: 83px;" value="Зарегистрироваться"/>
        </div>
    </form>

</div>

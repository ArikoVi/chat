<?php

session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    $id = -1;
}

if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
} else {
    $login = 'Гость';
}

if (isset($_SESSION['admin'])) {
    $adm = $_SESSION['admin'];
} else {
    $adm = 0;
}

?>

<!DOCTYPE html>
<html>

    <head>

        <meta http-equiv="content-type" content="text/html" charset="utf-8">
        <meta name='viewport' content='width=device-width, initial-scale=0.8'>

        <title>CoolChat - самый классный чат</title>

        <link rel='shortcut icon' href='./public/img/favicon.png' type='image/png'/>

        <link rel='stylesheet' type='text/css' href='./public/css/header-bar/header-bar.css'/>
		<link rel='stylesheet' type='text/css' href='./public/css/header-bar/__logo/header-bar__logo.css'/>
		<link rel='stylesheet' type='text/css' href='./public/css/header-bar/__link-list/header-bar__link-list.css'/>

        <link rel="stylesheet" href="./public/css/body/body.css">
        <link rel="stylesheet" href="./public/css/login-form/login-form.css">
        <link rel="stylesheet" href="./public/css/login-form/login-form.css">
        <link rel="stylesheet" href="./public/css/account/account.css">
        <link rel="stylesheet" href="./public/css/admin/admin.css">
        <link rel="stylesheet" type="text/css" href="./public/css/shoutbox/shoutbox.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/emojione/1.3.0/assets/css/emojione.min.css"/>

        <script src="/public/js/jquery-3.3.1.min.js"></script>
        <script src="/public/js/jquery.md5.js"></script>

    </head>

    <body>
        <div class='header-bar'>
			<div class='header-bar__basis'>
				<a class='header-bar__logo' href="/">
					<img class='header-bar__logo__img' src='./public/img/favicon.png'>
					<p class='header-bar__logo__title'>CoolChat</p>
                </a>
                <?php if ($login != 'Гость') { ?>
                    <div class='header-bar__link-list'>
    					<a class='header-bar__link-list__form' href="/?page=account">
    						<img class='header-bar__link-list__form__img' src='
							<?php
							$url = 'http://cc.com/public/img/users_avatar/' . md5($id) . '.jpg';
							$Headers = @get_headers($url);
							if (preg_match('|200|', $Headers[0])) {
								echo $url;
							} else {
								echo './public/img/icons-guest.png';
							}
							?>'>
    						<p class='header-bar__link-list__form__link'><?php echo $login; ?>
    						<div style='clear: both'></div>
                        </a>

                        <a class='header-bar__link-list__form' id="signin_exit">
    						<p class='header-bar__link-list__form__link'>Выход
    						<div style='clear: both'></div>
                        </a>
                    </div>
                <?php } else { ?>
    				<div class='header-bar__link-list'>
    					<a class='header-bar__link-list__form' href="/?page=login">
    						<p class='header-bar__link-list__form__link'>Вход
    						<div style='clear: both'></div>
                        </a>

                        <a class='header-bar__link-list__form' href="/?page=registr">
    						<p class='header-bar__link-list__form__link'>Регистрация
    						<div style='clear: both'></div>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($adm) { ?>
                    <div class='header-bar__link-list'>
                        <a class='header-bar__link-list__form' href="/?page=admin">
                            <p class='header-bar__link-list__form__link'>Adm
                            <div style='clear: both'></div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $("#signin_exit").on("click", function(e) {
                    let signin_exit = 'signin_exit';

                    $.ajax({
                        type: "POST",
                        url: "model/signin.php",
                        data: {signin_exit: signin_exit},
                        success: function(data) {
                            if (data == "exit") {
                                location.href = '/';
                            } else {
                                alert(data);
                            }
                        }
                    });
                    return false;
                });
            });
        </script>

        <?php
        switch ($_GET['page']) {
            case 'registr':
                include "registr.php";
                break;
            case 'login':
                include "login.php";
                break;
            case 'account':
                if (isset($_SESSION['id'])) {
                    include "account.php";
                } else {
                    include "chat.php";
                }
                break;
            case 'admin':
                if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                    include "admin.php";
                } else {
                    include "chat.php";
                }
                break;
            default:
                include "chat.php";
                break;
        }
        ?>

        <!--script>
            $(document).ready(function() {
                $('.header-bar__logo').click(function() {
                    $.ajax({
                        url: "chat.php",
                        cache: false,
                        success: function(html) {
                            $("#content").html(html);
                        }
                    });
                    return false;
                });

                $('#login').click(function() {
                    $.ajax({
                        url: "login.php",
                        cache: false,
                        success: function(html) {
                            $("#content").html(html);
                        }
                    });
                    return false;
                });

                $('#registr').click(function() {
                    $.ajax({
                        url: "registr.php",
                        cache: false,
                        success: function(html) {
                            $("#content").html(html);
                        }
                    });
                    return false;
                });
            });
        </script-->

    </body>

</html>

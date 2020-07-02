$(document).ready(function(){
    $("#registr").on("click", function(e){
        e.preventDefault();

        var reg = /^([A-Za-z0-9_\-\.]+$)$/;
        var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        let submit = $(this).val();
        let login = $("#login-name").val();
        let email = $("#login-email").val();
        let pass = $("#login-password").val();
        let passRepeat = $("#login-password-repeat").val();

        if (login == "") {
            $("#name-message").text("Введите логин");
            $("#login-name").css({'border':'1px solid red'});
        } else {
            if (!reg.test(login)) {
                $("#name-message").text("Логин может включать латинские буквы (a-z), цифры (0-9), точку (.) и символы (- _)");
                $("#login-name").css({'border':'1px solid red'});
            } else {
                $("#name-message").text("");
                $("#login-name").css({'border':'1px solid green'});
            }
        }

        if (email == "") {
            $("#email-message").text("Введите email");
            $("#login-email").css({'border':'1px solid red'});
        } else {
            if (!regEmail.test(email)) {
                $("#email-message").text("Email может включать латинские буквы (a-z), цифры (0-9), точку (.) и символы (- _)");
                $("#login-email").css({'border':'1px solid red'});
            } else {
                $("#email-message").text("");
                $("#login-email").css({'border':'1px solid green'});
            }
        }

        if (pass == "") {
            $("#password-message").text("Введите пароль");
            $("#login-password").css({'border':'1px solid red'});
            pass = "";
            $("#login-password").val("");
            $("#login-password-repeat").val("");
        } else {
            if (pass.length < 8) {
                $("#password-message").text("Пароль не должен быть короче 8 символов");
                $("#login-password").css({'border':'1px solid red'});
                pass = "";
                $("#login-password").val("");
                $("#login-password-repeat").val("");
            } else {
                if (!reg.test(pass)) {
                    $("#password-message").text("Пароль может включать латинские буквы (a-z), цифры (0-9), точку (.) и символы (- _)");
                    $("#login-password").css({'border':'1px solid red'});
                    pass = "";
                    $("#login-password").val("");
                    $("#login-password-repeat").val("");
                } else {
                    $("#password-message").text("");
                    $("#login-password").css({'border':'1px solid green'});
                }
            }
        }

        if (passRepeat == "" || passRepeat != pass) {
            $("#password-repeat-message").text("Пароли не совпадают");
            $("#login-password-repeat").css({'border':'1px solid red'});
            $("#login-password").val("");
            $("#login-password-repeat").val("");
        } else {
            $("#password-repeat-message").text("");
            $("#login-password-repeat").css({'border':'1px solid green'});
        }

        if($("#name-message").text() == "" && $("#email-message").text() == ""
            && $("#password-message").text() == "" && $("#password-repeat-message").text() == "") {
            $.ajax({
                type: "POST",
                url: "model/model.php",
                data: {login: login, email: email, pass: pass, submit: submit},
                success: function(data) {
                    if (data == "логин уже существует") {
                        $("#name-message").text("Данный логин уже зарегистрирован");
                        $("#login-name").css({'border':'1px solid red'});
                    } else if (data == "ok") {
                        alert("Вы успешно зарегистрированы");

                        document.location.href = "/?page=login";
                    } else {
                        alert(data);
                    }
                }
            });
        }
   });
});

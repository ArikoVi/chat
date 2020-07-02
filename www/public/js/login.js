$(document).ready(function(){
    $("#signin").on("click", function(e){
        e.preventDefault();

        var reg = /^([A-Za-z0-9_\-\.]+$)$/;

        let signin = $(this).val();
        let login = $("#login-name").val();
        let pass = $("#login-password").val();

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

        if (pass == "") {
            $("#password-message").text("Введите пароль");
            $("#login-password").css({'border':'1px solid red'});
            $("#login-password").val("");
        } else {
            if (!reg.test(pass)) {
                $("#password-message").text("Пароль может включать латинские буквы (a-z), цифры (0-9), точку (.) и символы (- _)");
                $("#login-password").css({'border':'1px solid red'});
                $("#login-password").val("");
            } else {
                $("#password-message").text("");
                $("#login-password").css({'border':'1px solid green'});
            }
        }

        if($("#name-message").text() == "" && $("#password-message").text() == "") {
            $.ajax({
                type: "POST",
                url: "model/signin.php",
                data: {login: login, pass: pass, signin: signin},
                success: function(data) {
                    if (data == "no") {
                        $("#name-message").text("Неправильный логин или пароль");
                        $("#login-name").css({'border':'1px solid red'});

                        $("#password-message").text("Неправильный логин или пароль");
                        $("#login-password").css({'border':'1px solid red'});
                    } else if (data == 'yes') {
                        location.href = '/';
                    } else {
                        alert(data);
                    }
                }
            });
        }
   });
});

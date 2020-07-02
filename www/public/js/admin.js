$(function() {
    $("#newroom").on("click", function(e) {
        e.preventDefault();

        let submit = $(this).val();
        let title = $("#newroom-title").val();
        let descr = $("#newroom-descr").val();
        let checkbox;

        if ($('#newroom-private').is(":checked")) {
            checkbox = 1;
        } else {
            checkbox = 0;
        }

        if (title == "") {
            $("#newroom-title-message").text("Введите название");
            $("#newroom-title").css({'border':'1px solid red'});
        } else {
            $("#newroom-title-message").text("");
            $("#newroom-title").css({'border':'1px solid green'});
        }

        if (descr == "") {
            $("#newroom-descr-message").text("Введите описание");
            $("#newroom-descr").css({'border':'1px solid red'});
        } else {
            $("#newroom-descr-message").text("");
            $("#newroom-descr").css({'border':'1px solid green'});
        }

        if (title != "" && descr != "") {
            $.ajax({
                type: "POST",
                url: "addRoom.php",
                data: {title: title, descr: descr, checkbox: checkbox, submit: submit},
                success: function(data) {
                    if (data == 'ok') {
                        alert('Успешно!');
                    } else {
                        alert('Ошибка!');
                    }
                }
            });
        }
    });

    $("#changeroom").on("click", function(e) {
        e.preventDefault();

        let submit = $(this).val();
        let idRoom = $('#changeroom-id').val();
        let title = $("#changeroom-title").val();
        let descr = $("#changeroom-descr").val();
        let checkbox;

        if ($('#changeroom-private').is(":checked")) {
            checkbox = 1;
        } else {
            checkbox = 0;
        }

        if (idRoom == "") {
            $("#changeroom-id-message").text("Введите id");
            $("#changeroom-id").css({'border':'1px solid red'});
        } else {
            $("#changeroom-id-message").text("");
            $("#changeroom-id").css({'border':'1px solid green'});
        }

        if (idRoom != "") {
            $.ajax({
                type: "POST",
                url: "changeRoom.php",
                data: {idRoom: idRoom, title: title, descr: descr, checkbox: checkbox, submit: submit},
                success: function(data) {
                    if (data == 'ok') {
                        alert('Успешно!');
                    } else {
                        alert('Ошибка!');
                    }
                }
            });
        }
    });

    $("#adduser").on("click", function(e) {
        e.preventDefault();

        let reg = /^([A-Za-z0-9_\-\.]+$)$/;

        let submit = $(this).val();
        let login = $("#adduser-login").val();
        let idRoom = $("#adduser-idroom").val();

        if (login == "") {
            $("#adduser-login-message").text("Введите логин");
            $("#adduser-login").css({'border':'1px solid red'});
        } else {
            if (!reg.test(login)) {
                $("#adduser-login-message").text("Логин может включать латинские буквы (a-z), цифры (0-9), точку (.) и символы (- _)");
                $("#adduser-login").css({'border':'1px solid red'});
            } else {
                $("#adduser-login-message").text("");
                $("#adduser-login").css({'border':'1px solid green'});
            }
        }

        if (idRoom == "") {
            $("#adduser-idroom-message").text("Введите id");
            $("#adduser-idroom").css({'border':'1px solid red'});
        } else {
            $("#adduser-idroom-message").text("");
            $("#adduser-idroom").css({'border':'1px solid green'});
        }

        if ($("#adduser-idroom-message").text() == "" && $("#adduser-login-message").text() == "") {
            $.ajax({
                type: "POST",
                url: "addUser.php",
                data: {idRoom: idRoom, login: login, submit: submit},
                success: function(data) {
                    if (data == 'ok') {
                        alert('Успешно!');
                    } else if (data == 'no') {
                        $("#adduser-login-message").text("Такого логина не найдено");
                        $("#adduser-login").css({'border':'1px solid red'});
                    } else {
                        alert('Ошибка!');
                    }
                }
            });
        }
    });

    $("#deluser").on("click", function(e) {
        e.preventDefault();

        let reg = /^([A-Za-z0-9_\-\.]+$)$/;

        let submit = $(this).val();
        let login = $("#deluser-login").val();
        let idRoom = $("#deluser-idroom").val();

        if (login == "") {
            $("#deluser-login-message").text("Введите логин");
            $("#deluser-login").css({'border':'1px solid red'});
        } else {
            if (!reg.test(login)) {
                $("#deluser-login-message").text("Логин может включать латинские буквы (a-z), цифры (0-9), точку (.) и символы (- _)");
                $("#deluser-login").css({'border':'1px solid red'});
            } else {
                $("#deluser-login-message").text("");
                $("#deluser-login").css({'border':'1px solid green'});
            }
        }

        if (idRoom == "") {
            $("#deluser-idroom-message").text("Введите id");
            $("#deluser-idroom").css({'border':'1px solid red'});
        } else {
            $("#deluser-idroom-message").text("");
            $("#deluser-idroom").css({'border':'1px solid green'});
        }

        if ($("#deluser-idroom-message").text() == "" && $("#deluser-login-message").text() == "") {
            $.ajax({
                type: "POST",
                url: "delUser.php",
                data: {idRoom: idRoom, login: login, submit: submit},
                success: function(data) {
                    if (data == 'ok') {
                        alert('Успешно!');
                    } else if (data == 'no') {
                        $("#deluser-login-message").text("Такого логина не найдено");
                        $("#deluser-login").css({'border':'1px solid red'});
                    } else {
                        alert('Ошибка!');
                    }
                }
            });
        }
    });
});

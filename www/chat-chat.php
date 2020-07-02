<?php
$name;
if (isset($_GET['login'])) {
    $name = $_GET['login'];
} else {
    $name = 'Гость';
}
if (isset($_GET['idUser'])) {
    $id = $_GET['idUser'];
} else {
    $id = -1;
}
if (isset($_GET['adm'])) {
    $adm = $_GET['adm'];
} else {
    $adm = 0;
}
?>

<h1><p><?php echo $_GET['titleRoom']; ?></p><img class="img-refresh" src='./public/img/refresh.png'/><img class="img-exit" src="./public/img/close.png"></h1>

<ul class="shoutbox-content"></ul>

<div class="shoutbox-form">
    <form action="./chat/publish.php" method="post" style="display: block;">
        <textarea id="shoutbox-comment" name="comment" maxlength="240"></textarea>
        <input type="submit" value="Отправить">
    </form>
</div>

<script>
$(function() {
    emojione.ascii = true;

    // Сохраняем некоторые элементы в переменные для удобства
    var refreshButton = $('h1 .img-refresh'),
    shoutboxForm = $('.shoutbox-form'),
    form = shoutboxForm.find('form'),
    commentElement = form.find('#shoutbox-comment'),
    ul = $('ul.shoutbox-content');

    // Загружаем комментарии.
    load();

    // При отправке формы, если все заполнено, публикуем сообщение в базе данных
    var canPostComment = true;

    form.submit(function(e) {
        e.preventDefault();

        if(!canPostComment) return;

        var name = '<?php echo $name; ?>'.trim();
        var comment = commentElement.val().trim();

        if(name.length && comment.length && comment.length < 240) {
            publish(name, comment);

            // Блокируем публикацию новых сообщений
            canPostComment = false;

            // Разрешаем новому комментарию быть опубликованным через 5 секунд
            setTimeout(function() {
                canPostComment = true;
            }, 5000);
        }
    });

    // При клике на кнопку REPLY (Ответить) происходит добавление в текстовое поле имени человека, которому вы хотели бы ответить.
    ul.on('click', '.shoutbox-comment-reply', function(e) {
        var replyName = $(this).data('name');

        commentElement.val('@' + replyName + ' ').focus();
    });

    $('h1 .img-exit').on('click', function() {
        clearInterval(interval);

        $.ajax({
            url: "chat-rooms.php",
            cache: false,
            data: {login: '<?php echo $name; ?>', idUser: <?php echo $id; ?>, adm: <?php echo $adm; ?>},
            success: function(html) {
                $("#content").html(html);
            }
        });
        return false;
    });

    // При клике на кнопку «Обновить» происходит срабатывание функции load
    var canReload = true;

    refreshButton.click(function() {
        if(!canReload) return false;

        load();
        canReload = false;

        // Разрешаем дополнительные перезагрузки через 2 секунды
        setTimeout(function() {
            canReload = true;
        }, 2000);
    });

    // Автоматически обновляем сообщения каждые 10 секунд
    let interval = setInterval(load, 10000);

    // Сохраняем сообщение в базе данных
    function publish(name, comment) {
        let idRoom = <?php echo $_GET['idRoom']; ?>;
        let idUser = <?php echo $id; ?>;

        $.post('./chat/publish.php', {idUser: idUser, name: name, comment: comment, idRoom: idRoom}, function(data) {
            commentElement.val("");
            load();
        });
    }

    // Получаем последние сообщения
    function load(){
        let idRoom = <?php echo $_GET['idRoom']; ?>;

        $.getJSON('./chat/load.php', {idRoom: idRoom}, function(data) {
            appendComments(data);
        });
    }

    // Обрабатываем массив с сообщениями в виде HTML
    function appendComments(data) {
        ul.empty();

        data.forEach(function(d) {
            let urlImg;
            let imgHtml = "";
            let imgStyle = "";
            let divStyle = "";

            <?php if ($adm) { ?>
                imgHtml = '<img class="img-delete" src="./public/img/delete.png">';
                imgStyle = ' style="margin-left: 5px;"';
                divStyle = ' style="margin-left: 85px;"';
            <?php } ?>

            $.ajax({
                url:'/public/img/users_avatar/' + $.md5(d.idUser) + '.jpg',
                type:'HEAD',
                error: function() {
                    urlImg = './public/img/icons-guest.png';

                    ul.append('<li class="message">' +
                        '<input id="idMess" type="hidden" value="' + d.id + '">' +
                        imgHtml +
                        '<img class="shoutbox-avatar" src="' + urlImg + '"' + imgStyle + '>' +
                        '<div class="shoutbox-div"' + divStyle + '>' +
                        '<span class="shoutbox-username">' + d.name + '</span>' +
                        '<p class="shoutbox-comment">' + emojione.toImage(d.text) + '</p>' +
                        '<div class="shoutbox-comment-details"><span class="shoutbox-comment-reply" data-name="' + d.name + '">Ответить</span>' +
                        '<span class="shoutbox-comment-ago">' + d.timeAgo + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</li>');
                },
                success: function() {
                    urlImg = './public/img/users_avatar/' + $.md5(d.idUser) + '.jpg';

                    ul.append('<li class="message">' +
                        '<input id="idMess" type="hidden" value="' + d.id + '">' +
                        imgHtml +
                        '<img class="shoutbox-avatar" src="' + urlImg + '"' + imgStyle + '>' +
                        '<div class="shoutbox-div"' + divStyle + '>' +
                        '<span class="shoutbox-username">' + d.name + '</span>' +
                        '<p class="shoutbox-comment">' + emojione.toImage(d.text) + '</p>' +
                        '<div class="shoutbox-comment-details"><span class="shoutbox-comment-reply" data-name="' + d.name + '">Ответить</span>' +
                        '<span class="shoutbox-comment-ago">' + d.timeAgo + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</li>');
                }
            });
        });
    }

    $(document).on('click', '.message .img-delete', function() {
        let idMess = $(this).parent('li').find('#idMess').val();

        $.ajax({
            url: "deleteMess.php",
            cache: false,
            data: {idRoom: <?php echo $_GET['idRoom']; ?>, idMess: idMess},
            success: function(data) {
                if (data == 'ok') {
                    alert('Успешно!');
                    load();
                } else {
                    alert('Ошибка удаления!');
                }
            }
        });
        return false;
    });

});
</script>

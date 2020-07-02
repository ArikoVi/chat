<?php

if (isset($_GET['login'])) $login = $_GET['login'];
if (isset($_GET['idUser'])) $id = $_GET['idUser'];
if (isset($_GET['adm'])) $adm = $_GET['adm'];

?>

<h1 class="h1h1">Комнаты</h1>

<ul class="shoutbox-rooms">
    <?php
    require_once "model/connection.php";

    $link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

    $idEl = 0;

    if (isset($login)) {
        $idUsersResult = mysqli_query($link, "SELECT id FROM users WHERE login='$login'") or die("Ошибка " . mysqli_error($link));
        if ($idUsersResult) {
            $myrow = mysqli_fetch_array($idUsersResult);
            $idUsers = $myrow['id'];
        }

        $privateRoomsResult = mysqli_query($link, "SELECT rooms FROM rooms_users WHERE users='$idUsers'") or die("Ошибка " . mysqli_error($link));
        if ($privateRoomsResult) {
            $string;
            while ($myrow2 = mysqli_fetch_array($privateRoomsResult)) {
                $string .= 'id=' . $myrow2[0] . ' or ';
            }
            $string .= 'tmp';
            $string = str_replace(" or tmp","",$string);
            $string = str_replace("tmp","",$string);
        }

        if ($adm) {
            $stringWhere = " WHERE private=1";
            $htmlImgDel = '<img class="img-delete" src="./public/img/delete.png">';
            $divStyle = ' style="margin-left: 50px;"';
            $pId = '<p>idRoom = '. $myrowPrivate['id'];
        } else {
            $htmlImgDel = '';
            $divStyle = '';
            $pId = '';
            if ($string != '') {
                $stringWhere = " WHERE ".$string;
            }
        }

        if (isset($stringWhere)) {
            $privateRoomsResult = mysqli_query($link, "SELECT * FROM rooms" . $stringWhere) or die("Ошибка " . mysqli_error($link));

            if($privateRoomsResult) {
                echo '<li class="li-no-clicable">
                    <h1>Приватные комнаты</h1>
                </li>';

                while ($myrowPrivate = mysqli_fetch_array($privateRoomsResult)) {
                    if ($adm) {
                        $pId = '<p>idRoom = '. $myrowPrivate['id'];
                    } else {
                        $pId = '';
                    }

                    echo '
                    <li class="li-clicable">
                    ' . $htmlImgDel . '
                    <div' . $divStyle . '>
                    ' . $pId . '
                    <input type="hidden" id="idRoom" value="'. $myrowPrivate['id'] .'">
                    <span class="shoutbox-title" id="span'. $idEl .'">'. $myrowPrivate['title'] .'</span>
                    <br>
                    <p class="shoutbox-description" id="p'. $idEl .'">'. $myrowPrivate['description'] .'</p>
                    </div>
                    </li>';

                    $idEl++;
                }
            }
        }
    }

    $resultGeneral = mysqli_query($link, "SELECT * FROM rooms WHERE private=0") or die("Ошибка " . mysqli_error($link));

    if($resultGeneral) {
        echo '<li class="li-no-clicable">
            <h1>Публичные комнаты</h1>
        </li>';

        while ($myrow = mysqli_fetch_array($resultGeneral)) {
            if ($adm) {
                $pId = '<p>idRoom = '. $myrow['id'];
            } else {
                $pId = '';
            }

            echo '
            <li class="li-clicable">
            ' . $htmlImgDel . '
            <div' . $divStyle . '>
            ' . $pId . '
            <input type="hidden" id="idRoom" value="'. $myrow['id'] .'">
            <span class="shoutbox-title" id="span'. $idEl .'">'. $myrow['title'] .'</span>
            <br>
            <p class="shoutbox-description" id="p'. $idEl .'">'. $myrow['description'] .'</p>
            </div>
            </li>';

            $idEl++;
        }
    } elseif (!isset($login)) {
        echo '
        <li>
        <p>К сожалению вас еще не пригласили ни в одну комнату</p>
        </li>';
    }

    mysqli_close($link);
    ?>

    <script src="https://cdn.jsdelivr.net/emojione/1.3.0/lib/js/emojione.min.js"></script>

    <script>
    $(document).ready(function() {
        <?php for ($i = 0; $i < $idEl; $i++) { ?>
            let span<?php echo $i; ?> = $('#span<?php echo $i; ?>');
            let text<?php echo $i; ?> = span<?php echo $i; ?>.text();
            span<?php echo $i; ?>.empty();
            emojione.ascii = true;
            span<?php echo $i; ?>.append(emojione.toImage(text<?php echo $i; ?>));

            let p<?php echo $i; ?> = $('#p<?php echo $i; ?>');
            let textP<?php echo $i; ?> = p<?php echo $i; ?>.text();
            p<?php echo $i; ?>.empty();
            p<?php echo $i; ?>.append(emojione.toImage(textP<?php echo $i; ?>));
        <?php } ?>
    });

    $('.li-clicable div').on('click', function() {
        let titleRoom = $(this).find('.shoutbox-title').html();

        let idRoom = $(this).find('#idRoom').val();
        let login = '<?php echo $login; ?>';
        let idUser = <?php echo $id; ?>;
        let adm = <?php echo $adm; ?>;

        $.ajax({
            url: "chat-chat.php",
            cache: false,
            data: {idRoom: idRoom, titleRoom: titleRoom, login: login, idUser: idUser, adm: adm},
            success: function(html) {
                $("#content").html(html);
            }
        });
        return false;
    });

    $('.li-clicable img').on('click', function() {
        let idRoom = $(this).parent('.li-clicable').find('div #idRoom').val();

        $.ajax({
            url: "deleteRoom.php",
            cache: false,
            data: {idRoom: idRoom},
            success: function(data) {
                if (data == 'ok') {
                    alert('Успешно!');
                    location.reload();
                } else {
                    alert('Ошибка удаления!');
                }
            }
        });
        return false;
    });
    </script>

</ul>

<?php

require_once "model/connection.php";

$link = mysqli_connect(HOST, USER, PASS, DB) or die ("не удалось подключиться к серверу");

$result = mysqli_query($link, "SELECT id, login, email FROM users WHERE login='$login'") or die("Ошибка " . mysqli_error($link));
if($result) {
    $myrow = mysqli_fetch_array($result);
    $email = $myrow['email'];
}

mysqli_close($link);

?>

<div class="account">

    <h1>Личный кабинет</h1>

    <div class="account-content">

        <div class="profile-form__avatar">
            <img class="profile-form__avatar__img" src="
			<?php
			$url = 'http://cc.com/public/img/users_avatar/' . md5($id) . '.jpg';
			$Headers = @get_headers($url);
			if (preg_match('|200|', $Headers[0])) {
				echo $url;
			} else {
				echo './public/img/icons-guest.png';
			}
			?>">
        </div>
        <div class="profile-form__info">
            <p class="text">Логин: <?php echo $login; ?></p>
            <p class="text">Email: <?php echo $email; ?></p>
        </div>
        <div style="clear: both;"></div>

        <h1>Смена аватара</h1>
        <br>
        <div class="profile-form__avatar-change">
            Размер изображения не превышает 512 Кб, пиксели по ширине не более 500, по высоте не более 1500.
            <form name="upload" action="" method="POST" ENCTYPE="multipart/form-data" style="margin-top: 20px;">
                Выберите файл для загрузки:
                <input type="file" name="userfile" id="userfile">
                <br>
                <p style="color: red; margin-top: 10px;" id="message_error"></p>
                <input type="submit" name="upload" id="avatar_download" value="Загрузить">
            </form>
        </div>

        <script>
            $(document).ready(function() {
                $("form").submit(function(e) {
                    e.preventDefault();

					let formData = new FormData(this);

                    $.ajax({
                        type: "POST",
                        url: "img_php/download_img.php",
                        data: formData,
						processData: false,
						contentType: false,
                        success: function(data) {
                            if (data.includes('.jpg')) {
                                renameImg(data);
                            } else {
                                $('#message_error').html(data);
                                $('#message_error').css('color: red;');
                            }
                        },
						error: function(data) {
							console.log(data);
						}
                    });
                    return false;
                });

                function renameImg(dir) {
                    let id = '<?php echo $id; ?>';

                    $.ajax({
                        type: "POST",
                        url: "img_php/rename_img.php",
                        data: {dir: dir, id: id},
                        success: function(data) {
                            $('#message_error').css('color: green;');
                            $('#message_error').text(data);
                        },
						error: function(data) {
							console.log(data);
						}
                    });
                }
            });
        </script>

    </div>

</div>

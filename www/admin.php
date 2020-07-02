<script src="/public/js/admin.js"></script>

<div class="admin">

    <h1>Добавить комнату</h1>

    <div class="admin-content">
        <form>
            <label for="newroom-title">Название комнаты</label> <input type="text" id="newroom-title" name="newroom-title" maxlength="50"/>
            <p class="message" id="newroom-title-message"></p>
            <br>
            <label for="newroom-descr">Описание комнаты</label> <textarea type="text" id="newroom-descr" name="newroom-descr" maxlength="200"></textarea>
            <p class="message" id="newroom-descr-message"></p>
            <br>
            <input type="checkbox" style="cursor: pointer;" id="newroom-private" name="newroom-private"/>
            <label for="newroom-private" class="label-checkbox">Приватная</label>
            <p class="message" id="newroom-private-message"></p>
            <input type="submit" id="newroom" value="Создать"/>
        </form>
    </div>

    <h1>Изменить комнату</h1>

    <div class="admin-content">
        <label for="changeroom-id">Id комнаты</label> <input type="number" id="changeroom-id" name="changeroom-id" maxlength="11"/>
        <p class="message" id="changeroom-id-message"></p>
        <br>
        <label for="changeroom-title">Новое название</label> <input type="text" id="changeroom-title" name="changeroom-title" maxlength="50" placeholder="Если не указано, то значение не поменяется"/>
        <p class="message" id="changeroom-title-message"></p>
        <br>
        <label for="changeroom-descr">Новое описание комнаты</label> <textarea type="text" id="changeroom-descr" name="changeroom-descr" maxlength="200" placeholder="Если не указано, то значение не поменяется"></textarea>
        <p class="message" id="changeroom-descr-message"></p>
        <br>
        <input type="checkbox" style="cursor: pointer;" id="changeroom-private" name="changeroom-private"/>
        <label for="changeroom-private" class="label-checkbox">Приватная</label>
        <p class="message" id="changeroom-private-message"></p>
        <input type="submit" id="changeroom" value="Изменить"/>
    </div>

    <h1>Добавить человека в комнату</h1>

    <div class="admin-content">
        <label for="adduser-login">Логин пользователя</label> <input type="text" id="adduser-login" name="adduser-login" maxlength="30"/>
        <p class="message" id="adduser-login-message"></p>
        <br>
        <label for="adduser-idroom">Id комнаты</label> <input type="number" id="adduser-idroom" name="adduser-idroom" maxlength="11"/>
        <p class="message" id="adduser-idroom-message"></p>
        <input type="submit" id="adduser" value="Добавить"/>
    </div>

    <h1>Исключить человека из комнаты</h1>

    <div class="admin-content">
        <label for="deluser-login">Логин пользователя</label> <input type="text" id="deluser-login" name="deluser-login" maxlength="30"/>
        <p class="message" id="deluser-login-message"></p>
        <br>
        <label for="deluser-idroom">Id комнаты</label> <input type="number" id="deluser-idroom" name="deluser-idroom" maxlength="11"/>
        <p class="message" id="deluser-idroom-message"></p>
        <input type="submit" id="deluser" value="Удалить"/>
    </div>

</div>

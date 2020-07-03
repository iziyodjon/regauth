<?php
require_once ('libs/functions.php');

$name = $_POST['username'];
$second_name = $_POST['second_name'];
$login = $_POST['login'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$avatar = $_FILES['avatar'];

if(!empty($_POST['email']) and !empty($_FILES['avatar']))
{
    // Регистрация новога контакта
    $user_id = regUser($email, $password);

    // Редактировать данные контакта
    setUserInfo($name, $second_name, $login, $phone, $user_id);

    // Редактировать аватар контакта
    setUserAvatar($avatar, $user_id);
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="avatar" value="Загрузите фото">
    <button type="submit">Отправить</button>
</form>


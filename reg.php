<?php
require_once ('libs/functions.php');

// Собираем все данные из post & files
$name = $_POST['username'];
$second_name = $_POST['second_name'];
$login = $_POST['login'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$avatar = $_FILES['avatar'];


if(!empty($email) and !empty($password))
{
    // Регистрация новога контакта
    $user_id = regUser($email, $password);
    // Редактировать данные контакта
    setUserInfo($name, $second_name, $login, $phone, $user_id);

    // Редактировать аватар контакта
    setUserAvatar($avatar, $user_id);
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>Регистрация и Авторизация</title>
</head>
<body>
<header>
    <div class="container">
        <h1><i class="fa fa-address-card-o" aria-hidden="true"></i> Регистрация и Авторизация</h1>
    </div>
</header>
<div class="main-wrap">
    <div class="container">
        <h5>Форма регистрации</h5>
        <form action="reg.php" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Name</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group col-md-6">
                    <label>Second Name</label>
                    <input type="text" class="form-control" name="second_name">
                </div>
                <div class="form-group col-md-6">
                    <label>Login</label>
                    <input type="text" class="form-control" name="login">
                </div>
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone">
                </div>
                <div class="form-group col-md-6">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group col-12">
                    <input type="file" name="avatar">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
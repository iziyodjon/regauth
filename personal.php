<?php
session_start();
require_once ('libs/functions.php');

// Вызов фукцию exitUser
$userExit = exitUser($_GET['user']);

if(isset($userExit))
{
    header('Location: /');
}
?>

<a href="<?=$_SERVER['REQUEST_URI'].'?user=logout'?>">Выйти</a>

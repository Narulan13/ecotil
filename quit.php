<?php 
    setcookie('currentUser', '', time() - 86400 * 30, "/"); // Устанавливаем прошлую дату, чтобы удалить cookie
    setcookie('PHPSESSID', '', time() - 86400 * 30, "/");
    header('Location: index.php');
    exit();
?>
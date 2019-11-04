<?php
// login
$return['login'] = 'error';
$_SESSION['login'] = '';
$login = htmlspecialchars($_POST['login']);
$password = $_POST['password'];
$query = 'SELECT user_login, user_pass FROM auth WHERE user_login = "'.$login.'"';
$sql = mysqli_query($mysqli,$query);
if (mysqli_num_rows($sql) > 0) {
    $foo = mysqli_fetch_array($sql);
    if ($foo['user_login'] == $login && $foo['user_pass'] == md5($password)) {
        $return['login'] = 'success';
        $_SESSION['login'] = 'success';
    } 
}

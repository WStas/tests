<?php
if ($_POST['completed'] == 'yes') {
    if ($_SESSION['login'] == 'success') include ('add_edit.php'); else $return['error'] = 'Access denided!';
} else {
    include ('add_edit.php');
}

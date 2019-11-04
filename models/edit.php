<?php
if ($_SESSION['login'] == 'success') include ('add_edit.php');
else $return['error'] = 'Access denided!';

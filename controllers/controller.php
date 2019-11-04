<?php
session_start();
if (!isset($_POST['action'])) exit();
include ('../core/db.php');
include ('../models/'.$_POST['action'].'.php');
echo json_encode($return);

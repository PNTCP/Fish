<?php
    session_start();
    require_once("config/db.php");
    if (!isset($_SESSION['admin_login'])) {
        header('index.php');
    }
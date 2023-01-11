<?php
// Database Connection
$db_host = 'localhost';
$db_name = 'rich7963';
$db_user = 'root';
$db_password = '';
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);

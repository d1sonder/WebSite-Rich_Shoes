<?php
$db = new PDO("mysql:host=localhost;dbname=pots;charset=utf8", "root", "root");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
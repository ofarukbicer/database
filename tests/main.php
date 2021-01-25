<?php

/* Buraya vendor autoload geleceği için bunları ' require "./vendor/autoload.php" ' olarak kullanın.*/
require "../src/Database.php";
require "../src/Export.php";

/* Gerekli use'lar */
use Database\Database;
use Database\Export;

$db = new Database('host', 'dbname', 'dbuser', 'dbpass'); // Database işlemleri yapılır :)

$data = new Export($db);
/* Üstünde Database sınıfını çalıştırdıkdan sonra hangi değikene atadıysanız onu bu sınıfın içine gönderin */

$data->run("exports"); // Yedeklemeyi bilgisayarınıza indirmez, aşağıdakini kullanın indirmek için
/* $data->run("exports", true); */
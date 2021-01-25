<?php

/* Buraya vendor autoload geleceği için bunları ' require "./vendor/autoload.php" ' olarak kullanın.*/
require "../src/Database.php";
require "../src/Import.php";

/* Gerekli use'lar */
use Database\Database;
use Database\Import;

$db = new Database('host', 'dbname', 'dbuser', 'dbpass');

$import = new Import($db, 'exports/25-01-2021-05-46-1611542802-notebook.sql'); // sql dosyasını seçiniz

$import->run(); // bu Import işlemini çalıştırır

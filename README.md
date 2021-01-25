# 🗄️ Database

## 📥 Kurulum

1. Composer bilgisayarınızda kurulu olması lazımdır.
2. Terminal'e `composer require omerfarukbicer0446/database` yazın.
3. Kurulum bitti :) 

## 📒 Kullanım
```php
<?php

require "vendor/autoload.php";

/* Gerekli use'lar */
use Database\Database;
use Database\Export;

$db = new Database('host', 'dbname', 'dbuser', 'dbpass'); 
// Database işlemleri yapılır :)

$data = new Export($db);
/* Üstünde Database sınıfını çalıştırdıkdan sonra hangi değikene atadıysanız onu bu sınıfın içine gönderin */

$data->run("exports"); 
// Yedeklemeyi bilgisayarınıza indirmez, aşağıdakini kullanın indirmek için
/* $data->run("exports", true); */
```

## 💚 Özel Teşekkürler

* [BasicDB](https://github.com/tayfunerbilen/basicdb) **için** [tayfunerbilen](https://github.com/tayfunerbilen) 🕊


## 🌐 Telif Hakkı ve Lisans

* *Copyright (C) 2021 by* [omerfarukbicer0446](https://github.com/omerfarukbicer0446) ❤️️
* [MIT LICENSE](https://github.com/omerfarukbicer0446/database/blob/master/LICENSE) *Koşullarına göre lisanslanmıştır..*

## ♻️ İletişim

*Benimle iletişime geçmek isterseniz, **Telegram**'dan mesaj göndermekten çekinmeyin;* [@omerfarukbicer](https://t.me/omerfarukbicer)


> **[www.cibza.com](https://www.cibza.com)** *için yazılmıştır..*

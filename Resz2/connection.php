<?php define('HOST', 'localhost');
define('PORT', 3306);
define('USER', 'root');
define('PASS', '');
define('DB', 'Felhasznalok');
define('DB_TYPE', 'mysql');
$dsn = DB_TYPE . ':host=' . HOST . ':' . PORT . ';dbname=' . DB; //Megnyitom a db kapcsolatot


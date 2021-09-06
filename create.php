<?php

include 'info.php';

$sql = "
CREATE TABLE MAIN (
id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
uname VARCHAR(100) NOT NULL,
fname VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
password VARCHAR(100) NOT NULL,
pimage VARCHAR(500) DEFAULT 'default.jpg',
cimage VARCHAR(500) DEFAULT 'cdefault.jpg',
age INT(2) NOT NULL,
gender VARCHAR(10) NOT NULL,
bio VARCHAR(500),
lactive VARCHAR(100),
joined VARCHAR(100));
";
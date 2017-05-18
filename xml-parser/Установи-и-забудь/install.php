<?php
//Подключаемся к БД
$dbo = new PDO('mysql:host=localhost;dbname=bicycles','root','L3zctxfg!');

/* Нахрен это ваше мускули, оно устарело, и на php7 отказывается работать как задумано!
$mysqli = mysqli_init();
  if (!$mysqli) {
    die('mysqli_init завершилась провалом');
  }

  if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Установка MYSQLI_INIT_COMMAND завершилась провалом');
  }

  if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10)) {
    die('Установка MYSQLI_OPT_CONNECT_TIMEOUT завершилась провалом');
  }

  if (!$mysqli->real_connect('localhost', 'root', 'L3zctxfg!', 'bicycles')) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  };*/

  //Создание таблицы

$query = "CREATE TABLE IF NOT EXISTS realty (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user INT(11) NULL,
  object_id INT(11) NULL,
  partner_id INT(11) NULL,
  country CHAR(2) NULL,
  currency CHAR(3) NULL,
  price DECIMAL(11,0) NULL,
  area DECIMAL(6,1) NULL,
  deal ENUM('buy','rent') NULL,
  type ENUM('residental','commercial') NULL,
  subtype ENUM('house','building','land','investment','apartment','premises','others','townhouse') NULL,
  grp ENUM('primary','secondary') NULL,
  lat DECIMAL(10,8) NULL,
  longt DECIMAL(11,8) NULL,
  adress CHAR(255) NULL
);";

if (!$dbo->query ($query)){
  die('Не получилось создать таблицу');
};

$query = "CREATE TABLE IF NOT EXISTS partners (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  partner VARCHAR(255) NULL
); ";

if (!$dbo->query ($query)){
  die('Не получилось создать таблицу');
};

$query = "CREATE TABLE IF NOT EXISTS partner_links (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  partner_id INT(11) NOT NULL,
  link VARCHAR(255) NULL
);";
if (!$dbo->query ($query)){
  die('Не получилось создать таблицу');
};

//ТЕСТОВЫЕ ДАННЫЕ, СНЕСТИ НАЙУХ ПЕРЕД РЕЛИЗОМ!
$query = "INSERT INTO `partners` (`id`,`partner`) VALUES (1,'Galactical Trading Company'), (2,'Space Realty Inc.'), (3,'Pandora\'s Future Realty');";
if (!$dbo->query ($query)){
  die('Не получилось добавить тестовые данные в таблицу!');
};
$query = "INSERT INTO `partner_links` (`partner_id`,`link`) VALUES (1,'GTC.xml'), (2,'SRI.xml'), (3,'PFR.xml')";
if (!$dbo->query ($query)){
  die('Не получилось добавить тестовые данные в таблицу!');
};
//Конец тестовых данных

//$mysqli->close();
?>

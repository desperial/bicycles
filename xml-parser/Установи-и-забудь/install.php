<?php
//Подключаемся к БД
$mysqli = mysqli_init();
  if (!$mysqli) {
    die('mysqli_init завершилась провалом');
  }

  if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Установка MYSQLI_INIT_COMMAND завершилась провалом');
  }

  if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Установка MYSQLI_OPT_CONNECT_TIMEOUT завершилась провалом');
  }

  if (!$mysqli->real_connect('localhost', 'root', '', 'bicycles')) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
  };
  //Создание таблицы

  $query = "CREATE TABLE realty (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user INT(11) NULL,
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
)";

if (!$mysqli->query ($query)){
  die('Не получилось создать таблицу');
};

$mysqli->close();
?>

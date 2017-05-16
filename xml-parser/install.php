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
  //id - ключ
  //adress - адрес объекта
  //obj_type - тип объекта
  //announce - описание объекта
  //img - изображение объекта
  //price - цена на объект
  $query = "CREATE TABLE item (
  	id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  	adress CHAR(50) NOT NULL,
  	obj_type CHAR(10) NULL,
  	announce TEXT(400) NULL,
  	img CHAR(50) NULL,
    price int(10) NULL
  )";

if (!$mysqli->query ($query)){
  die('Не получилось создать таблицу');
};

$mysqli->close();
?>

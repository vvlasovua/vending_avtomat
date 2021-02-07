<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  session_start();
  if (!empty($_COOKIE['sid'])) session_id($_COOKIE['sid']);

  $surrender = $_SESSION['money'];
  $_SESSION['money'] = 0;

  if($surrender <= 0){
    $arr = array('money' => $_SESSION['money'], 'surrender' => "Ошибка!");
    echo json_encode($arr);
    exit();
  }

  $arr = array('money' => $_SESSION['money'], 'surrender' => "Вы получили сдачу ".$surrender. " грн");

  echo json_encode($arr);
}
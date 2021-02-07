<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  session_start();
  if (!empty($_COOKIE['sid'])) session_id($_COOKIE['sid']);

  require_once $_SERVER['DOCUMENT_ROOT'].'/config/constants.php';

  spl_autoload_register(function ($class) {
    include '../class/' . $class . '.class.php';
  });

  //$arr = array();
  $G = new General();

  $money = $G->clearData($_POST['money'], "i");

  if($money > 0) {
    $_SESSION['money'] += $money;
  }

  $arr = array('money' => $_SESSION['money']);

  echo json_encode($arr);

}
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  session_start();
  if (!empty($_COOKIE['sid'])) session_id($_COOKIE['sid']);

  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/constants.php';

  spl_autoload_register(function ($class) {
    include '../class/' . $class . '.class.php';
  });

  $arr = array();
  $Product = new Product();

  $id = $Product->clearData($_POST['id'], "i");
  $res = $Product->buyProduct($id);

  if($res['code'] != false){
    $_SESSION['money'] -= $res['summ'];
    $arr = array('code' => 200, 'money' => $_SESSION['money']);
    echo json_encode($arr);
    exit();
  }

  $arr = array('code' => 500, 'msg' => 'Ошибка!');
  echo json_encode($arr);
}
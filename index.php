<?
header("Content-Type: text/html;charset=utf8");
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/config/constants.php';

spl_autoload_register(function ($class) {
  include 'class/' . $class . '.class.php';
});

$Product = new Product();
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Автомат</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" >
  <link rel="stylesheet" href="css/style.css" >
</head>
<body>

<div class="container">
  <div class="row">
    <h1>Автомат</h1>
  </div>

  <?//$Product->debug($Product->getProductsAll());?>

  <div class="col-md-6" style="border: 1px solid #000; margin: 25px 0px; padding: 0px">

    <div class="col-md-8" style="border: 1px solid #000; margin: 10px; padding: 0px">
      <? foreach ($Product->getProductsAll() as $item) {?>
        <div class="col-md-6" style="padding: 10px; text-align: center;">
          <a href="javascript:void(0);" class="btn <?=(isset($_SESSION['money']) and $_SESSION['money'] >= $item['cost'] and $item['quantity'] >= 1) ? "btn-success" : "btn-secondary";?> buy-product" data-id="<?=$item['id']?>" data-cost="<?=$item['cost']?>">
            <?=$item['name']?>
          </a>
        </div>
      <?}?>
    </div>

    <div class="col-md-3" style="border: 1px solid #000; margin: 10px; padding: 0px">

      <div style="width: 100%; border: 1px solid #000; margin: 10px 0; padding: 0 10px;" id="display">
        <?=(isset($_SESSION['money']) and $_SESSION['money'] != 0) ? $_SESSION['money']." грн" : "Готов! 0 грн";?>
      </div>

      <form name="form_money" id="form_money" style="width: 100%;">
        <select name="money"  class="form-control form-control-sm" required>
          <option value="" selected >Выберите купюру</option>
          <option value="1">1 грн</option>
          <option value="2">2 грн</option>
          <option value="5">5 грн</option>
          <option value="10">10 грн</option>
          <option value="20">20 грн</option>
          <option value="50">50 грн</option>
          <option value="100">100 грн</option>
        </select>
        <button type="submit" name="send_money" class="btn btn-outline-primary btn-sm" style="margin: 10px 0;">
          Закинуть деньгу
        </button>
      </form>

      <div class="" style="margin: 10px 0; display: none" id="txt"></div>

      <div class="take_money" style="margin: 10px 0; <?=(isset($_SESSION['money']) and $_SESSION['money'] != 0) ? "display: none" : "";?> display: none">
        <a href="javascript:void(0);" class="btn btn-outline-warning btn-sm" id="take_money">Забрать деньги/сдачу</a>
      </div>
    </div>

  </div>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" ></script>
<script src="js/script.js"></script>
</body>
</html>
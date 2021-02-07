<?php

class Product extends General {

  /**
   * @return array|mixed
   */
  public function getProductsAll(){
    return $this->db2arrayQuery('select * from product', 2);
  }

  public function getProductById($id){
    $data = array('id' => $id);
    return $this->db2arrayPrepare('select * from product where id=:id', $data, 1);
  }

  public function buyProduct($id){
    $product = $this->getProductById($id);
    $date = date("Y-m-d H:i:s");

    if($product) {
      if($product['quantity'] < 1) return ['code' => false];

      $summ = 1 * $product['cost'];

      if($_SESSION['money'] >= $summ) {
        $data = array('sid' => session_id(), 'quantity' => 1, 'date' => $date, 'product_id' => $product['id'], 'summ' => $summ);
        $lastId = $this->dbPrepare("INSERT INTO orders (`sid`, `quantity`, `date`, `product_id`, `summ`) VALUES (:sid, :quantity, :date, :product_id, :summ)", $data);

        if ($lastId > 0) {
          $this->setQuantityProductById($product['id'], $product['quantity'] - 1);
          return ['code' => true, 'summ' => $summ];
        }
      }else{
        return ['code' => false];
      }
    }

  }

  public function setQuantityProductById($id, $quantity){
    $data = array('id' => $id, 'quantity' => $quantity);
    $this->dbPrepare("UPDATE `product` SET quantity=:quantity WHERE id=:id", $data);
  }

}
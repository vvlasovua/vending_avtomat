<?php
class General extends Connect {

  protected $microtimeStart;
  public $arrSqlQuery = array();
  public $currentDate;


  /**
   * @param $arr
   */
  public function debug($arr)
  {
    echo "<pre>" . print_r($arr, true) . "</pre>";
  }

  /**
   * @param $sql
   * @param $data
   * @param int $type
   * @return array|mixed
   */
  public function db2arrayPrepare($sql, $data, $type=1){
    $this->setMicrotimeStart(microtime(true));
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);
    $this->countSqlQuery($stmt, $this->getMicrotimeStart());
    return ($type == 1) ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @param $sql
   * @param int $type
   * @return array|mixed
   */
  public function db2arrayQuery($sql, $type=1){
    $this->setMicrotimeStart(microtime(true));
    $stmt = $this->pdo->query($sql);
    $this->countSqlQuery($stmt, $this->getMicrotimeStart());
    return ($type == 1)?$stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @param $sql
   * @param $data
   * @return int
   */
  public function dbPrepare($sql, $data, $ret=0){
    $this->setMicrotimeStart(microtime(true));
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);
    $this->countSqlQuery($stmt, $this->getMicrotimeStart());
    return ($ret == '1') ? $this->pdo->lastInsertId() : $stmt->rowCount();
  }

  /**
   * @return mixed
   */
  public function getCurrentDate()
  {
    return $this->currentDate;
  }


  /**
   * @param $currentDate
   */
  public function setCurrentDate($currentDate)
  {
    $this->currentDate = $currentDate;
  }


  /**
   * @param $data
   * @param string $type
   * @return int|string
   */
  public function clearData($data, $type = "s")
  {
    switch ($type) {
      case "s":
        return htmlspecialchars(trim(strip_tags($data)));
      case "h":
        return htmlspecialchars(trim($data));
      case "i":
        return (int)$data;
    }
  }

  /**
   * @param $sql
   * @param string $time
   */
  public function countSqlQuery($sql, $time='')
  {
    if($time){$time = (microtime(true) - $time);}
    $this->arrSqlQuery[] = array($sql, round($time, 5));
  }

  /**
   * @return mixed
   */
  public function getMicrotimeStart()
  {
    return $this->microtimeStart;
  }

  /**
   * @param mixed $microtimeStart
   */
  public function setMicrotimeStart($microtimeStart)
  {
    $this->microtimeStart = $microtimeStart;
  }

}
<?php
Class Connect{
  public $pdo;

  /**
   * Connect constructor.
   * @throws Exception
   */
  public function __construct()
  {
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
    $options = array(
        PDO::ATTR_PERSISTENT            => true,
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    );

    // Create a new PDO instanace
    $this->pdo = new PDO($dsn, DB_LOGIN, DB_PASSWORD, $options);
    if(!$this->pdo) throw new Exception('connect error');
  }


}
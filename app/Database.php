<?php
declare(strict_types=1);

namespace App;

use PDO;

class Database
{
  public function getConnection() :PDO
  {
    $dsn = "mysql:host=localhost;dbname=jv";

    $pdo = new PDO($dsn, "joao", "root1234", 
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
    );
    return $pdo;
  }
}
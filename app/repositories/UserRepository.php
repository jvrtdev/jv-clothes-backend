<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Database;
use PDO;

class UserRepository
{
  protected $db;

  public function __construct(Database $db)
  {
   $this->db = $db;
  }
  
  public function createUser($data)
  {
    $sql = "INSERT INTO Clientes (nome, login, senha) VALUES (:nome, :login, :senha)";
    
    $stmt = $this->db->getConnection()->prepare($sql);

    $stmt->bindValue(':nome', $data->nome);
    $stmt->bindValue(':login', $data->login);
    $stmt->bindValue(':senha', $data->senha);

    return $stmt->execute();
  }
  
  public function loginUser($data) :PDO
  {
    $sql = 'SELECT * FROM Clientes WHERE email = :login AND senha = :senha';

    $stmt = $this->db->getConnection()->prepare($sql);
    
    $stmt->bindValue(':login', $data->login);
    $stmt->bindValue(':senha', $data->senha);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
  }

  
}
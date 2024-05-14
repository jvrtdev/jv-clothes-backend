<?php
declare(strict_types=1);
namespace App\Services;

use App\Database;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;

Class AuthJwt
{
  protected string $secret_key;
  
  protected $userRepository;

  public function __construct()
  {
    $this->secret_key = "minhachavesecreta";

    $database = new Database;
      
    $this->userRepository = new UserRepository($database);
  }
  
  public function createToken($userData)
  {
    $payload = [
      'login' => $userData['login'],
      'senha' => $userData['senha'],
    ];
    
    $jwt = JWT::encode($payload, $this->secret_key , 'HS256');//args->informacoes, chave secreta, criptografia
    
    return $jwt;
  }
  
  public function authUser()
  {
    
  }
}
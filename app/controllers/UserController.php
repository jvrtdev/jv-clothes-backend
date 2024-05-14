<?php
namespace App\Controllers;

use App\Database;
use App\Repositories\UserRepository;
use App\Services\AuthJwt;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
  protected $userRepository;
  
  protected $auth;
  

  public function __construct()
  {
    $db = new Database();

    $this->userRepository = new UserRepository($db);
    $this->auth = new AuthJwt;
    
  }

  public function createUser(Request $request, Response $response): Response
    {
      $body = $request->getBody();
      $data = json_decode($body);
    
      
      $result = $this->userRepository->createUser($data);
      if($result){
        $response->getBody()->write(json_encode(['message' => 'User created successfully']));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
      }
      $response->getBody()->write(json_encode(['message' => 'Failed to create user']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  
  public function loginUser(Request $request, Response $response)
  {
    $body = json_decode($request->getBody());
      
      $result = $this->userRepository->loginUser($body);
      
      if($result){
        $token = $this->auth->createToken($result);
    
        // Retorna o token JWT no cabeçalho de autorização
        $response = $response->withHeader('Authorization', $token);
        
        $response->getBody()->write(json_encode(['token'=> $token]));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
      }
      $response->getBody()->write(json_encode(['message'=>'Erro ao logar usuario, verifique as credenciais']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');  
  }
}
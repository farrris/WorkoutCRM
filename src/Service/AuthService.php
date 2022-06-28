<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\AppUser;
use App\Repository\AppUserRepository;

class AuthService {
  public function __construct(private AppUserRepository $appUserRepository,
                              private UserPasswordHasherInterface $passwordHasher) {}

  public function register(Request $request): Array 
  {
    $json_data = json_decode($request->getContent(), true);

    if (empty($json_data["username"]) || empty($json_data["email"]) || empty($json_data["password"])) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $username = $json_data["username"];
    $email = $json_data["email"];
    $password = $json_data["password"];

    if (($this->appUserRepository->findOneBy(["username" => $username]) != null)) {
      return ['message' => 'User already exists'];
    }

    $user = new AppUser();
    $user->setUsername($username);
    $user->setEmail($email);
    
    $hashed_password = $this->passwordHasher->hashPassword($user, $password);
    $user->setPassword($hashed_password);

    $this->appUserRepository->add($user, true);

    $response = $user->serialize();

    return $response;
  }
}
<?php
namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(IriConverterInterface $iriConverter)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".'
            ], 400);
        }
        else
        {
            $user = $this->getUser();

            $entityManager = $this->getDoctrine()->getManager();

            $token = implode('-',str_split(hash('sha256',random_bytes(256)),8));
            $expireAt = (new \DateTime())->modify('+2 hour');

            $tokenEntity = new \App\Entity\ApiToken();
            $tokenEntity->setUser($user);
            $tokenEntity->setToken($token);
            $tokenEntity->setExpireAt($expireAt);

            $entityManager->persist($tokenEntity);
            $entityManager->flush();

            return $this->json([
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'token' => $token,
                'expireAt' => $expireAt,
                'roles' => $user->getRoles(),
                'id' => $user->getId(),
            ], 200);
        }
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('should not be reached');
    }
}
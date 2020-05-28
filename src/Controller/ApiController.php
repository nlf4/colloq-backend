<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    //endpoint 1: someinfo
    /**
     * @Route("/api/someinfo", name="api_someinfo", methods={"GET"})
     */
    public function apiSomeInfo()
    {
        return $this->json(
            [
                "info" => "some",
            ],
            200, []);
    }

    //endpoint 2: account
    /**
     * @Route("/api/account", name="api_account", methods={"GET"})
     */
    public function apiAccount()
    {
        $user = $this->getUser();

        return $this->json(
            [
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "roles" => $user->getRoles()
            ],
            200, []);
    }
}

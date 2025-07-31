<?php

namespace App\HttpClient;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiHttpClient extends AbstractController
{
    private $API_Users;
    // private $test;

    public function __construct(HttpClientInterface $SfAPI_Users)
    // public function __construct(HttpClientInterface $SfAPI_Users, HttpClientInterface $API_Test)
    {
        $this->API_Users = $SfAPI_Users;
        // $this->test = $API_Test;
    }

    public function getAPI_Users()
    {
        $response = $this->API_Users->request('GET', "?results=15", [
            'verify_peer' => false,
        ]);

        return $response->toArray();
    }
}
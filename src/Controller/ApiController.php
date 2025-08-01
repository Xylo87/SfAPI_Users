<?php

namespace App\Controller;

use App\Entity\Membre;
use App\HttpClient\ApiHttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ApiController extends AbstractController
{
    #[Route('/users', name: 'users_list')]
    public function index(ApiHttpClient $apiHttpClient): Response
    {
        $users = $apiHttpClient->getAPI_Users();
        
        return $this->render('api/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/add-membre', name: 'membre_add', methods: 'POST')]
    public function addMembre(EntityManagerInterface $entityManager, Request $request, Membre $membre = null) 
    {
        $membre = new Membre();

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $last = ($_POST['last']);
        $last = strip_tags($last);
        
        $first = ($_POST['first']);
        $first = strip_tags($first);

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $streetnumber = filter_input(INPUT_POST, 'streetnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $streetname = ($_POST['streetname']);
        $streetname = strip_tags($streetname);

        $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $city = ($_POST['city']);
        $city = strip_tags($city);

        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($title && $last && $first && $email && $phone && $picture && $streetnumber && $streetname 
        && $postcode && $city && $country) {
            
            $membre->setTitle($title);
            $membre->setLast($last);
            $membre->setFirst($first);
            $membre->setEmail($email);
            $membre->setPhone($phone);
            $membre->setPicture($picture);
            $membre->setStreetnumber($streetnumber);
            $membre->setStreetname($streetname);
            $membre->setPostcode($postcode);
            $membre->setCity($city);
            $membre->setCountry($country);

            $entityManager->persist($membre);
            $entityManager->flush();

            $this->addFlash('success', 'User saved to database !');
            return $this->redirectToRoute('users_list');

        } else {
            
            $this->addFlash('fail', 'Something went wrong !');
            return $this->redirectToRoute('users_list');
        }
    }
}

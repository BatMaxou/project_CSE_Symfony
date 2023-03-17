<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TestController extends AbstractController
{
    #[Route(path: '/test', name: 'test')]
    public function test(ContactRepository $rep): Response
    {
        $path = [['Test', 'test']];

        $contacts = $rep->findAll();

        return $this->render('test.html.twig', [
            'contacts' => $contacts,
            'path' => $path,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render(
            'blog/home.html.twig',
            [
                'title' => 'Bienvenue sur le blog',
                'age' => 27,
            ]
        );
        //Pour envoyer des variables à une vue, on les passe dans un tableau associatif
        //Clé => valeur
    }

    //une route à 2 arguments : le chemin et le nom
    #[Route('/blog', name: 'app_blog')]

    //chaque route lance la méthode ci-dessous
    public function index(): Response
    {
        //la méthode render() qui permet d'afficher un template
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/blog/12', name: 'blog_show')]

    public function show()
    {
        return $this->render('blog/show.html.twig');
    }
}

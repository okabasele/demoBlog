<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(ArticleRepository $repo, Request $request): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form->get('recherche')->getData() != "") { //si on fait une recherche
           $data = $form->get('recherche')->getData(); //récuperer la saisie de l'utilisateur
           $articles = $repo->getArticlesByName($data);
        } else {
            $articles=$repo->findAll();
        }

        //la méthode render() qui permet d'afficher un template
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'formRecherche'=>$form->createView()
        ]);
    }

    #[Route('/blog/show/{id}', name: 'blog_show')]

    public function show(ArticleRepository $repo, int $id)
    {
        $article = $repo->find($id);
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]
    
    );
    }
}

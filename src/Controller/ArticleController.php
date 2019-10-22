<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"}, methods="GET")
     */
    public function show(string $id, ArticleRepository $repository)
    {
        $article = $repository->find($id);

        if(!$article) {
            throw $this->createNotFoundException('Article inexistant');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}

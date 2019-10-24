<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findLatestPublished();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/author/{id}")
     */
    public function indexByAuthor(Author $author, ArticleRepository $repository)
    {
        $articles = $repository->findBy(['writtenBy' => $author]);

        return $this->render('article/index_by_author.html.twig', [
            'author' => $author,
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/show/{slug}", methods="GET")
     */
    public function show(Article $article)
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"})
     * @IsGranted("ROLE_AUTHOR")
     */
    public function new(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_AUTHOR");
        if (false) {
            throw $this->createAccessDeniedException('Pas accès');
        }

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article, [
            'validation_groups' => ['new', 'Default'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->persistArticle($article, 'Le nouvel article a bien été créé');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/{slug}/edit",
     *     requirements={"id": "\d+"},
     *     methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article, [
            'full' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->persistArticle($article, 'L\'article a bien été modifié');
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    private function persistArticle(Article $article, string $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $this->addFlash('success', $message);

        return $this->redirectToRoute('app_article_show', [
            'slug' => $article->getSlug(),
        ]);
    }
}

<?php


namespace App\Service;


use App\Repository\ArticleRepository;

class ArticleSearcher
{

    /**
     * @var \App\Repository\ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(string $query): array
    {
        return $this->repository->findAll();
    }
}
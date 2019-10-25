<?php


namespace App\Service;


use App\Repository\ArticleRepository;

class ArticleSearcher
{
    private $repository;

    private $parser;

    public function __construct(
        ArticleRepository $repository,
        SearchQueryParser $parser
    ) {
        $this->repository = $repository;
        $this->parser = $parser;
    }

    public function search(string $query): array
    {
        $searchTerm = $this->parser->parse($query);

        return $this->repository->findByTermInTitle($searchTerm);
    }
}
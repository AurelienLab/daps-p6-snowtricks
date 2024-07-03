<?php

namespace App\Service;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as BasePaginator;
use Symfony\Component\HttpFoundation\Request;

class Paginator extends BasePaginator
{

    private $path = null;
    private $queryString = 'page';
    private $perPage = 10;

    private $currentPage = 1;

    public function __construct(
        Query|QueryBuilder       $query,
        private readonly Request $request,
        bool                     $fetchJoinCollection = true)
    {
        parent::__construct($query, $fetchJoinCollection);

        $this->resolveCurrentPage();
        $this->updateQuery();

    }

    public function path(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function queryString(string $parameter): self
    {
        $this->queryString = $parameter;
        $this->resolveCurrentPage();
        $this->updateQuery();
        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;
        $this->resolveCurrentPage();
        $this->updateQuery();
        return $this;
    }

    public function getLinks(): array
    {
        if ($this->count() < $this->perPage) {
            return [];
        }

        $totalPages = $this->getTotalPages();

        $pages = [];

        $basePath = $this->path ?? $this->request->getPathInfo();
        $query = $this->request->query->all();
        foreach (range(1, $totalPages) as $page) {
            $pages[] = [
                'page' => $page,
                'url' => $basePath . '?' . http_build_query(array_merge($query, [$this->queryString => $page])),
                'active' => $page === $this->request->query->getInt($this->queryString, 1),
            ];
        }

        return $pages;
    }

    public function isFirstPage(): bool
    {
        return $this->currentPage == 1;
    }

    public function isLastPage(): bool
    {
        $totalPages = $this->getTotalPages();
        return $this->currentPage == $totalPages;
    }

    public function previous(): string
    {
        $basePath = $this->path ?? $this->request->getPathInfo();
        $query = $this->request->query->all();

        return $basePath . '?' . http_build_query(array_merge($query, [$this->queryString => max(0, $this->currentPage - 1)]));
    }

    public function next(): string
    {
        $totalPages = $this->getTotalPages();

        $basePath = $this->path ?? $this->request->getPathInfo();
        $query = $this->request->query->all();

        return $basePath . '?' . http_build_query(array_merge($query, [$this->queryString => min($totalPages, $this->currentPage + 1)]));
    }

    public function hasMultiplePages(): bool
    {
        return $this->getTotalPages() > 1;
    }

    private function resolveCurrentPage(): void
    {
        $this->currentPage = $this->request->query->getInt($this->queryString, 1);
    }

    private function updateQuery(): void
    {
        $offset = $this->perPage * ($this->currentPage - 1);

        $this->getQuery()
             ->setMaxResults($this->perPage)
             ->setFirstResult($offset)
        ;
    }

    private function getTotalPages(): int
    {
        return (int)ceil($this->count() / $this->perPage);
    }
}
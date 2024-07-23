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


    /**
     * Force a path to use to generate urls
     * By default, the path is resolved from request
     *
     * @param string $path
     * @return $this
     */
    public function path(string $path): self
    {
        $this->path = $path;

        return $this;
    }


    /**
     * Update the page number query string parameter (default "page")
     *
     * @param string $parameter
     * @return $this
     */
    public function queryString(string $parameter): self
    {
        $this->queryString = $parameter;
        $this->resolveCurrentPage();
        $this->updateQuery();
        return $this;
    }


    /**
     * Set the amount of item per page (default 10)
     * @param int $perPage
     * @return $this
     */
    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;
        $this->resolveCurrentPage();
        $this->updateQuery();
        return $this;
    }


    /**
     * Get an array of pages with for each:
     * - page (int): number of the page
     * - url (string): the path to the corresponding page
     * - active (bool): Is the page actually selected
     *
     * @return array
     */
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


    /**
     * Are we on the first page of the pagination
     *
     * @return bool
     */
    public function isFirstPage(): bool
    {
        return $this->currentPage == 1;
    }


    /**
     * Are we on the last page of the pagination
     *
     * @return bool
     */
    public function isLastPage(): bool
    {
        $totalPages = $this->getTotalPages();
        return $this->currentPage == $totalPages;
    }


    /**
     * Get previous page url
     *
     * @return string
     */
    public function previous(): string
    {
        $basePath = $this->path ?? $this->request->getPathInfo();
        $query = $this->request->query->all();

        return $basePath . '?' . http_build_query(array_merge($query, [$this->queryString => max(0, $this->currentPage - 1)]));
    }


    /**
     * Get next page url
     *
     * @return string
     */
    public function next(): string
    {
        $totalPages = $this->getTotalPages();

        $basePath = $this->path ?? $this->request->getPathInfo();
        $query = $this->request->query->all();

        return $basePath . '?' . http_build_query(array_merge($query, [$this->queryString => min($totalPages, $this->currentPage + 1)]));
    }


    /**
     * Are there multiple pages
     *
     * @return bool
     */
    public function hasMultiplePages(): bool
    {
        return $this->getTotalPages() > 1;
    }


    /**
     * Update current page property from request (after a query string change for example)
     *
     * @return void
     */
    private function resolveCurrentPage(): void
    {
        $this->currentPage = $this->request->query->getInt($this->queryString, 1);
    }


    /**
     * Adapt ORM query to get current page data
     *
     * @return void
     */
    private function updateQuery(): void
    {
        $offset = $this->perPage * ($this->currentPage - 1);

        $this->getQuery()
             ->setMaxResults($this->perPage)
             ->setFirstResult($offset)
        ;
    }


    /**
     * Get the total amount of pages
     *
     * @return int
     */
    private function getTotalPages(): int
    {
        return (int)ceil($this->count() / $this->perPage);
    }


}
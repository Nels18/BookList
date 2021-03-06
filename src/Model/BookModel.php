<?php

namespace App\Model;

use App\Controller\PaginatorController;

class BookModel extends AbstractModel
{
    protected $id;
    protected $authorId;
    protected $categoryId;
    protected $title;
    protected $publishedAt;
    protected $summary;
    protected $createdAt;
    protected $updatedAt;
    protected $deletedAt;

    public function __construct()
    {
        $this->table = "book";
        $this->nbResourcesPerPage = 4;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }
    
        /**
         * Set the value of authorId
         *
         * @return  self
         */
        public function setId(int $id): self
        {
            $this->id = $id;
    
            return $this;
        }

    /**
     * Get the value of authorId
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * Set the value of authorId
     *
     * @return  self
     */
    public function setAuthorId(int $authorId): self
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get the value of categoryId
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * Set the value of categoryId
     *
     * @return  self
     */
    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of publishedAt
     */
    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    /**
     * Set the value of publishedAt
     *
     * @return  self
     */
    public function setPublishedAt(string $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get the value of summary
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * Set the value of summary
     *
     * @return  self
     */
    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of deletedAt
     */
    public function getDeletedAt(): string
    {
        return $this->deletedAt;
    }

    /**
     * Set the value of deletedAt
     *
     * @return  self
     */
    public function setDeletedAt(?string $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }


    public function findBooksWithCategoryAndAuthor()
    {
        $pagination = new PaginatorController($this);

        $sql = "SELECT b.id, b.title, a.first_name author_first_name, a.last_name author_last_name, c.name category, b.published_at, b.summary  FROM book b
        INNER JOIN author a ON a.id = b.author_id
        INNER JOIN category c ON c.id = b.category_id
        ORDER BY id
        ";
        $sql .= $pagination->paginationQuery() . ';';
        
        $query = $this->run($sql);

        return $query->fetchAll();
    }

    public function findRandoomBooks()
    {
        $sql = "SELECT b.id, b.title, a.first_name author_first_name, a.last_name author_last_name, c.name category, b.published_at, b.summary  FROM book b
        INNER JOIN author a ON a.id = b.author_id
        INNER JOIN category c ON c.id = b.category_id
        ORDER BY RAND()
        LIMIT 3;";
        
        $query = $this->run($sql);

        return $query->fetchAll();
    }
}

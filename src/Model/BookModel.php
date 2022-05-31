<?php

namespace App\Model;

class BookModel extends AbstractModel
{
    protected $id;
    protected $author_id;
    protected $category_id;
    protected $title;
    protected $published_at;
    protected $summary;

    public function __construct()
    {
        $this->table = "book";
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of author_id
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     *
     * @return  self
     */
    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Get the value of category_id
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

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
     * Get the value of published_at
     */
    public function getPublishedAt(): string
    {
        return $this->published_at;
    }

    /**
     * Set the value of published_at
     *
     * @return  self
     */
    public function setPublishedAt(string $published_at): self
    {
        $this->published_at = $published_at;

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
    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }
}

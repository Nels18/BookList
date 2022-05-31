<?php

namespace App\Controller;

use App\Chore\Database\Database;

class PaginatorController
{
    private $resource;
        
    private const NB_RESOURCES_PER_PAGE = 3;

    public function __construct(string $resource)
    {
        $this->resource = $resource;
    }

    public function getResourceCount()
    {
        $resource = $this->resource;
        $sql = 'SELECT COUNT(*) as total FROM ' . $resource;

        return Database::getInstance()->query($sql);
    }

    public function getPagesCount(): int
    {
        $nbResource = $this->getResourceCount();

        return ceil($nbResource[0]['total'] / self::NB_RESOURCES_PER_PAGE);
    }

    public function getCurrentPage(): int
    {
        @$page = $_GET['page'];
        if (is_null($page)) {
            $page = 1;
        }

        return $page;
    }

    public function getOffsetPaginationQuerry(): int
    {
        $offset = ($this->getCurrentPage() - 1) * self::NB_RESOURCES_PER_PAGE;
        return $offset;
    }

    public function renderQuery()
    {
        $offset = $this->getOffsetPaginationQuerry();
        $paginationQuery = "LIMIT " . $offset . ',' . self::NB_RESOURCES_PER_PAGE;
        return $paginationQuery;
    }

    public function render()
    {
        $page = $this->getCurrentPage();
        $nbPages = $this->getPagesCount(self::NB_RESOURCES_PER_PAGE);

        ob_start();
        include "src/View/component/paginator.php";
        
        return ob_get_clean();
    }

}

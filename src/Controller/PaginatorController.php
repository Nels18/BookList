<?php

namespace App\Controller;

use App\Model\AbstractModel;

class PaginatorController
{
    private $nbResource;
    private $nbResourcesPerPage;
    // private $nbPages = $this->getNbPages($this->nbResourcesPerPage);

    public function __construct(AbstractModel $resourceModel)
    {
        $this->nbResourcesPerPage = $resourceModel->nbResourcesPerPage;
        $this->nbResource = $resourceModel->getNbResource();
    }

    public function getNbPages(): int | float
    {
        return ceil(intval($this->nbResource['total']) / $this->nbResourcesPerPage);
    }

    public function getCurrentPage(): int
    {
        @$page = $_GET['page'];
        if (is_null($page)) {
            $page = 1;
        }

        return $page;
    }

    public function getOffsetPaginationQuery(): int
    {
        $offset = ($this->getCurrentPage() - 1) * $this->nbResourcesPerPage;
        return $offset;
    }

    public function paginationQuery()
    {
        $offset = $this->getOffsetPaginationQuery();
        $paginationQuery = "LIMIT " . $offset . ',' . $this->nbResourcesPerPage;
        return $paginationQuery;
    }

    public function render()
    {
        $page = $this->getCurrentPage();
        $nbPages = $this->getNbPages();
        $pageNotExist = $page > $nbPages;
        
        if ($pageNotExist) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            $_SESSION['errors'][] = "La page " . $page . " n'existe pas";
            exit;
        } else {
            ob_start();
            include "src/View/component/paginator.php";
    
            return ob_get_clean();
        }

    }

}

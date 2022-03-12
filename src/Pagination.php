<?php

namespace App;

use App\Database;

class Pagination
{
    public $resource;
    public function __construct(string $resource)
    {
        $this->resource = $resource;
    }

    public function getNbResource()
    {
        $resource = $this->resource;

        return Database::getInstance()->query(
            'SELECT COUNT(*) as total FROM ' . $resource
        );
    }
    
    public function getNbPages($nbResourcePerPage): int
    {
        $nbResource = $this->getNbResource();

        return ceil($nbResource[0]['total'] / $nbResourcePerPage);
    }
    
    public function getPage(): int
    {
        @$page = $_GET['page'];
        if (is_null($page)) {
            $page = 1;
        }
        
        return $page;
    }

    public function getOffset($nbResourcePerPage): int
    {
        return ($this->getPage() - 1) * $nbResourcePerPage;
    }

    public function getPaginationRequest($nbResourcePerPage)
    {
        $offset = $this->getOffset($nbResourcePerPage);
        
        return "LIMIT " . $offset . ',' . $nbResourcePerPage;
    }

    function getPagination(int $nbResourcePerPage)
    {
        $page = $this->getPage();
        $nbPages = $this->getNbPages($nbResourcePerPage);


        $output = '<nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" ';
        $output .= (1 < $page) ?  'href="?page=' . $page - 1 . '"' : '';
        $output .= ' >Previous</a>
                </li>';

        for ($i=1; $i <= $nbPages; $i++) {
            if ($page != $i) {
                $output .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i .'</a></li>';
            } else {
                $output .= '<li class="page-item active" aria-current="page"><a class="page-link">' . $i .'</a></li>';
            }
        }
        $output .= '<li class="page-item">
                    <a class="page-link" ';
        $output .= ($nbPages > $page) ?  'href="?page=' . $page + 1 . '"' : '';
        $output .= ' >Next</a>
                </li>
            </ul>
        </nav>
        ';

        return $output;
    }

}
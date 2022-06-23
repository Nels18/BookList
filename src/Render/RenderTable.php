<?php

namespace App\Render;

use App\Chore\Database\Database;

class RenderTable
{
    public function render(string $tableName): string
    {
        $results = Database::getInstance()->listTable($tableName);
        
        if (count($results) == 0) {
            return $this->noResults($tableName);
        }

        $output = <<<TABLE
            <h1>$tableName</h1>

            <table class="table">
                <tr>
        TABLE;
        foreach (array_keys($results[0]) as $th) {
            $output .= '<th>'.$th.'</th>';
        }

        $output .= '</tr>';

        foreach ($results as $row) {
            $output .= '<tr>';
            foreach ($row as $value) {
                $output .= '<td>'.$value.'</td>';
            }
            $output .= '</tr>';
        }

        $output .= '</table>';

        return $output;
    }

    private function noResults(string $tableName): string
    {
        return <<<TABLE
            <h1>$tableName</h1>

            <p>Aucun résultat trouvé</p>
        TABLE;
    }
}
<?php

namespace App\Model;

use App\Chore\Database\Database;

class AbstractModel extends Database
{
    // Table de la base de données
    public $table;

    // Instance de Database
    private $db;

    public function run(string $sql, array $params = null)
    {
        $this->db = Database::getInstance();
        $query = $this->db->prepare($sql);

        if (!is_null($params)) {
            $query->execute($params);
            return $query;
        }

        return $this->db->query($sql);
    }

    public function findAll()
    {
        $query = $this->run('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteria)
    {
        $columns = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($criteria as $column => $value) {
            // SELECT * FROM annonces WHERE actif = ? AND signale = 0
            // bindValue(1, value)
            $columns[] = $this->formatPropertyForDB($column) . " = ?";
            $values[] = $value;
        }

        // On transforme le tableau "columns" en une chaine de caractères
        $listColumns = implode(' AND ', $columns);

        // On exécute la requête
        return $this->run('SELECT * FROM ' . $this->table . ' WHERE ' . $listColumns, $values)->fetchAll();
    }

    public function findOne(int $id)
    {
        return $this->run('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id)->fetch();
    }

    public function create()
    {
        $columns = [];
        $inter = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($this as $column => $value) {
            // INSERT INTO annonces (titre, description, actif) VALUES (?, ?, ?)
            if ($value !== null && $column != 'db' && $column != 'table') {
                $columns[] = $this->formatPropertyForDB($column);
                $inter[] = "?";
                $values[] = $value;
            }
        }

        // On transforme le tableau "columns" en une chaine de caractères
        $list_columns = implode(', ', $columns);
        $list_inter = implode(', ', $inter);

        // On exécute la requête
        return $this->run('INSERT INTO ' . $this->table . ' (' . $list_columns . ')VALUES(' . $list_inter . ')', $values);
    }

    public function update()
    {
        $columns = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($this as $column => $value) {
            // UPDATE annonces SET titre = ?, author_id = ?, summary = ? WHERE id= ?
            if ($value !== null && $column != 'db' && $column != 'table') {
                $columns[] = $this->formatPropertyForDB($column) . " = ?";
                $values[] = $value;
            }
        }
        // On ajoute la valeur de l'id pour le 'WHERE'
        $values[] = $this->id;

        // On transforme le tableau "columns" en une chaine de caractères
        $list_columns = implode(', ', $columns);

        // On exécute la requête
        // ('UPDATE ' . $this->table . ' SET ' . $list_columns . ' WHERE id = ?', $values)
        return $this->run('UPDATE ' . $this->table . ' SET ' . $list_columns . ' WHERE id = ?', $values);
    }

    public function delete(int $id)
    {
        return $this->run('DELETE FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }

    public function hydrate($data)
    {

        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                $setter = $this->getSetter($key);
                // On vérifie si le setter existe
                if (method_exists($this, $setter)) {
                    // On appelle le setter
                    $this->$setter($value);
                }
            }
        }
        return $this;
    }

    public function getSetter($property)
    {
        // On récupère le nom du setter correspondant à la clé (key)
        $setter = 'set' . ucfirst($property);
        preg_match_all('/(?<=_)[a-z]/', $setter, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $char) {
            $indexCharToUpper = $char[1];
            $charToReplace = $setter[$indexCharToUpper];
            $setter[$indexCharToUpper] = strtoupper($charToReplace);
        };
        return $setter = str_replace('_', '', $setter);
    }

    public function formatPropertyForDB($property)
    {
        $newStrings = [];
        // On sépare la propriété au niveau des majuscules
        $strings = preg_split('/(?=[A-Z])/', $property);

        // On stocke chaque mots avec la majuscule transformée en minuscule
        foreach ($strings as $string) {
            $newStrings[] = lcfirst($string);
        };

        // On rassemble tous les mots en un seul séparer un '_'
        $property = implode('_', $newStrings);

        return $property;
    }
}

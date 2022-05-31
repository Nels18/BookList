<?php

namespace App\Model;

use App\Chore\Database\Database;

class AbstractModel extends Database
{
    // Table de la base de données
    protected $table;

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
            $columns[] = "$column = ?";
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

    public function create($model)
    {
        $columns = [];
        $inter = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($model as $column => $value) {
            // INSERT INTO annonces (titre, description, actif) VALUES (?, ?, ?)
            if ($value !== null && $column != 'db' && $column != 'table') {
                $columns[] = $column;
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

    public function update(int $id, $model)
    {
        $columns = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($model as $column => $value) {
            // UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if ($value !== null && $column != 'db' && $column != 'table') {
                $columns[] = "$column = ?";
                $values[] = $value;
            }
        }
        $values[] = $id;

        // On transforme le tableau "columns" en une chaine de caractères
        $list_columns = implode(', ', $columns);

        // On exécute la requête
        // ('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?', $valeurs)
        return $this->run('UPDATE ' . $this->table . ' SET ' . $list_columns . ' WHERE id = ?', $values);
    }

    public function delete(int $id)
    {
        return $this->run('DELETE FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }

    public function hydrate($data)
    {
        $entity = 'App\Entity\\' . ucfirst($this->table) . 'Entity';
        $entityIntance = new $entity();
        foreach ($data as $key => $value) {
            // On récupère le nom du setter correspondant à la clé (key)
            $setter = 'set' . ucfirst($key);
            preg_match_all('/(?<=_)[a-z]/', $setter, $matches, PREG_OFFSET_CAPTURE);

            foreach ($matches[0] as $matche => $char) {
                $indexCharToUpper = $char[1];
                $charToReplace = $setter[$indexCharToUpper];
                $setter[$indexCharToUpper] = strtoupper($charToReplace);
            };
            $setter = str_replace('_', '', $setter);

            
            // On vérifie si le setter existe
            if (method_exists($entity, $setter)) {
                // On appelle le setter
                $entityIntance->$setter($value);
            }
        }
        return $entityIntance;
    }

    // public function query(string $sql, array $params = []): array
    // {
    //     $statement = $this->pdo->prepare($sql);
    //     $statement->execute($params);

    //     return $statement->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function listTable(string $tableName): array
    // {
    //     return $this->query(`SELECT * FROM ${$tableName}`);
    // }
}

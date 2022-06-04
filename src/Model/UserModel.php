<?php

namespace App\Model;

use App\Model\AbstractModel;

class UserModel extends AbstractModel
{
    protected $id;
    protected $email;
    protected $password;
    protected $roles;
    protected $createdAt;
    protected $updatedAt;
    protected $deletedAt;


    public function __construct()
    {
        $this->table = "user";
    }

    /**
     * Récupérer un user à partir de son e-mail
     * @param string $email 
     * @return mixed 
     */
    public function findOneByEmail(string $email): mixed
    {
        return $this->run("SELECT * FROM {$this->table} WHERE email = ?", [$email])->fetch();
    }

    /**
     * Crée la session de l'utilisateur
     * @return void 
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles
        ];
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */
    public function setRoles($roles): self
    {
        $this->roles = json_decode($roles);

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

}

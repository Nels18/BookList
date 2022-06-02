<?php
namespace App\Chore;

class Form
{
    private $formCode = '';

    /**
     * Génère le formulaire HTML
     * @return string 
     */
    public function create()
    {
        return $this->formCode;
    }

    /**
     * Valide si tous les champs proposés sont remplis
     * @param array $form Tableau issu du formulaire ($_POST, $_GET)
     * @param array $field Tableau listant les champs obligatoires
     * @return bool 
     */
    public static function validate(array $form, array $field)
    {
        // On parcourt les champs
        foreach($field as $champ){
            // Si le champ est absent ou vide dans le formulaire
            if(!isset($form[$champ]) || empty($form[$champ])){
                // On sort en retournant false
                return false;
            }
        }
        return true;
    }


    /**
     * Ajoute les attributs envoyés à la balise
     * @param array $attributes Tableau associatif ['class' => 'form-control', 'required' => true]
     * @return string Chaine de caractères générée
     */
    private function addAttributs(array $attributes): string
    {
        // On initialise une chaîne de caractères
        $str = '';

        // On liste les attributs "courts"
        $shortAttributes = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        // On boucle sur le tableau d'attributs
        foreach($attributes as $attribut => $value){
            // Si l'attribut est dans la liste des attributs courts
            if(in_array($attribut, $shortAttributes) && $value == true){
                $str .= " $attribut";
            }else{
                // On ajoute attribut='valeur'
                $str .= " $attribut=\"$value\"";
            }
        }

        return $str;
    }

    /**
     * Balise d'ouverture du formulaire
     * @param string $method Méthode du formulaire (post ou get)
     * @param string $action Action du formulaire
     * @param array $attributes Attributs
     * @return Form 
     */
    public function startForm(string $method = 'post', string $action = '#', array $attributes = []): self
    {
        // On crée la balise form
        $this->formCode .= "<form action='$action' method='$method'";

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributs($attributes).'>' : '>';

        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     * @return Form 
     */
    public function endForm():self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Balise d'ouverture de la div
     * @param string $class
     * @return Form 
     */
    public function startDiv(string $class = null): self
    {
        // On crée la balise div
        $this->formCode .= "<div";

        // On ajoute les classes éventuels
        $this->formCode .= $class ? " class='$class'>" : '>';

        return $this;
    }

    /**
     * Balise de fermeture du groupe
     * @return Form 
     */
    public function endDiv():self
    {
        $this->formCode .= '</div>';
        return $this;
    }

    /**
     * Ajout d'un label
     * @param string $for 
     * @param string $text 
     * @param array $attributes 
     * @return Form 
     */
    public function addLabelFor(string $for, string $text, array $attributes = []):self
    {
        // On ouvre la balise
        $this->formCode .= "<label for='$for'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributs($attributes) : '';

        // On ajoute le texte
        $this->formCode .= ">$text</label>";

        return $this;
    }


    /**
     * Ajout d'un champ input
     * @param string $type 
     * @param string $name 
     * @param array $attributes 
     * @return Form 
     */
    public function addInput(string $type, string $name, array $attributes = []):self
    {
        // On ouvre la balise
        $this->formCode .= "<input type='$type' name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributs($attributes).'>' : '>';

        return $this;
    }

    /**
     * Ajoute un champ textarea
     * @param string $name Nom du champ
     * @param string $value Valeur du champ
     * @param array $attributes Attributs
     * @return Form Retourne l'objet
     */
    public function addTextarea(string $name, string $value = '', array $attributes = []):self
    {
        // On ouvre la balise
        $this->formCode .= "<textarea name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributs($attributes) : '';

        // On ajoute le texte
        $this->formCode .= ">$value</textarea>";

        return $this;
    }


    /**
     * Liste déroulante
     * @param string $name Nom du champ
     * @param array $options Liste des options (tableau associatif)
     * @param array $attributes 
     * @return Form
     */
    public function addSelect(string $name, array $options, array $attributes = [], string | null $placeholder = null):self
    {
        // On crée le select
        $this->formCode .= "<select name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributs($attributes).'>' : '>';

        // On ajoute les options
        if ($placeholder) {
            $this->formCode .= "<option>$placeholder</option>";
        }

        foreach($options as $value => $text){
            $this->formCode .= "<option value=\"$value\">$text</option>";
        }

        // On ferme le select
        $this->formCode .= '</select>';

        return $this;
    }


    /**
     * Ajoute un bouton
     * @param string $text 
     * @param array $attributes 
     * @return Form
     */
    public function addButton(string $text, array $attributes = []):self
    {
        // On ouvre le bouton
        $this->formCode .= '<button ';

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributs($attributes) : '';

        // On ajoute le texte et on ferme
        $this->formCode .= ">$text</button>";

        return $this;
    }
}
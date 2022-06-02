<?php
namespace App\Chore;

class Validator
{
    const ILLEGAL_CHARACTERS = "/^[A-Za-z](\s)*[A-Za-z]+((\s)?((\'|\-|\.)?([A-Za-z])+))*(\s)*$/";

    public static function required(string $field, string $data)
    {
        $message = 'Le champ ' . $field . ' est requis.';
        if ($data === '') {
            return $message;
        }
        
        echo $data . ' : valide, required';
        return false;
    }

    public static function noSpecialCharacters(string $field, string $data)
    {
        $message = 'Le champ ' . $field . ' ne doit pas contenir de caractères spéciaux ou de chiffres.';

        if ($data === '') return;

        if (1 !== preg_match(self::ILLEGAL_CHARACTERS, $data)) {
            return $message;
        }
        
        var_dump($data);
        echo $data . ' : valide, noSpecialCharacters';
        return false;
    }
}
<?php

namespace App\MyService;

class Censurator
{
    private array $offensiveWords = ['sex', 'porno', 'connard']; // Ta liste de mots offensants

    public function purify(string $string): string
    {


        // Remplacer les mots offensants par des étoiles
        foreach ($this->offensiveWords as $word) {
            // Remplacement par des étoiles, on garde la longueur du mot
            $string = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', str_repeat('*', mb_strlen($word)), $string);
        }

        return $string;
    }
}

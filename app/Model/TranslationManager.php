<?php

namespace App\Model;

class TranslationManager {

    const VOWELS = 'aeiou';
    const CONSONANTS = 'bcdfgjklmnpqstvxzhrwy';
    const CONSONANT_CLUSTERS = ['bl', 'cl', 'fl', 'gl', 'pl', 'sl', 'br', 'cr', 'dr',
        'fr', 'gr', 'pr', 'tr', 'sc', 'sk', 'sm', 'sn', 'sp', 'st', 'sw', 'tw', 'sch',
        'shr', 'spl', 'squ', 'thr', 'spr', 'scr', 'sph'];
    const SUFFIX = 'ay';

    public function translate(string $text): string {
        $input = strtolower($text);
        $words = explode(' ', $input);
        $output = [];
        foreach ($words as $word) {
            $output[] = $this->translateValidWord($word);
        }
        return implode(' ', $output);
    }

    private function translateValidWord(string $word): string {
        $validWord = preg_match("/^[a-z]*$/", $word);

        if ($validWord && strlen($word) > 0) {
            return $this->translateWord($word);
        } else {
            return $word;
        }
            
    }

    private function translateWord(string $word): string {
        for ($i = 0; $i < 3; $i++) {
            switch ($i) {
                case 0:
                    $result = $this->hasVowel($word);
                    if ($result) {
                        return $result;
                    }
                case 1:
                    $result = $this->hasConsonantCluster($word);
                    if ($result) {
                        return $result;
                    }
                case 2:
                    $result = $this->hasConsonant($word);
                    if ($result) {
                        return $result;
                    }
            }
        }
        return $word;
    }

    private function hasConsonant($word) {
        $letters = str_split($word);
        if (preg_match('/^[' . self::CONSONANTS . ']/', $letters[0])) {
            $letter = $letters[0];
            unset($letters[0]);
            return implode('', $letters) . $letter . self::SUFFIX;
        }
        return false;
    }

    private function hasConsonantCluster($word) {
        foreach (self::CONSONANT_CLUSTERS as $cc) {
            if (strpos($word, $cc) === 0) {
                $letters = substr($word, strlen($cc));
                return $letters . $cc . self::SUFFIX;
            }
        }
        return false;
    }

    private function hasVowel($word) {
        if (preg_match('/[' . self::VOWELS . ']/', $word[0])) {
            $letters = str_split($word);
            unset($letters[0]);
            return $word . 'y' . self::SUFFIX;
        }
        return false;
    }

}

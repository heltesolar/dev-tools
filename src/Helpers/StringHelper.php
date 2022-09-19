<?php

namespace Helte\DevTools\Helpers;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Helte\DevTools\Helpers\Regex;

class StringHelper {
    const ACCENTS_TO_ASCII_MAP = [
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ù' => 'u',
        'ü' => 'u',
        'ú' => 'u',
        'ñ' => 'n',
        'ÿ' => 'y',
        'ç' => 'c',
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ù' => 'U',
        'Ü' => 'U',
        'Ú' => 'U',
        'Ñ' => 'N',
        'Ÿ' => 'Y',
        'Ç' => 'C',    
    ];

    /**
     * en-us:
     * Casts string to array.
     * 
     * pt-br:
     * Converte string em array.
     * 
     * @param string $text
     * @return array<string>
     */
    public static function toArray($text) {
        return str_split($text, 1);
    }

    /**
     * en-us:
     * Replaces accents with the corresponding ascii value.
     * 
     * pt-br:
     * Substitui acentos por seu caractere ascii correspondente.
     * 
     * @param  string  $text
     * @return string
     */
    public static function replaceAccents(string $text) {
        return strtr($text, self::ACCENTS_TO_ASCII_MAP);
    }

    /**
     * en-us:
     * Removes all digits from a string.
     * 
     * pt-br:
     * Remove todos os dígitos da string.
     * 
     * @param string $text
     * @return string
     */
    public static function stripDigits($text) {
        return preg_replace('/\d/', '', $text);
    }
    
    /**
     * en-us:
     * Removes all non-digits from a string.
     * 
     * pt-br:
     * Remove todos os não dígitos da string.
     * 
     * @param string $text
     * @return string
     */
    public static function stripNonDigits($text) {
        return preg_replace('/\D/', '', $text);
    }
    
    /**
     * en-us:
     * Removes all letter characters from a string.
     * 
     * pt-br:
     * Remove todos os caracteres letras da string.
     * 
     * @param string $text
     * @param bool $match_unicode
     * @return string
     */
    public static function stripLetters($text, $match_unicode = false) {
        $extra_chars = $match_unicode ? static::getCharsWithAccents() : '';

        return preg_replace("/[a-zA-Z$extra_chars]/", '', $text);
    }
    
    /**
     * en-us:
     * Removes all non-letter characters from a string.
     * 
     * pt-br:
     * Remove todos os caracteres não letras da string.
     * 
     * @param string $text
     * @param bool $match_unicode
     * @return string
     */
    public static function stripNonLetters($text, $match_unicode = false) {
        $extra_chars = $match_unicode ? static::getCharsWithAccents() : '';

        return preg_replace("/[^a-zA-Z$extra_chars]/", '', $text);
    }
    
    /**
     * en-us:
     * Removes all alphanumeric characters from a string.
     * 
     * pt-br:
     * Remove todos os caracteres alfanuméricos da string.
     * 
     * @param string $text
     * @param bool $match_unicode
     * @return string
     */
    public static function stripAlpha($text, $match_unicode = false) {
        $extra_chars = $match_unicode ? static::getCharsWithAccents() : '';

        return preg_replace("/[a-zA-Z\d$extra_chars]/", '', $text);
    }
    
    /**
     * en-us:
     * Removes all non-alphanumeric characters from a string.
     * 
     * pt-br:
     * Remove todos os caracteres não alfanuméricos da string.
     * 
     * @param string $text
     * @param bool $match_unicode
     * @return string
     */
    public static function stripNonAlpha($text, $match_unicode = false) {
        $extra_chars = $match_unicode ? static::getCharsWithAccents() : '';

        return preg_replace("/[^a-zA-Z\d$extra_chars]/", '', $text);
    }

    /**
     * en-us:
     * Ensures a given string does not have consecutive spaces.
     * 
     * pt-br:
     * Garante que uma string não possui espaços consecutivos.
     * 
     * @param string $text
     * @return string
     */
    public static function shortenSpaces($text) {
        return Regex::replace('/\s+/', ' ', $text);
    }

    /**
     * en-us:
     * For each word, first letter becomes uppercase while remaining letters become lowercase.
     * 
     * pt-br:
     * Para cada palavra, primeira letra se torna maiúscula enquanto as outras se tornam minúsculas.
     * 
     * @param string $text
     * @return string
     */
    public static function capitalize($text) {
        return ucwords(strtolower($text));
    }

    /**
     * en-us:
     * Informs if a given date represented as string is valid.
     * Requires format to be YYYY-MM-DD zero-padded. 
     * 
     * pt-br:
     * Informa se uma data informada como string é válida.
     * Exige que o formato seja YYYY-MM-DD preenchido com zeros.
     * 
     * @param string $date
     * @return bool
     */
    public static function checkDate($date) {
        try {
            return Carbon::createFromFormat('Y-m-d', $date)->toDateString() === $date;
        }
        catch (InvalidFormatException $e) {
            return false;
        }
    }

    /**
     * en-us:
     * Informs if a given date represented as string is valid.
     * Requires format to be YYYY-MM-DD hh:mm:ss zero-padded. 
     * 
     * pt-br:
     * Informa se um datetime informado como string é válido.
     * Exige que o formato seja YYYY-MM-DD hh:mm:ss preenchido com zeros.
     * 
     * @param string $date
     * @return bool
     */
    public static function checkDateTime($date) {
        try {
            return Carbon::parse($date)->format('Y-m-d\TH:i:s.00000Z') . 'Z' === $date;
        }
        catch (InvalidFormatException $e) {
            return false;
        }
    }

    /**
     * en-us:
     * Informs if a given brazilian date represented as string is valid.
     * Requires format to be DD/MM/YYYY zero-padded. 
     * 
     * pt-br:
     * Informa se uma data brasileira informada como string é válida.
     * Exige que o formato seja DD/MM/YYYY preenchido com zeros.
     * 
     * @param string $date
     * @return bool
     */
    public static function checkBrazilDate($date) {
        return Regex::match('/^\d{2}\/\d{2}\/\d{4}$/', $date) != null;
    }

    /**
     * Slices string from initial index to a final index.
     * 
     * @param string $text
     * @param int $start
     * @param int|null $end
     */
    public static function slice($text, $start, $end = null) {
        if ($end === null) {
            $end = strlen($text);
        }

        throw_if($start > $end, "Expected start index to be smaller or equal to end index");

        $end -= $start;

        return substr($text, $start, $end);
    }

    /**
     * Split reverso.
     * 
     * @param  string  $string
     * @param  string  $separator
     * @param  int  $limit
     * @return array
     */
    public static function splitReverse(string $string, string $separator, int $limit) {
        $parts = explode($separator, $string);

        if ($limit <= 0 || $limit >= count($parts)) {
            return $parts;
        }

        $index = count($parts) - $limit + 1;
        $initial_part = array_slice($parts, 0, $index);
        $initial_part_joined = implode($separator, $initial_part);
        $remaining_parts = array_slice($parts, $index);

        return [$initial_part_joined, ...$remaining_parts];
    }

    /**
     * Tenta extrair um número de uma string.
     * 
     * @param string $string
     * @return int|double|null
     */
    public static function extractNumber($string) {
        $match = Regex::match('/(\d+)(?:[.,](\d+))?/', $string);

        if ($match === null) {
            return null;
        }

        if (array_key_exists(2, $match)) {
            return (float) ($match[1] . '.' . $match[2]);
        }

        return (int) ($match[1]);
    }

    /**
     * en-us:
     * Get unicode characters with accents.
     * 
     * pt-br:
     * Retorna caracteres unicode com acentos.
     * 
     * @return array<string>
     */
    private static function getCharsWithAccents() {
        return array_keys(static::ACCENTS_TO_ASCII_MAP);
    }
}

<?php

namespace Helte\DevTools\Helpers;

class Regex
{
    /**
     * Retorna primeiro match que for encontrado, senão retorna null.
     * Index 0 possui o resultado do match, os próximos index possuem os grupos correspondentes.
     *
     * @param string $regex
     * @param string $string
     * @return array|null
     */
    public static function match($regex, $string) {
        $match = null;
        preg_match($regex, $string, $match);

        if (!isset($match[0])) {
            return null;
        }

        return $match;
    }

    /**
     * Retorna array com todos os matches de um regex.
     * Index 0 possui os matches, os próximos index possuem os grupos correspondentes.
     *
     * @param string $regex
     * @param string $string
     * @return Array<array>
     */
    public static function matchAll($regex, $string) {
        $matches = null;
        preg_match_all($regex, $string, $matches);

        return $matches;
    }

    /**
     * Wrapper de preg_replace.
     *
     * @param string $regex
     * @param string $replacement
     * @param string $string
     * @return string
     */
    public static function replace($regex, $replacement, $string) {
        return preg_replace($regex, $replacement, $string);
    }
}

<?php

class Util {

    /**
     * Determine if a given string contains a given sub-string.
     *
     * @param  string        $haystack
     * @param  string|array  $needle
     * @return bool
     */
    static public function str_contains($haystack, $needle) {
        foreach ((array) $needle as $n) {
            if (strpos($haystack, $n) !== false) return true;
        }

        return false;
    }

    /**
     * Return the value of the given item.
     *
     * If the given item is a Closure the result of the Closure will be returned.
     *
     * @param  mixed  $value
     * @return mixed
     */
    static public function value($value) {
        return (is_callable($value) and ! is_string($value)) ? call_user_func($value) : $value;
    }
}

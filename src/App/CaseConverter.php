<?php

namespace App;

class CaseConverter
{
   public static function normalToSnake(string $string): string
   {
       $string = \explode(' ', $string);
       $string = \array_map('strtolower', $string);

       return \implode('_', $string);
   }

   public static function normalToUpperCamel(string $string): string
   {
       $string = \explode(' ', $string);
       $string = \array_map('ucfirst', $string);

       return \implode('', $string);
   }

   public static function upperCamelToSnake(string $string): string
   {
       \preg_match_all('/[A-Z][a-z]+/', $string, $matches);

       return self::normalToSnake(\implode(' ', $matches[0]));
   }
}

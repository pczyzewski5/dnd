<?php

declare(strict_types=1);

namespace App;

class CaseConverter
{
   public static function normalToSnake(string $string): string
   {
       $string = self::cleanup($string);
       $string = \explode(' ', $string);
       $string = \array_map('strtolower', $string);

       return \implode('_', $string);
   }

   public static function normalToUpperCamel(string $string): string
   {
       $string = self::cleanup($string);
       $string = \explode(' ', $string);
       $string = \array_map('ucfirst', $string);

       return \implode('', $string);
   }

   private static function cleanup(string $string): string
   {
       return \preg_replace('/[^A-Za-z ąśćźżńłęó]/', '', $string);
   }
}

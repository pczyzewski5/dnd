<?php

namespace DND\Domain\SavingThrows;

class SavingThrowsFactory
{
    public static function create(): SavingThrows
    {
        return new SavingThrows();
   }
}
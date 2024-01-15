<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class LanguageEnum extends Enum
{
    const GNOLL = 'gnoll';
    const ORC = 'orc';
    const COMMON = 'common';
    const ABYSSAL = 'abyssal';
    const INFERNAL = 'infernal';
    const UNDERCOMMON = 'undercommon';
    const DRACONIC = 'draconic';
    const GIANT = 'giant';
    const ELF = 'elf';
    const ANY = 'any';
    const DWARF = 'dwarf';
    const HALFING = 'halfing';
    const AURAN = 'auran';
    const GNOMISH = 'gnomish';
    const DRUID = 'druid';
    const SYLVAN = 'sylvan';
    const PRIMORDIAL = 'primordial';
}
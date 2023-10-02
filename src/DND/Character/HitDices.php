<?php

namespace DND\Character;

use DND\Domain\Enum\HitDiceEnum;

class HitDices
{
    private int $D6 = 0;
    private int $D8 = 0;
    private int $D10 = 0;
    private int $D12 = 0;

    public function increaseDiceCount(HitDiceEnum $hitDiceEnum): void
    {
        $name = $hitDiceEnum->getKey();
        $this->$name += 1;
    }

    public function toArray(): array
    {
        $result = [];

        foreach (HitDiceEnum::keys() as $key) {
            if ($this->$key > 0) {
                $result[] = [
                    'type' => HitDiceEnum::$key(),
                    'count' => $this->$key
                ];
            }
        }

        return $result;
    }
}
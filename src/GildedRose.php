<?php

namespace Runroom\GildedRose;

class GildedRose
{

    private $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    function update_quality()
    {
        foreach ($this->items as $item) {

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in = $this->decrease($item->sell_in);
            }

            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0 and $item->name != 'Sulfuras, Hand of Ragnaros') {
                    $item->quality = $this->decrease($item->quality);
                }
            } else if ($item->quality < 50) {
                $item->quality = $this->increase($item->quality);
                if ($item->name == 'Backstage passes to a TAFKAL80ETC concert' and $item->sell_in < 10 and $item->quality < 50) {
                    $item->quality = $this->increase($item->quality);
                    if ($item->sell_in < 5 and $item->quality < 50) {
                        $item->quality = $this->increase($item->quality);
                    }
                }
            }

            if ($item->sell_in < 0) {
                if ($item->name == 'Aged Brie') {
                    if ($item->quality < 50) {
                        $item->quality = $this->increase($item->quality);
                    }
                } else {
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                        $item->quality = $this->decrease($item->quality, $item->quality);
                    } else if ($item->quality > 0 and $item->name != 'Sulfuras, Hand of Ragnaros') {
                        $item->quality = $this->decrease($item->quality);
                    }
                }
            }
        }
    }

    private function increase($value, $mutiplicator = 1)
    {
        return $value + (1 * $mutiplicator);
    }

    private function decrease($value, $mutiplicator = 1)
    {
        return $value - (1 * $mutiplicator);
    }
}

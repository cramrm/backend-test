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

            //initial filter by not Sulfuras, Hand of Ragnaros
            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in = $this->decrease($item->sell_in);

                //exclude Aged Brie and Backstage passes to a TAFKAL80ETC concert
                if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->quality > 0) {
                        $item->quality = $this->decrease($item->quality );
                        if ($item->sell_in < 0){
                            $item->quality = $this->decrease($item->quality );
                        }
                    }
                //Aged Brie and Backstage passes to a TAFKAL80ETC concert with item quality < 50
                } else if ($item->quality < 50) {
                    $item->quality = $this->increase($item->quality);
                    //only Aged Brie
                    if ($item->name == 'Aged Brie' and $item->sell_in < 0) {
                        $item->quality = $this->increase($item->quality);
                    }
                    //only Backstage passes to a TAFKAL80ETC concert
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert' ) {
                        if ($item->sell_in < 10 ) {
                            $item->quality = $this->increase($item->quality);

                            if ($item->sell_in < 5) {
                                $item->quality = $this->increase($item->quality);
                            }

                            if ($item->sell_in < 0) {
                                $item->quality = $this->decrease($item->quality, $item->quality);
                            }
                        }
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

<?php

namespace App;

abstract class ItemStrategy
{
    protected $item;

    public function __construct(GildedRose $item)
    {
        $this->item = $item;
    }

    abstract public function tick();
}

class NormalItem extends ItemStrategy
{
    public function tick()
    {
        if ($this->item->quality > 0) 
        {
            $this->item->quality -= 1;
            if ($this->item->sellIn <= 0) 
            {
                $this->item->quality -= 1;
            }
            if ($this->item->quality < 0) 
            {
                $this->item->quality = 0;
            }
        }
        $this->item->sellIn--;
    }
}

class ConjuredItem extends ItemStrategy
{
    public function tick()
    {
        if ($this->item->quality > 0) 
        {
            $this->item->quality -= 2;
            if ($this->item->sellIn <= 0) 
            {
                $this->item->quality -= 2;
            }
            if ($this->item->quality < 0) 
            {
                $this->item->quality = 0;
            }
        }
        $this->item->sellIn--;
    }
}

class AgedBrie extends ItemStrategy
{
    public function tick()
    {
        if ($this->item->quality < 50) 
        {
            $this->item->quality++;
            //si ya pasaron los días para vender, se incrementa la calidad nuevamente
            //pero no puede ser mayor a 50
            if ($this->item->sellIn <= 0 && $this->item->quality < 50) 
            {
                $this->item->quality++;
            }
        }
        $this->item->sellIn--;
    }
}

class Sulfuras extends ItemStrategy
{
    public function tick()
    {
    }
}

class BackstagePass extends ItemStrategy
{
    public function tick()
    {
        // es cero cuando termino el concierto
        if ($this->item->sellIn <= 0) 
        {
            $this->item->quality = 0;
        } 
        else 
        {
            if ($this->item->quality < 50) 
            {
                $this->item->quality++;
                // si quedan menos de 10 días, se incrementa nuevamente
                if ($this->item->sellIn <= 10 && $this->item->quality < 50) 
                {
                    $this->item->quality++;
                }
                // si quedan menos de 5 días, se incrementa nuevamente
                if ($this->item->sellIn <= 5 && $this->item->quality < 50) 
                {
                    $this->item->quality++;
                }
            }
        }
        $this->item->sellIn--;
    }
}

class GildedRose
{
    public $name;
    public $quality;
    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        $strategy = $this->getStrategy();
        $strategy->tick();
    }

    private function getStrategy()
    {
        if ($this->name === 'Aged Brie') 
        {
            return new AgedBrie($this);
        }
        if ($this->name === 'Sulfuras, Hand of Ragnaros') 
        {
            return new Sulfuras($this);
        }
        if ($this->name === 'Backstage passes to a TAFKAL80ETC concert') 
        {
            return new BackstagePass($this);
        }
        if (stripos($this->name, 'Conjured') !== false) 
        {
            return new ConjuredItem($this);
        }
        return new NormalItem($this);
    }
}

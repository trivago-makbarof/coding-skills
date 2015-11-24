<?php

class Hotel {
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function match(Hotel $hotel) {
        return $this->name = $hotel->name;
    }
}

class Manager {
    private $boss = false;
    /** @var Hotel[] */
    private $hotel = [];
    private $location;

    public function newHotel(Hotel $hotel) {
        $this->hotel[] = $hotel;
    }

    public function promote() {
        $this->boss = true;
    }

    public function location($location) {
        $this->location = $location;
    }

    public function hasLocation($location) {
        return $this->location = $location;
    }

    public function isHotel(Hotel $hotel) {
        $result = false;
        foreach ($this->hotel as $h) {
            if ($h->match($hotel))
            {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public function numberOfHotels() {
        return count($this->hotel);
    }
}

$manager = new Manager();
<?php

namespace App\Naming;

/**
 * Class Hotel
 * @package App\Naming
 */
class Hotel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param Hotel $hotel
     * @return string
     */
    public function equals(Hotel $hotel)
    {
        return $this->name === $hotel->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

/**
 * Class HotelManager
 * @package App\Naming
 */
class HotelManager
{
    /**
     * @var bool
     */
    private $isBoss;

    /**
     * @var array
     */
    private $hotelCollection = [];

    /**
     * @var string
     */
    private $location;

    /**
     * @param array $hotelCollection
     * @param string $location
     */
    public function __construct($hotelCollection = [], $location = 'No location provided')
    {
        $this->isBoss = false;
        $this->location = $location;
        $this->hotelCollection = $hotelCollection;
    }

    /**
     * @param Hotel $hotel
     * @return HotelManager
     */
    public function addHotel(Hotel $hotel)
    {
        $this->hotelCollection[] = $hotel;

        // Fluent Interface pattern :)
        return $this;
    }

    /**
     * Promote as boss
     */
    public function promoteAsBoss()
    {
        $this->$isBoss = true;
    }

    /**
     * @param $location
     * @return HotelManager
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param $location
     * @return bool
     */
    public function hasLocation($location)
    {
        return $this->location === $location;
    }

    /**
     * @param Hotel $hotel
     * @return bool
     */
    public function hasHotel(Hotel $hotel)
    {
        foreach ($this->hotelCollection as $hotelInCollection) {
            if ($hotelInCollection->equals($hotel)) {
                return true;
            }
        }
    }

    /**
     * @return int
     */
    public function numberOfHotels()
    {
        return count($this->hotelCollection);
    }
}


$hotelManager = new HotelManager();

$hotelManager
    ->addHotel(new Hotel('Palma bay Hotel'))
    ->addHotel(new Hotel('Barcelona resort'));

<?php

// Moving forwards when in a vehicle position will get you in the vehicle
// if you're out of it otherwise it takes you out of the vehicle

// Just for sake of using a constant!

/* I prefer ValueObject classes instead of that constants and loading the value from a config file :)
 *
 * eg:
 *
 * $office = new Office(getenv('OFFICE_LOCATION'));
 * $home = new Home(getenv('HOME_LOCATION'));
 */
define('OFFICE_POSITION', 20);
define('HOME_POSITION', 0);

/**
 * Interface Location
 */
interface Location
{
    public function getPosition();
}

/**
 * Class Home
 */
class Home implements Location
{
    /**
     * @var
     */
    private $position;

    /**
     * @param $position
     */
    public function __construct($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }
}

/**
 * Class Office
 */
class Office implements Location
{
    /**
     * @var
     */
    private $position;

    /**
     * @param $position
     */
    public function __construct($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }
}

/**
 * Class Person
 */
class Person
{
    /**
     * @var
     */
    private $leftLeg;

    /**
     * @var
     */
    private $rightLeg;

    /**
     * @var null
     */
    private $currentForwardLeg = null;

    /**
     * @var
     */
    private $brain;

    /**
     * @var
     */
    private $currentPosition;

    /**
     * @param Vehicle $vehicle
     */
    private function goToVehicle(Vehicle $vehicle)
    {
        while ($this->currentPosition != $this->brain->locate($vehicle)) {
            if (is_null($this->currentForwardLeg)) {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
                break;
            } elseif ($this->currentForwardLeg === $this->rightLeg) {
                $this->leftLeg->moveForward();
                $this->currentForwardLeg = $this->leftLeg;
                $this->currentPosition++;
                break;
            } else {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
                break;
            }
        }

    }

    /**
     * @param Vehicle $vehicle
     */
    private function openVehicleDoor(Vehicle &$vehicle)
    {
        if ($vehicle instanceof VehicleWithDoor) {
            $vehicle->openDoor();
        }
    }

    /**
     * @param Vehicle $vehicle
     */
    private function closeVehicleDoor(Vehicle &$vehicle)
    {
        if ($vehicle instanceof VehicleWithDoor) {
            $vehicle->closeDoor();
        }
    }

    /**
     * @param Vehicle $vehicle
     */
    public function getOnVehicle(Vehicle &$vehicle)
    {
        $this->openVehicleDoor($vehicle);

        if ($this->currentForwardLeg === $this->rightLeg) {
            $this->leftLeg->moveForward();
            $this->currentForwardLeg = $this->leftLeg;
            $this->currentPosition++;
        } else {
            $this->rightLeg->moveForward();
            $this->currentForwardLeg = $this->rightLeg;
            $this->currentPosition++;
        }

        $this->closeVehicleDoor($vehicle);
    }

    /**
     * @param Vehicle $vehicle
     * @param Location $location
     */
    public function goToLocation(Vehicle $vehicle, Location $location)
    {
        $this->goToVehicle($vehicle);

        $this->getOnVehicle($vehicle);

        $vehicle->driveTo($location->getPosition(), function(Vehicle $vehicle, $position) {

            $this->currentPosition = $position;

            $this->getOnVehicle($vehicle);
        });
    }
}

/**
 * Interface Brain
 */
interface Brain
{
    public function locate(Thing $thing);
}

/**
 * Interface Leg
 */
interface Leg
{
    public function moveForward();
}

/**
 * Interface Thing
 */
interface Thing
{

}

/**
 * Interface VehicleWithDoor
 */
interface VehicleWithDoor extends Vehicle
{
    public function openDoor();

    public function closeDoor();
}

/**
 * Interface Vehicle
 */
interface Vehicle extends Thing
{
    public function driveTo($destination, $callback);
}
<?php

//Moving forwards when in a vehicle position will get you in the vehicle if you're out of it otherwise it takes you out of the vehicle

// Just for sake of using a constant!
define('OFFICE_POSITION', 20);
define('HOME_POSITION', 0);

class Person
{
    /** @var Leg */
    private $leftLeg;
    /** @var Leg */
    private $rightLeg;
    private $currentForwardLeg = null;
    /** @var  Brain */
    private $brain;
    private $currentPosition;


    public function goToOffice(Vehicle $vehicle)
    {
        while ($this->currentPosition != $this->brain->locate($vehicle))
        {
            if (is_null($this->currentForwardLeg))
            {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
                break;
            }
            elseif ($this->currentForwardLeg === $this->rightLeg)
            {
                $this->leftLeg->moveForward();
                $this->currentForwardLeg = $this->leftLeg;
                $this->currentPosition++;
                break;
            }
            else
            {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
                break;
            }
        }

        //Now we can get in to the vehicle
        if ($vehicle instanceof VehicleWithDoor)
        {
            $vehicle->openDoor();
        }

        //This is supposedly takes us in the vehicle
        //We already know the $this->currentForwardLeg is not null
        if ($this->currentForwardLeg === $this->rightLeg)
        {
            $this->leftLeg->moveForward();
            $this->currentForwardLeg = $this->leftLeg;
            $this->currentPosition++;
        }
        else
        {
            $this->rightLeg->moveForward();
            $this->currentForwardLeg = $this->rightLeg;
            $this->currentPosition++;
        }

        if ($vehicle instanceof VehicleWithDoor)
        {
            $vehicle->closeDoor();
        }

        $vehicle->driveTo(OFFICE_POSITION, function(Vehicle $vehicle, $position){
            $this->currentPosition = $position;

            //Now we can get in to the vehicle
            if ($vehicle instanceof VehicleWithDoor)
            {
                $vehicle->openDoor();
            }

            //Go out of the vehicle
            if ($this->currentForwardLeg === $this->rightLeg)
            {
                $this->leftLeg->moveForward();
                $this->currentForwardLeg = $this->leftLeg;
                $this->currentPosition++;
            }
            else
            {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
            }
        });
    }

    public function goToHome(Vehicle $vehicle)
    {
        while ($this->currentPosition != $this->brain->locate($vehicle))
        {
            if (is_null($this->currentForwardLeg))
            {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
                break;
            }
            elseif ($this->currentForwardLeg === $this->rightLeg)
            {
                $this->leftLeg->moveForward();
                $this->currentForwardLeg = $this->leftLeg;
                $this->currentPosition++;
                break;
            }
            else
            {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
                break;
            }
        }

        //Now we can get in to the vehicle
        if ($vehicle instanceof VehicleWithDoor)
        {
            $vehicle->openDoor();
        }

        //This is supposedly takes us in the vehicle
        //We already know the $this->currentForwardLeg is not null
        if ($this->currentForwardLeg === $this->rightLeg)
        {
            $this->leftLeg->moveForward();
            $this->currentForwardLeg = $this->leftLeg;
            $this->currentPosition++;
        }
        else
        {
            $this->rightLeg->moveForward();
            $this->currentForwardLeg = $this->rightLeg;
            $this->currentPosition++;
        }

        if ($vehicle instanceof VehicleWithDoor)
        {
            $vehicle->closeDoor();
        }

        $vehicle->driveTo(HOME_POSITION, function(Vehicle $vehicle, $position){
            $this->currentPosition = $position;

            //Now we can get in to the vehicle
            if ($vehicle instanceof VehicleWithDoor)
            {
                $vehicle->openDoor();
            }

            //Go out of the vehicle
            if ($this->currentForwardLeg === $this->rightLeg)
            {
                $this->leftLeg->moveForward();
                $this->currentForwardLeg = $this->leftLeg;
                $this->currentPosition++;
            }
            else
            {
                $this->rightLeg->moveForward();
                $this->currentForwardLeg = $this->rightLeg;
                $this->currentPosition++;
            }
        });
    }
}

interface Brain
{
    public function locate(Thing $thing);
}

interface Leg
{
    public function moveForward();
}

interface Thing
{

}

interface VehicleWithDoor extends Vehicle
{
    public function openDoor();

    public function closeDoor();
}

interface Vehicle extends Thing
{
    public function driveTo($destination, $callback);
}
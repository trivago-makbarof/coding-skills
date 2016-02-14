<?php

namespace App\Abstraction;

/**
 * Strategy Design Pattern
 *
 * Define a family of algorithms, encapsulate each one, and make them interchangeable.
 * Strategy lets the algorithm vary independently from the clients that use it
 *
 * Interface PersistStrategy
 * @package App\Abstraction
 */
interface PersistStrategy
{
    public function save();
}

/**
 * Think of that as a Value Object
 *
 * Class PersistData
 * @package App\Abstraction
 */
class PersistData
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}

/**
 * Class FilePersistenceLayer
 * @package App\Abstraction
 */
class FilePersistenceLayer implements PersistStrategy
{
    /**
     * @var PersistData
     */
    private $data;

    /**
     * @var string
     */
    private $path;

    /**
     * @param PersistData $data
     * @param $path
     */
    public function __construct(PersistData $data, $path)
    {
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Save the data
     */
    public function save()
    {
        file_put_contents($this->path, serialize($this->data->getData()));
    }
}

/**
 * Class DatabasePersistenceLayer
 * @package App\Abstraction
 */
class DatabasePersistenceLayer implements PersistStrategy
{
    /**
     * @var PersistData
     */
    private $data;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param PersistData $data
     * @param \PDO $pdo
     */
    public function __construct(PersistData $data,\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->data = $data;
    }

    /**
     * Save the data
     */
    public function save()
    {
        $this->pdo->execute(sprintf('INSERT INTO data values (%s)', serialize($this->data->getData())));
    }
}

/**
 * Class MemoryPersistenceLayer
 * @package App\Abstraction
 */
class MemoryPersistenceLayer implements PersistStrategy
{
    /**
     * @var PersistData
     */
    private $data;

    /**
     * @var string
     */
    private $memoryKey;

    /**
     * @var int
     */
    private $timeToLive;

    /**
     * @param PersistData $data
     * @param string
     * @param int
     */
    public function __construct(PersistData $data, $memoryKey, $timeToLive)
    {
        $this->memoryKey = $memoryKey;
        $this->data = $data;
        $this->timeToLive = $timeToLive;
    }

    /**
     * Save the data
     */
    public function save()
    {
        apc_store($this->memoryKey, $this->data->getData(), $this->timeToLive);
    }
}


$dataToPersist = new PersistData('hello');
/**
 * Memory persistence
 */
$memoryPersistenceLayer = new MemoryPersistenceLayer(
    $dataToPersist,
    'my_data',
    60
);
$memoryPersistenceLayer->save();

/**
 * Database persistence
 */
$databasePersistenceLayer = new DatabasePersistenceLayer(
    $dataToPersist,
    new \PDO('','','')
);
$databasePersistenceLayer->save();

/**
 * File persistence
 */
$filePersistenceLayer = new FilePersistenceLayer(
    $dataToPersist,
    '/dev/null'
);
$filePersistenceLayer->save();
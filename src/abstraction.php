<?php

class PersistLayer {
    const TYPE_FILE = 1;
    const TYPE_DATABASE = 2;
    const TYPE_IN_MEMORY = 3;

    private $type = 'file';

    private $path;

    private $pdo;

    private $data = [];

    public function save() {
        switch($this->type) {
            case self::TYPE_FILE:
                file_put_contents($this->path, serialize($this->data));
                break;
            case self::TYPE_DATABASE:
                $this->pdo->execute(sprintf('INSERT INTO data values (%s)', serialize($this->data)));
                break;
            case self::TYPE_IN_MEMORY:
                break;
            default:
                throw new \InvalidArgumentException('The given type is not valid');
        }
    }
}
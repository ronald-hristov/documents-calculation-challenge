<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Repository;


use OutOfBoundsException;
use RonaldHristov\DocumentsCalculationChallenge\Model\Model;

class InMemoryPersistence implements Persistence
{
    private $data = [];

    public function persist(object $data, $id)
    {
        $this->data[$id] = $data;
    }

    public function retrieve(string $id)
    {
        if (!isset($this->data[$id])) {
            throw new OutOfBoundsException(sprintf('No data found for ID \'%s\'', $id));
        }

        return $this->data[$id];
    }

    public function retrieveAll(): array
    {
        return $this->data;
    }

    public function has(string $id): bool
    {
        return isset($this->data[$id]);
    }

    public function delete(string $id)
    {
        if (!isset($this->data[$id])) {
            throw new OutOfBoundsException(sprintf('No data found for ID \'%s\'', $id));
        }

        unset($this->data[$id]);
    }
}
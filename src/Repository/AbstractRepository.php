<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Repository;


use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Model\Model;

abstract class AbstractRepository
{
    /**
     * @var Persistence
     */
    protected $persistence;

    public function __construct(Persistence $persistence)
    {
        $this->persistence = $persistence;
    }

    public function findById(string $id): Model
    {
        try {
            $model = $this->persistence->retrieve($id);
        } catch (\OutOfBoundsException $e) {
            $class = get_class($this);
            $classParts = explode('\\', $class);
            $modelName = end($classParts);
            throw new \OutOfBoundsException(sprintf('%s with id %d does not exist', $modelName, $id), 0, $e);
        }

        return $model;
    }

    public function findAll()
    {
        return $this->persistence->retrieveAll();
    }

    public function idExists(string $id): bool
    {
        return $this->persistence->has($id);
    }

    public function save(Model $object)
    {
        $this->persistence->persist($object, $object->getId());
    }
}
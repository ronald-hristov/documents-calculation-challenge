<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Repository;


use RonaldHristov\DocumentsCalculationChallenge\Model\Model;

interface Persistence
{
    public function persist(object $object, string $id);

    public function retrieve(string $id);

    public function retrieveAll(): array;

    public function has(string $id): bool;

    public function delete(string $id);
}
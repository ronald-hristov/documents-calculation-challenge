<?php declare(strict_types=1);


namespace Repository;


use PHPUnit\Framework\TestCase;
use RonaldHristov\DocumentsCalculationChallenge\Repository\InMemoryPersistence;

class InMemoryPersistenceTest extends TestCase
{
    /**
     * @var InMemoryPersistence
     */
    protected $objectId = 'objectId';

    /**
     * @return InMemoryPersistence
     */
    public function testCanPersist()
    {
        $obj = new \stdClass();
        $obj->property = 1;
        $inMemoryPersistence = new InMemoryPersistence();
        $inMemoryPersistence->persist($obj, $this->objectId);

        $this->assertEquals($obj, $inMemoryPersistence->retrieve($this->objectId));

        return $inMemoryPersistence;
    }

    /**
     * @depends testCanPersist
     * @param InMemoryPersistence $inMemoryPersistence
     */
    public function testHas(InMemoryPersistence $inMemoryPersistence)
    {
        $this->assertTrue($inMemoryPersistence->has($this->objectId));
    }

    /**
     * @depends testCanPersist
     * @param InMemoryPersistence $inMemoryPersistence
     */
    public function testCanRetrieveAll(InMemoryPersistence $inMemoryPersistence)
    {
        $this->assertCount(1, $inMemoryPersistence->retrieveAll());
    }

    /**
     * @depends testCanPersist
     * @param InMemoryPersistence $inMemoryPersistence
     */
    public function testCanDelete(InMemoryPersistence $inMemoryPersistence)
    {
        $inMemoryPersistence->delete($this->objectId);
        $this->assertFalse($inMemoryPersistence->has($this->objectId));
    }

    /**
     * @depends testCanPersist
     * @param InMemoryPersistence $inMemoryPersistence
     */
    public function testThrowsExceptionWhenTryingToFindNonExistentObject(InMemoryPersistence $inMemoryPersistence)
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('No data found for ID \'missingId\'');
        $inMemoryPersistence->retrieve('missingId');
    }

    /**
     * @depends testCanPersist
     * @param InMemoryPersistence $inMemoryPersistence
     */
    public function testThrowsExceptionWhenTryingToDeleteNonExistentObject(InMemoryPersistence $inMemoryPersistence)
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('No data found for ID \'missingId\'');
        $inMemoryPersistence->delete('missingId');
    }
}
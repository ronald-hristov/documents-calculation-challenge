<?php declare(strict_types=1);


namespace Repository;


use PHPUnit\Framework\TestCase;
use RonaldHristov\DocumentsCalculationChallenge\Model\AbstractDocument;
use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Repository\AbstractRepository;
use RonaldHristov\DocumentsCalculationChallenge\Repository\InMemoryPersistence;
use RonaldHristov\DocumentsCalculationChallenge\Repository\Repository;

class AbstractRepositoryTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockForAbstractClass(AbstractRepository::class, [new InMemoryPersistence()]);
    }

    public function testCanPersistObject()
    {
        $id = '4534354';
        $customer = new Customer('Test Customer', $id);
        $this->repository->save($customer);

        $this->assertEquals($customer, $this->repository->findById($id));
    }
}
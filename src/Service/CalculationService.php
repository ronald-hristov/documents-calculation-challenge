<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Service;


use RonaldHristov\DocumentsCalculationChallenge\Model\Currency;
use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Model\CustomerTotal;
use RonaldHristov\DocumentsCalculationChallenge\Model\ExchangeRate;
use RonaldHristov\DocumentsCalculationChallenge\Model\Invoice;
use RonaldHristov\DocumentsCalculationChallenge\Repository\InMemoryPersistence;
use RonaldHristov\DocumentsCalculationChallenge\Repository\Repository;

class CalculationService
{
    /**
     * @var Repository
     */
    protected $customerTotalsRepository;

    /**
     * CalculationService constructor.
     * @param Repository $customerTotalsRepository
     */
    public function __construct(Repository $customerTotalsRepository)
    {
        $this->customerTotalsRepository = $customerTotalsRepository;
    }

    /**
     * @param Invoice[] $invoices
     * @param Currency $outputCurrency
     * @return CustomerTotal[]
     * @throws \Exception
     */
    public function calculateTotals(array $invoices, Currency $outputCurrency)
    {
        foreach ($invoices as $invoice) {
            if ($this->customerTotalsRepository->idExists($invoice->getCustomer()->getId())) {
                $customerTotal = $this->customerTotalsRepository->findById($invoice->getCustomer()->getId());
            } else {
                $customerTotal = new CustomerTotal($invoice->getCustomer(), $outputCurrency);
                $this->customerTotalsRepository->save($customerTotal);
            }
            $customerTotal->addToTotal($invoice->calculateTotal($outputCurrency));
        }

        return $this->customerTotalsRepository->findAll();
    }
}
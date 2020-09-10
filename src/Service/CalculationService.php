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
     * @var Invoice[]
     */
    protected $invoices;

    /**
     * @var ExchangeRate[]
     */
    protected $exchangeRates = [];
    /**
     * @var Currency[]
     */
    protected $currencies = [];

    /**
     * @var Currency
     */
    protected $outputCurrency;

    /**
     * @var CustomerTotal[]
     */
    protected $totals = [];

    /**
     * CalculationService constructor.
     * @param Invoice[] $invoices
     * @param Currency[] $currencies
     * @param Currency $outputCurrency
     */
    public function __construct(array $invoices, array $currencies, Currency $outputCurrency)
    {
        $this->invoices = $invoices;
        $this->currencies = $currencies;
        $this->outputCurrency = $outputCurrency;
    }

    public function calculateExchangeRates()
    {

    }
    
    /**
     * @return CustomerTotal[]
     * @throws \Exception
     */
    public function calculateTotals()
    {
        $customerTotalRepository = new Repository(new InMemoryPersistence());

        foreach ($this->invoices as $invoice) {
            if ($customerTotalRepository->idExists($invoice->getCustomer()->getId())) {
                $customerTotal = $customerTotalRepository->findById($invoice->getCustomer()->getId());
            } else {
                $customerTotal = new CustomerTotal($invoice->getCustomer(), $this->outputCurrency);
                $customerTotalRepository->save($customerTotal);
            }
            $invoiceTotal = $this->calculateInvoiceTotal($invoice);
            $customerTotal->addToTotal($invoiceTotal);
        }

        return $customerTotalRepository->findAll();
    }

    public function calculateInvoiceTotal(Invoice $invoice)
    {
        $rate = $this->outputCurrency->getExchangeRate() / $invoice->getCurrency()->getExchangeRate();
        $total = $invoice->getTotal() * $rate;

        foreach ($invoice->getNotes() as $note) {
            $rate = $this->outputCurrency->getExchangeRate() / $note->getCurrency()->getExchangeRate();
            $total += $note->getSignedTotal() * $rate;
        }

        if ($total < 0) {
            throw new \Exception(sprintf('Invoice #%s has negative total', $invoice->getDocumentNumber()));
        }

        return $total;
    }
    
}
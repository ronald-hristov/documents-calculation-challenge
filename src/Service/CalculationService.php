<?php


namespace RonaldHristov\DocumentsCalculationChallenge\Service;


use RonaldHristov\DocumentsCalculationChallenge\Model\Currency;
use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Model\CustomerTotal;
use RonaldHristov\DocumentsCalculationChallenge\Model\ExchangeRate;
use RonaldHristov\DocumentsCalculationChallenge\Model\Invoice;

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

    public function calculateTotals()
    {
        foreach ($this->invoices as $invoice) {
            // TODO finish method

        }
    }

}
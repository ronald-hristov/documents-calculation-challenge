<?php


namespace RonaldHristov\DocumentsCalculationChallenge\Model;


class CustomerTotal
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var float
     */
    protected $total = 0;

    /**
     * CustomerTotal constructor.
     * @param Customer $customer
     * @param Currency $currency
     */
    public function __construct(Customer $customer, Currency $currency)
    {
        $this->customer = $customer;
        $this->currency = $currency;
    }

    public function addToTotal(float $value)
    {
        $this->total += $value;
    }

    public function __toString()
    {
        $string = sprintf('Customer %s - %s %s', $this->customer->getName(), number_format($this->total, 2), $this->currency->getName());
        return $string;
    }
}
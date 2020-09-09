<?php

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class AbstractDocument
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var string
     */
    protected $documentNumber;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $total;

    /**
     * AbstractDocument constructor.
     * @todo add customer and currency interfaces
     *
     * @param Customer $customer
     * @param string $documentNumber
     * @param Currency $currency
     * @param string $total
     */
    public function __construct(Customer $customer, string $documentNumber, Currency $currency, string $total)
    {
        $this->customer = $customer;
        $this->documentNumber = $documentNumber;
        $this->currency = $currency;
        $this->total = $total;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return AbstractDocument
     */
    public function setCustomer(Customer $customer): AbstractDocument
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     * @return AbstractDocument
     */
    public function setDocumentNumber(string $documentNumber): AbstractDocument
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return AbstractDocument
     */
    public function setCurrency(Currency $currency): AbstractDocument
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * @param string $total
     * @return AbstractDocument
     */
    public function setTotal(string $total): AbstractDocument
    {
        $this->total = $total;
        return $this;
    }

}
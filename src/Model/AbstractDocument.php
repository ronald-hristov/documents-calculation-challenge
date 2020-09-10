<?php declare(strict_types=1);

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class AbstractDocument implements Model
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
     * @var float
     */
    protected $total;

    /**
     * AbstractDocument constructor.
     * @todo add customer and currency interfaces
     *
     * @param Customer $customer
     * @param string $documentNumber
     * @param Currency $currency
     * @param float $total
     */
    public function __construct(Customer $customer, string $documentNumber, Currency $currency, float $total)
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
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return AbstractDocument
     */
    public function setTotal(float $total): AbstractDocument
    {
        $this->total = $total;
        return $this;
    }

    public function getId()
    {
       return $this->documentNumber;
    }
}
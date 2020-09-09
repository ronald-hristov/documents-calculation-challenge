<?php

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

abstract class AbstractNote extends AbstractDocument
{
    /**
     * String in case that the document starts with 0
     *
     * @var string
     */
    protected $parentDocument;

    /**
     * AbstractNote constructor.
     * @param Customer $customer
     * @param string $documentNumber
     * @param Currency $currency
     * @param string $total
     * @param string $parentDocument
     */
    public function __construct(Customer $customer, string $documentNumber, Currency $currency, string $total, string $parentDocument)
    {
        $this->parentDocument = $parentDocument;
        parent::__construct($customer, $documentNumber, $currency, $total);
    }

    abstract public function getSignedTotal();
}
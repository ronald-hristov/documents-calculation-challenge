<?php declare(strict_types=1);

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
     * @param float $total
     * @param string $parentDocument
     */
    public function __construct(Customer $customer, string $documentNumber, Currency $currency, float $total, string $parentDocument)
    {
        $this->parentDocument = $parentDocument;
        parent::__construct($customer, $documentNumber, $currency, $total);
    }

    abstract public function getSignedTotal(): float;
}
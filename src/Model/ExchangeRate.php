<?php declare(strict_types=1);

namespace RonaldHristov\DocumentsCalculationChallenge\Model;


class ExchangeRate implements Model
{
    /**
     * @var Currency
     */
    protected $mainCurrency;

    /**
     * @var Currency
     */
    protected $secondaryCurrency;

    /**
     * @var float
     */
    protected $rate;

    public function calculateRate()
    {
        $this->rate = $this->mainCurrency / $this->secondaryCurrency;
        return $this->rate;
    }

    public function getId()
    {
        return $this->mainCurrency->getId() . ':' . $this->secondaryCurrency->getId();
    }
}
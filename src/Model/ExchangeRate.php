<?php


namespace RonaldHristov\DocumentsCalculationChallenge\Model;


class ExchangeRate
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
}
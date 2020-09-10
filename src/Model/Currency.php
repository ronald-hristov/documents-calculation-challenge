<?php declare(strict_types=1);

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class Currency implements Model
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $exchangeRate;

    /**
     * Currency constructor.
     * @param string $name
     * @param float $exchangeRate
     */
    public function __construct(string $name, float $exchangeRate)
    {
        $this->name = $name;
        $this->exchangeRate = $exchangeRate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Currency
     */
    public function setName(string $name): Currency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    /**
     * @param float $exchangeRate
     * @return Currency
     */
    public function setExchangeRate(float $exchangeRate): Currency
    {
        $this->exchangeRate = $exchangeRate;
        return $this;
    }

    public function getId()
    {
        return $this->name;
    }
}
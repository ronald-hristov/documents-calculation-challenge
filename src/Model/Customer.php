<?php

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class Customer
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $vatNumber;

    /**
     * Customer constructor.
     *
     * @param string $name
     * @param string $vatNumber
     */
    public function __construct(string $name, string $vatNumber)
    {
        $this->name = $name;
        $this->vatNumber = $vatNumber;
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
     * @return Customer
     */
    public function setName(string $name): Customer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     * @return Customer
     */
    public function setVatNumber(string $vatNumber): Customer
    {
        $this->vatNumber = $vatNumber;
        return $this;
    }
}
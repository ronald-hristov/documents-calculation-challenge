<?php declare(strict_types=1);

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class Invoice extends AbstractDocument
{
    /**
     * @var AbstractNote[]
     */
    protected $notes = [];

    /**
     * @return AbstractNote[]
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * @param AbstractNote[] $notes
     * @return Invoice
     */
    public function setNotes(array $notes): Invoice
    {
        $this->notes = $notes;
        return $this;
    }

    public function addNote(AbstractNote $note)
    {
        $this->notes[] = $note;
    }

    /**
     * @param Currency $outputCurrency
     * @return float
     * @throws \Exception
     */
    public function calculateTotal(Currency $outputCurrency): float
    {
        $rate = $this->getCurrency()->getExchangeRate() / $outputCurrency->getExchangeRate();
        $total = $this->getTotal() * $rate;

        foreach ($this->getNotes() as $note) {
            $rate = $note->getCurrency()->getExchangeRate() / $outputCurrency->getExchangeRate();
            $total += $note->getSignedTotal() * $rate;
        }

        if ($total < 0) {
            throw new \RuntimeException(sprintf('Invoice #%s has negative total', $this->getDocumentNumber()));
        }

        return $total;
    }
}
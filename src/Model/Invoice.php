<?php

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
     * @throws \Exception
     */
    public function calculateTotal(): float
    {
        $total = $this->total;
        foreach ($this->notes as $note) {
            $total += $note->getSignedTotal();
        }

        if ($total < 0) {
            $message = sprintf('Invoice #%s has total value of %s', $this->documentNumber, $total);
            throw new \Exception($message);
        }

        return $total;
    }
}
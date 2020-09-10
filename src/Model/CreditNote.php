<?php declare(strict_types=1);

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class CreditNote extends AbstractNote
{
    public function getSignedTotal(): float
    {
        return $this->total * (-1);
    }
}
<?php declare(strict_types=1);

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class DebitNote extends AbstractNote
{

    /**
     * @return float
     */
    public function getSignedTotal(): float
    {
        return $this->total;
    }
}
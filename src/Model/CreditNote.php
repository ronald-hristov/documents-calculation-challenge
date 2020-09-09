<?php

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class CreditNote extends AbstractNote
{
    public function getSignedTotal()
    {
        return - $this->total;
    }
}
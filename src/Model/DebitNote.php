<?php

namespace RonaldHristov\DocumentsCalculationChallenge\Model;

class DebitNote extends AbstractNote
{

    /**
     * @return string
     */
    public function getSignedTotal()
    {
        return $this->total;
    }
}
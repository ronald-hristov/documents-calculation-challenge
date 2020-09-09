<?php


namespace RonaldHristov\DocumentsCalculationChallenge\Console;


class Import implements CommandInterface
{

    protected const INVOICE = 1;
    protected const CREDIT_NOTE = 2;
    protected const DEBIT_NOTE = 3;

    protected const INVOICE_TYPES = [
        self::INVOICE,
        self::CREDIT_NOTE,
        self::DEBIT_NOTE,
    ];

    public function run(array $params)
    {
        print_r($params);
        // Read csv

        // Add rows to invoices and notes 2 separate arrays; Create customers

        // Add notes to respective invoices

        // Create currency objects

        // Output currency

        // Initiate calculation service

        // Calculate and output result
    }
}
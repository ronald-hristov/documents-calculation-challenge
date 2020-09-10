<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Console;


use RonaldHristov\DocumentsCalculationChallenge\Model\CreditNote;
use RonaldHristov\DocumentsCalculationChallenge\Model\Currency;
use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Model\DebitNote;
use RonaldHristov\DocumentsCalculationChallenge\Model\Invoice;
use RonaldHristov\DocumentsCalculationChallenge\Repository\InMemoryPersistence;
use RonaldHristov\DocumentsCalculationChallenge\Repository\Repository;
use RonaldHristov\DocumentsCalculationChallenge\Service\CalculationService;
use RonaldHristov\DocumentsCalculationChallenge\Service\ImportCsvToArray;

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

    /**
     * @var ImportCsvToArray
     */
    protected $importCsvToArray;

    public function run(array $params)
    {
        $filePath = $params[0];
        $currenciesArr = $params[1];
        $outputCurrencyName = $params[2];
        $vat = $params['vat'] ?? null;

        // Create currency objects
        $currencyRepository = new Repository(new InMemoryPersistence());

        foreach ($currenciesArr as $currencyName => $rate) {
            $currency = new Currency($currencyName, (float) $rate);
            $currencyRepository->save($currency);
        }

        // Output currency
        /** @var Currency $outputCurrency */
        $outputCurrency = $currencyRepository->findById($outputCurrencyName);

        $customerRepository = new Repository(new InMemoryPersistence());
        $documentRepository = new Repository(new InMemoryPersistence());

        // Process Row
        $importCsvToArray = new ImportCsvToArray($filePath);
        foreach ($importCsvToArray->run() as $row) {
            if (!empty($vat) && $vat != $row['vatNumber']) {
                continue;
            }

            $this->processRow($row, $customerRepository, $currencyRepository, $documentRepository);
        }

        $invoices = [];
        $documents = $documentRepository->findAll();
        foreach ($documents as $document) {
            if (!$document instanceof Invoice) {
                continue;
            }

            $invoices[] = $document;
        }



        // Initiate calculation service
        $calculationService = new CalculationService($invoices, $currencyRepository->findAll(), $outputCurrency);
        // Calculate and output result
        $totals = $calculationService->calculateTotals();

        foreach ($totals as $total) {
            echo $total . "\n";
        }
    }

    /**
     * @param array $row
     * @param Repository $customerRepository
     * @param Repository $currencyRepository
     * @param Repository $documentRepository
     * @throws \Exception
     */
    public function processRow(array $row, Repository $customerRepository, Repository $currencyRepository, Repository $documentRepository)
    {
       $customerVat = $row['vatNumber'];
       if ($customerRepository->idExists($customerVat)) {
           $customer = $customerRepository->findById($customerVat);
       } else {
           $customer = Customer::fromArray($row);
       }

       /** @var Currency $currency */
       $currency = $currencyRepository->findById($row['currency']);

       switch ($row['type']) {
           case self::INVOICE:
               $document = new Invoice($customer, $row['documentNumber'], $currency, (float) $row['total']);
               break;
           case self::CREDIT_NOTE:
               /** @var Invoice $invoice */
               $invoice = $documentRepository->findById($row['parentDocument']);
               $document = new CreditNote($customer, $row['documentNumber'], $currency, (float) $row['total'], $row['parentDocument']);
               $invoice->addNote($document);
               break;
           case self::DEBIT_NOTE:
               /** @var Invoice $invoice */
               $invoice = $documentRepository->findById($row['parentDocument']);
               $document = new DebitNote($customer, $row['documentNumber'], $currency, (float) $row['total'], $row['parentDocument']);
               $invoice->addNote($document);
               break;
           default:
               throw new \Exception('Unrecognized document type: ' . $row['type']);
       }

        $documentRepository->save($document);
    }
}
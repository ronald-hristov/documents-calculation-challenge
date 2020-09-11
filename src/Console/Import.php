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
use RonaldHristov\DocumentsCalculationChallenge\Service\Import\CsvToArray;
use RonaldHristov\DocumentsCalculationChallenge\Service\Import\FileToArray;

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
     * @var FileToArray
     */
    protected $fileToToArray;

    /**
     * @var Repository
     */
    protected $customerRepository;

    /**
     * @var Repository
     */
    protected $documentRepository;

    /**
     * @var Repository
     */
    protected $currencyRepository;

    /**
     * @var CalculationService
     */
    protected $calculationService;

    /**
     * Import constructor.
     * @param FileToArray $fileToToArray
     * @param Repository $customerRepository
     * @param Repository $documentRepository
     * @param Repository $currencyRepository
     * @param CalculationService $calculationService
     */
    public function __construct(FileToArray $fileToToArray, Repository $customerRepository, Repository $documentRepository, Repository $currencyRepository, CalculationService $calculationService)
    {
        $this->fileToToArray = $fileToToArray;
        $this->customerRepository = $customerRepository;
        $this->documentRepository = $documentRepository;
        $this->currencyRepository = $currencyRepository;
        $this->calculationService = $calculationService;
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function run(array $params): array
    {
        $filePath = $params[0];
        $currenciesArr = $params[1];
        $outputCurrencyName = $params[2];
        $vat = $params['vat'] ?? null;

        // Create currency objects
        foreach ($currenciesArr as $currencyName => $rate) {
            $currency = new Currency($currencyName, (float)$rate);
            $this->currencyRepository->save($currency);
        }

        // Output currency
        /** @var Currency $outputCurrency */
        $outputCurrency = $this->currencyRepository->findById($outputCurrencyName);

        // Process Row
        $importCsvToArray = new CsvToArray();
        foreach ($importCsvToArray->run($filePath) as $row) {
            if (!empty($vat) && $vat != $row['vatNumber']) {
                continue;
            }

            $this->processRow($row);
        }

        $invoices = [];
        $documents = $this->documentRepository->findAll();
        foreach ($documents as $document) {
            if (!$document instanceof Invoice) {
                continue;
            }

            $invoices[] = $document;
        }

        // Calculate and output result
        $totals = $this->calculationService->calculateTotals($invoices, $outputCurrency);

        return $totals;
    }

    /**
     * @param array $row
     * @throws \Exception
     */
    protected function processRow(array $row)
    {
        $customerVat = $row['vatNumber'];
        if ($this->customerRepository->idExists($customerVat)) {
            $customer = $this->customerRepository->findById($customerVat);
        } else {
            $customer = Customer::fromArray($row);
        }

        /** @var Currency $currency */
        $currency = $this->currencyRepository->findById($row['currency']);

        switch ($row['type']) {
            case self::INVOICE:
                $document = new Invoice($customer, $row['documentNumber'], $currency, (float)$row['total']);
                break;
            case self::CREDIT_NOTE:
                /** @var Invoice $invoice */
                $invoice = $this->documentRepository->findById($row['parentDocument']);
                $document = new CreditNote($customer, $row['documentNumber'], $currency, (float)$row['total'], $row['parentDocument']);
                $invoice->addNote($document);
                break;
            case self::DEBIT_NOTE:
                /** @var Invoice $invoice */
                $invoice = $this->documentRepository->findById($row['parentDocument']);
                $document = new DebitNote($customer, $row['documentNumber'], $currency, (float)$row['total'], $row['parentDocument']);
                $invoice->addNote($document);
                break;
            default:
                throw new \Exception('Unrecognized document type: ' . $row['type']);
        }

        $this->documentRepository->save($document);
    }
}
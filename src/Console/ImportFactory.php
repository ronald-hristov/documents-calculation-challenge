<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Console;


use RonaldHristov\DocumentsCalculationChallenge\Repository\InMemoryPersistence;
use RonaldHristov\DocumentsCalculationChallenge\Repository\Repository;
use RonaldHristov\DocumentsCalculationChallenge\Service\CalculationService;
use RonaldHristov\DocumentsCalculationChallenge\Service\Import\CsvToArray;

class ImportFactory implements FactoryInterface
{
    /**
     * @return Import
     */
    public function create()
    {
        $importCsvToArray = new CsvToArray();
        $customerRepository = new Repository(new InMemoryPersistence());
        $documentRepository = new Repository(new InMemoryPersistence());
        $currencyRepository = new Repository(new InMemoryPersistence());
        $customerTotalsRepository = new Repository(new InMemoryPersistence());
        $calculationService = new CalculationService($customerTotalsRepository);

        return new Import($importCsvToArray, $customerRepository, $documentRepository, $currencyRepository, $calculationService);
    }
}
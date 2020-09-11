<?php declare(strict_types=1);


namespace Service;


use PHPUnit\Framework\TestCase;
use RonaldHristov\DocumentsCalculationChallenge\Model\CreditNote;
use RonaldHristov\DocumentsCalculationChallenge\Model\Currency;
use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Model\CustomerTotal;
use RonaldHristov\DocumentsCalculationChallenge\Model\DebitNote;
use RonaldHristov\DocumentsCalculationChallenge\Model\Invoice;
use RonaldHristov\DocumentsCalculationChallenge\Repository\InMemoryPersistence;
use RonaldHristov\DocumentsCalculationChallenge\Repository\Repository;
use RonaldHristov\DocumentsCalculationChallenge\Service\CalculationService;

/**
 * Class CalculationServiceTest
 * @todo add tests fpr multiple invoices for one customer
 * @package Service
 *
 */
class CalculationServiceTest extends TestCase
{
    /**
     * @var CalculationService
     */
    protected $calculationService;

    public function setUp(): void
    {
        $this->calculationService = new CalculationService(new Repository(new InMemoryPersistence()));
    }

    public function testCalculationTotalWithOneInvoiceAndDifferentOutputCurrency()
    {
        $customerId = '12345';
        $customer = $this->createStub(Customer::class);
        $customer->method('getId')
            ->willReturn($customerId);
        $currency = $this->createStub(Currency::class);
        $currency->method('getExchangeRate')
            ->willReturn(1.0);

        $outputCurrency = $this->createStub(Currency::class);
        $outputCurrency->method('getExchangeRate')
            ->willReturn(1.2);

        $invoice = new Invoice($customer, '03705', $currency, 100.00);

        $actualResult = $this->calculationService->calculateTotals([$invoice], $outputCurrency);
        $this->assertEquals(83.33, number_format($actualResult[$customerId]->getTotal(), 2));
    }

    public function testCalculationWithCreditNoteAndDifferentOutputCurrency()
    {
        $customerId = '12345';
        $customer = $this->createStub(Customer::class);
        $customer->method('getId')
            ->willReturn($customerId);
        $currency = $this->createStub(Currency::class);
        $currency->method('getExchangeRate')
            ->willReturn(1.0);

        $outputCurrency = $this->createStub(Currency::class);
        $outputCurrency->method('getExchangeRate')
            ->willReturn(1.2);

        $creditNote = new CreditNote($customer, '03706', $currency, 50, '03705');

        $invoice = new Invoice($customer, '03705', $currency, 100.00);
        $invoice->addNote($creditNote);

        $actualResult = $this->calculationService->calculateTotals([$invoice], $outputCurrency);
        // TODO change number format it rounds
        $this->assertEquals('41.67', number_format($actualResult[$customerId]->getTotal(), 2));
    }

    public function testCalculationWithDebitNoteAndDifferentOutputCurrency()
    {
        $customerId = '12345';
        $customer = $this->createStub(Customer::class);
        $customer->method('getId')
            ->willReturn($customerId);
        $currency = $this->createStub(Currency::class);
        $currency->method('getExchangeRate')
            ->willReturn(1.0);

        $outputCurrency = $this->createStub(Currency::class);
        $outputCurrency->method('getExchangeRate')
            ->willReturn(1.2);

        $creditNote = new DebitNote($customer, '03706', $currency, 50, '03705');

        $invoice = new Invoice($customer, '03705', $currency, 100.00);
        $invoice->addNote($creditNote);

        $actualResult = $this->calculationService->calculateTotals([$invoice], $outputCurrency);
        $this->assertEquals(125.00, number_format($actualResult[$customerId]->getTotal(), 2));
    }

}
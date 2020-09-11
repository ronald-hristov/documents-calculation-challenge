<?php declare(strict_types=1);


namespace Model;


use PHPUnit\Framework\TestCase;
use RonaldHristov\DocumentsCalculationChallenge\Model\CreditNote;
use RonaldHristov\DocumentsCalculationChallenge\Model\Currency;
use RonaldHristov\DocumentsCalculationChallenge\Model\Customer;
use RonaldHristov\DocumentsCalculationChallenge\Model\Invoice;

class InvoiceTest extends TestCase
{
    /**
     * @var Invoice
     */
    protected $invoice;

    public function setUp(): void
    {
        $customerId = '12345';
        $customer = $this->createStub(Customer::class);
        $customer->method('getId')
            ->willReturn($customerId);
        $currency = $this->createStub(Currency::class);
        $currency->method('getExchangeRate')
            ->willReturn(1.0);

        $this->invoice = new Invoice($customer, '03705', $currency, 100);
    }

    public function testTotalCalculation()
    {

        $outputCurrency = $this->createStub(Currency::class);
        $outputCurrency->method('getExchangeRate')
            ->willReturn(1.2);

        $noteCurrency = $this->createStub(Currency::class);
        $noteCurrency->method('getExchangeRate')
            ->willReturn(0.8);

        $creditNote = $this->createStub(CreditNote::class);
        $creditNote->method('getCurrency')->willReturn($noteCurrency);
        $creditNote->method('getSignedTotal')->willReturn(- 20.00);
        $this->invoice->addNote($creditNote);


        $this->assertEquals(70.00, round($this->invoice->calculateTotal($outputCurrency), 2));
    }
}
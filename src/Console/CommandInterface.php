<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Console;


interface CommandInterface
{
    public function run(array $params);
}
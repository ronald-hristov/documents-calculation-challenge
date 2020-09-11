<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Service\Import;


interface FileToArray
{
    public function run(string $filePath): \Iterator;
}
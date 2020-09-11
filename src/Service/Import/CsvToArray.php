<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Service\Import;


class CsvToArray implements FileToArray
{
    public function run(string $filePath): \Iterator
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException('File ' . $filePath . ' does not exist');
        }

        if (($handle = fopen($filePath, "r")) !== false) {
            $headers = $this->wordsToCameCase(fgetcsv($handle, 1000, ","));

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                yield array_combine($headers, $data);
            }
            fclose($handle);
        }
    }

    public function wordsToCameCase(array $data): array
    {
        $result = [];
        foreach ($data as $words) {
            $result[] = lcfirst(str_replace(' ', '', trim(ucwords($words))));
        }

        return $result;
    }

}
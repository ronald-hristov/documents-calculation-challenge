<?php declare(strict_types=1);


namespace RonaldHristov\DocumentsCalculationChallenge\Service;


class ImportCsvToArray
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * ImportCsvToArray constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function run()
    {
        if (($handle = fopen($this->filePath, "r")) !== false) {
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
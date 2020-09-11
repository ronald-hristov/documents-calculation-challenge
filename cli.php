<?php

require_once __DIR__ . '/vendor/autoload.php';

$params = [];
for ($i = 2; $i < count($argv); ++$i) {
    $param = $argv[$i];
    if (strpos($param, '--') === 0) {
        $param = substr($param, 2);
    }

    if (strpos($param, '=') !== false) {
        [$key, $value] = explode("=", $param, 2);
    } else {
        $value = $argv[$i];
    }

    if (strpos($value, ',') !== false) {
        $values = explode(',', $value);
        $arrayValues = [];
        foreach ($values as $value) {
            if (strpos($value,':') !== false) {
                [$innerParamKey, $innerParamValue] = explode(":", $value, 2);
                $arrayValues[$innerParamKey] = $innerParamValue;
            } else {
                $arrayValues[] = $innerParamValue;
            }
        }
        $value = $arrayValues;
    }

    if (isset($key)) {
        $params[$key] = $value;
    } else {
        $params[] = $value;
    }

    unset($key);
}

$className = 'RonaldHristov\\DocumentsCalculationChallenge\\Console\\' . ucfirst($argv[1]);
if (!class_exists($className)) {
    throw new Exception('Class ' . $className . ' does not exist');
}

/** @var \RonaldHristov\DocumentsCalculationChallenge\Console\CommandInterface $command */

$factoryName = 'RonaldHristov\\DocumentsCalculationChallenge\\Console\\' . ucfirst($argv[1]) . 'Factory';
if (class_exists($factoryName)) {
    /** @var \RonaldHristov\DocumentsCalculationChallenge\Console\FactoryInterface $factory */
    $factory = new $factoryName();
    $command = $factory->create();
} else {
    $command = new $className();
}

try {
    $result = $command->run($params);
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}
echo implode("\n", $result) . "\n";
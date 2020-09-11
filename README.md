# documents-calculation-challenge
Invoicing command challange

### Usage
```
composer install

php cli.php path/to_file.csv currency1:exchange_rate1,currency1:exchange_rate2 output_currebt
```

### Exmples usage
```
php cli.php import data.csv EUR:1,USD:0.987,GBP:0.878 GBP --vat=12345
```

data.csv is the path to the csv file

EUR:1,USD:0.987,GBP:0.878 are the supported currencies and their respective exchange rates

GBP is the output currency

--vat=12345 is an optional element for filtering by the VAT Number of a specific customer
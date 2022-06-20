## Requirements:

Two API endpoints needed for retrieving Company List and Travel List:

- Company List: https://5f27781bf5d27e001612e057.mockapi.io/webprovise/companies
- Travel List: https://5f27781bf5d27e001612e057.mockapi.io/webprovise/travels

Process data from the two endpoints to have a nested array of companies with travel cost
Travel cost of a particular company is the total travel price of employees in that company and its child companies
Output of nested array should look like this:

```
[
    'id' => 'uuid-16',
    'name' => 'Webprovise Corp',
    'cost' => 9696,
    'children' => [
        'id' => 'uuid-18',
        'name' => 'Walter, Schmidt and Osinski',
        'cost' => 6969,
        'children' => []
    ]
];
```
- **Complete your code by using this template**:
```
<?php

class Travel
{
// Enter your code here
}

class Company
{
// Enter your code here
}

class TestScript
{
    public function execute()
    {
        $start = microtime(true);
        // Enter your code here
        // echo json_encode($result);
        echo 'Total time: '.  (microtime(true) - $start);
    }
}

(new TestScript())->execute();
```

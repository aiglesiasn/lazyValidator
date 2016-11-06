# lazyValidator
lazyValidator will start the next group of rules if the current is clear.

[![Code Climate](https://codeclimate.com/github/trzczy/lazyValidator/badges/gpa.svg)](https://codeclimate.com/github/trzczy/lazyValidator)
[![Test Coverage](https://codeclimate.com/github/trzczy/lazyValidator/badges/coverage.svg)](https://codeclimate.com/github/trzczy/lazyValidator/coverage)
[![Issue Count](https://codeclimate.com/github/trzczy/lazyValidator/badges/issue_count.svg)](https://codeclimate.com/github/trzczy/lazyValidator)
## Installation
`composer require master/lazy-validator`

## Example usage
```php
    require_once __DIR__ . '/vendor/autoload.php';
    use Trzczy\Helpers\Rules;
    
    $jsonData = '[
            {
                "method":"Zbigniew",
                "input":"Herbert",
                "arg1":24,
                "arg2":"abc"
            },
            {
                "method":"Frank",
                "input":"Herbert",
                "former":[
                    {"arg2":"abc"}
                ]
            },
            {
                "method":"Edith",
                "input":"Stein",
                "former":[
                    {"method":"Frank"},
                    {"arg2":"abc"}
                ]
            },
            {
                "method":"Ernest",
                "input":"Hemingway",
                "former":[
                    {"input":"Herbert"},
                    {"method":"Edith"}
                ]
    
            }
        ]';
    $rules = new Rules();
    print_r($rules->order($jsonData));
```
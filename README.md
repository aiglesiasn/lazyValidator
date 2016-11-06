# lazyValidator
lazyValidator will start the next group of rules if the current is clear.

[![Code Climate](https://codeclimate.com/github/trzczy/lazyValidator/badges/gpa.svg)](https://codeclimate.com/github/trzczy/lazyValidator)
[![Test Coverage](https://codeclimate.com/github/trzczy/lazyValidator/badges/coverage.svg)](https://codeclimate.com/github/trzczy/lazyValidator/coverage)
[![Issue Count](https://codeclimate.com/github/trzczy/lazyValidator/badges/issue_count.svg)](https://codeclimate.com/github/trzczy/lazyValidator)
## Installation
`composer require master/lazy-validator`

## Example usage
```php
$validationMethodsObject = new ValidationMethods1($userDaoImpl);
$rulesGrouped = [
    //methods group
    json_decode('
        [
            {
                "method": "length",
                "input": "username",
                "min": 2,
                "max": 3,
                "message": "Username must be between 2 and 3 characters long."
            },
            {
                "method": "length",
                "input": "username",
                "min": 2,
                "max": 8,
                "message": "Username must be between 2 and 8 characters long."
            },
            {
                "method": "regex",
                "input": "username",
                "pattern": "^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$",
                "message": "Username may contain letters, numbers, spaces, hyphens and underscores."
            },
            {
                "method": "email",
                "input": "email",
                "message": "Email address format not proper."
            },
            {
                "method": "length",
                "input": "password",
                "min": 3,
                "max": 4096,
                "message": "Password must be longer than 2 characters."
            },
            {
                "method": "confirm",
                "input": "confirm",
                "message": "Passwords must be the same."
            }
        ]
    ', true),
    //methods group
    json_decode
    ('
        [
            {
                "method": "unique",
                "input": "email",
                "table": "email",
                "message": "Email address must be unique."
            }
        ]
    ', true),
    //methods group
    json_decode
    ('
        [
            {
                "method": "unique",
                "input": "username",
                "table": "username",
                "message": "Username must be unique."
            }
        ]
    ', true)
];
$validator = new LazyValidator($validationMethodsObject);
$result = $validator->validate(
    $_POST,
    $rulesGrouped
);
```
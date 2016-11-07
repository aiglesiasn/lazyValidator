<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload
use PHPUnit\Framework\TestCase;
use Trzczy\Helpers\LazyValidator;


class LazyValidatorTest extends TestCase
{
    private $validator;
    private $userDaoImpl;

    public function initialParametersAndResult()
    {
        return [
            //test data 1
            //post data 1
            //methods 1
            [
                /*post data*/
                '{
                    "username": "",
                    "email": "abc@domain.ko",
                    "password": "adam",
                    "confirm": ""
                }',

                /*groups of validation methods and their parameters*/
                [
                    //methods group
                    json_decode
                    ('[
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
                    ('[
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
                    ('[
                            {
                                "method": "unique",
                                "input": "username",
                                "table": "username",
                                "message": "Username must be unique."
                            }
                        ]
                    ', true)
                ],

                /*validation methods class name*/
                'ValidationMethods1',

                /*result*/
                '[
                    {
                        "failedInput": "username",
                        "messages": [
                            "Username must be between 2 and 3 characters long.",
                            "Username must be between 2 and 8 characters long.",
                            "Username may contain letters, numbers, spaces, hyphens and underscores."
                        ]
                    },
                    {
                        "failedInput": "confirm",
                        "messages": [
                            "Passwords must be the same."
                        ]
                    }
                ]'
            ],

            //test data 2
            //post data 2
            //methods 1
            [
                /*post data*/
                '{
                    "username": "Ion",
                    "email": "xflavio@abc.abc",
                    "password": "adam12",
                    "confirm": "adam12"
                }',

                /*groups of validation methods and their parameters*/
                [
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
                ],

                /*validation methods class name*/
                'ValidationMethods1',

                /*result*/
                '[
                    {
                        "failedInput": "username",
                        "messages": [
                            "Username must be unique."
                        ]
                    }
                 ]'
            ],

            //test data 3
            //post data 1
            //methods 2
            [
                /*post data*/
                '{
                    "username": "",
                    "email": "abc@domain.ko",
                    "password": "adam",
                    "confirm": ""
                }',

                /*groups of validation methods and their parameters*/
                [
                    //methods group
                    json_decode
                    ('[
                            {
                                "method": "length",
                                "input": "username",
                                "min": 3,
                                "max": 8,
                                "message": "Username must be between 3 and 8 characters long."
                            }
                        ]
                    ', true),
                    //methods group
                    json_decode
                    ('[
                            {
                                "method": "length",
                                "input": "email",
                                "min": 6,
                                "max": 20,
                                "message": "Email must be between 6 and 20 characters long."
                            },
                            {
                                "method": "length",
                                "input": "password",
                                "min": 5,
                                "max": 18,
                                "message": "Password must be between 5 and 18 characters long."
                            }
                        ]
                    ', true)
                ],

                /*validation methods class name*/
                'ValidationMethods2',

                /*result*/
                '[
                    {
                        "failedInput": "username",
                        "messages": [
                            "Username must be between 3 and 8 characters long."
                        ]
                    }
                ]'
            ],

            //test data 4
            //post data 2
            //methods 2
            [
                /*post data*/
                '{
                    "username": "Adam",
                    "email": "abc@domain.ko",
                    "password": "0(2345$_8901x3456789",
                    "confirm": "abc"
                }',

                /*groups of validation methods and their parameters*/
                [
                    //methods group
                    json_decode
                    ('[
                            {
                                "method": "length",
                                "input": "username",
                                "min": 3,
                                "max": 8,
                                "message": "Username must be between 3 and 8 characters long."
                            }
                        ]
                    ', true),
                    //methods group
                    json_decode
                    ('[
                            {
                                "method": "length",
                                "input": "email",
                                "min": 6,
                                "max": 20,
                                "message": "Email must be between 6 and 20 characters long."
                            },
                            {
                                "method": "length",
                                "input": "password",
                                "min": 5,
                                "max": 18,
                                "message": "Password must be between 5 and 18 characters long."
                            }
                        ]
                    ', true)
                ],

                /*validation methods class name*/
                'ValidationMethods2',

                /*result*/
                '[
                    {
                        "failedInput": "password",
                        "messages": [
                            "Password must be between 5 and 18 characters long."
                        ]
                    }
                ]'
            ]
        ];
    }

    /**
     * @dataProvider initialParametersAndResult
     * @param $postData
     * @param $rulesGrouped
     * @param $validationMethodsClassName
     * @param $expected
     */
    public function testIfValidatorReportIsAsExcepted($postData, $rulesGrouped, $validationMethodsClassName, $expected)
    {
        $fullValidationMethodsClassName = 'Trzczy\\Helpers\\' . $validationMethodsClassName;
        $validationMethodsObject = new $fullValidationMethodsClassName($this->userDaoImpl);
        var_dump($validationMethodsObject);
        $this->validator = new LazyValidator($validationMethodsObject);
        $result = $this->validator->validate(
            json_decode($postData, true),
            $rulesGrouped
        );
        unset($this->validator);
        $this->assertEquals($result, json_decode($expected, true));
    }

    public function setUp()
    {
        $this->userDaoImpl = new \Trzczy\Helpers\UserDaoImpl();
    }
}
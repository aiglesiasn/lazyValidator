<?php
/**
 * This is a file-level DocBlock
 *
 * @package LazyValidator
 * @license    https://opensource.org/licenses/MIT
 * @author     trzczy <trzczy@gmail.com>
 */

namespace Trzczy\Helpers;

/**
 * The only class of the LazyValidator package
 *
 * The class is to prepare the report of validation messages
 *
 * @package    LazyValidator
 * @author     trzczy <trzczy@gmail.com>
 */
class LazyValidator
{
    private $methods;

    public function __construct($methods)
    {
        $this->methods = $methods;
    }

    /**
     * Prepares and returns the report of validation messages
     *
     * @param array $postData
     * @param array $rulesGrouped
     * @return array
     * @internal param $methods
     */
    public function validate(array $postData, array $rulesGrouped)
    {
        /** @var array $report */
        $report = [];
        /** @var bool $passed */
        $passed = true;

        while ($passed and $rulesGrouped) {
            $report = [];
            /** @var array $ruleGroup */
            $ruleGroup = array_shift($rulesGrouped);
            /** @var string $input */
            /** @var string $value */
            foreach ($postData as $input => $value) {
                /** @var array $particularInputReport */
                $particularInputReport = [];
                /** @var array $ruleGroup */
                /** @var array $rule */
                foreach ($ruleGroup as $rule) {
                    if ($input === $rule['input']) {
                        /** @var string $password */
                        $password = ($rule['method'] === 'confirm') ? $postData['password'] : null;
                        $result = call_user_func([$this->methods, $rule['method']], $value, $rule, $password);
                        if (!$result) {
                            if ($passed) {
                                $passed = false;
                            }
                            if (empty($particularInputReport['failedInput'])) {
                                $particularInputReport['failedInput'] = $input;
                            }
                            $particularInputReport['messages'][] = $rule['message'];
                        }
                    } //if
                }
                if ($particularInputReport) {
                    $report[] = $particularInputReport;
                }
            }
        }
        return $report;
    }
}

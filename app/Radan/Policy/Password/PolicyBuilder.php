<?php 

namespace App\Radan\Policy\Password;

use Closure;
use App\Radan\Policy\Password\Policy;
use App\Radan\Policy\Password\Rules\CaseRule;
use App\Radan\Policy\Password\Rules\ContainRule;
use App\Radan\Policy\Password\Rules\DigitRule;
use App\Radan\Policy\Password\Rules\LengthRule;
use App\Radan\Policy\Password\Rules\MinPassingRulesRule;
use App\Radan\Policy\Password\Rules\SpecialCharacterRule;

/**
 * Class PolicyBuilder
 *
 * @package PasswordPolicy
 */
class PolicyBuilder
{
    /**
     * Policy instance
     *
     * @var Policy
     */
    private $policy;


    /**
     * PolicyBuilder constructor.
     *
     * @param Policy $policy
     */
    public function __construct(Policy $policy=null)
    {
        $this->policy = is_null($policy) ? new Policy(): $policy;
    }

    /**
     * Add a min length rule
     *
     * @param $length int
     *
     * @return $this
     */
    public function minLength($length)
    {
        $this->policy->addRule(
            (new LengthRule)->min($length)
        );

        return $this;
    }

    /**
     * Add a max length rule
     *
     * @param $length int
     *
     * @return $this
     */
    public function maxLength($length)
    {
        $this->policy->addRule(
            (new LengthRule)->max($length)
        );

        return $this;
    }

    /**
     * Add an upper case rule
     *
     * @param int $min min number of upper case characters
     *
     * @return $this
     */
    public function upperCase($min = 1)
    {
        $this->policy->addRule(
            (new CaseRule)->upper($min)
        );

        return $this;
    }

    /**
     * Add an lower case rule
     *
     * @param int $min min number of lower case characters
     *
     * @return $this
     */
    public function lowerCase($min = 1)
    {
        $this->policy->addRule(
            (new CaseRule)->lower($min)
        );

        return $this;
    }

    /**
     * Add a digit rule
     *
     * @param int $min min number of digits
     *
     * @return $this
     */
    public function digits($min = 1)
    {
        $this->policy->addRule(
            (new DigitRule)->min($min)
        );

        return $this;
    }

    /**
     * Add a does not complain rule based on the given phrases
     *
     * @param $phrases string|array
     *
     * @return $this
     */
    public function doesNotContain($phrases)
    {
        $phrases = is_array($phrases) ? $phrases : func_get_args();

        $this->policy->addRule(
            (new ContainRule)->phrase($phrases)->doesnt()
        );

        return $this;
    }

    /**
     * Add a contains rule based on the given phrases
     *
     * @param $phrases string|array
     *
     * @return $this
     */
    public function contains($phrases)
    {
        $phrases = is_array($phrases) ? $phrases : func_get_args();

        $this->policy->addRule(
            (new ContainRule)->phrase($phrases)
        );

        return $this;
    }

    /**
     * Add a nested set of minimum passing rules
     *
     * @param         $passesRequired
     * @param Closure $ruleSet
     *
     * @return $this
     */
    public function minPassingRules($passesRequired, Closure $ruleSet)
    {
        $this->policy->addRule(
            (new MinPassingRulesRule($passesRequired))->using($ruleSet)
        );

        return $this;
    }

    /**
     * Special characters
     * 
     * @param int $min
     * @return $this
     */
    public function specialCharacters($min = 1)
    {
        $this->policy->addRule(
            (new SpecialCharacterRule)->min($min)
        );

        return $this;
    }


    /**
     * Get the policy instance
     *
     * @return Policy
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * Create Policy Builder by validaton rules
     *
     * @param Array $rules Contain password validation rules
     * 
     * @return Policy
     */
    public function createPolicy($rules)
    {        
        if (is_array($rules)) {
            foreach ($rules as $key => $value) {
                switch ($key) {
                    case 'min_length':
                        $this->minLength($value); break;
                    case 'max_length':
                        $this->maxLength($value); break;
                    case 'upper_case':
                        $this->upperCase($value); break;
                    case 'lower_case':
                        $this->lowerCase($value); break;
                    case 'digits':
                        $this->digits($value); break;
                    case 'special_chars':
                        $this->specialCharacters($value); break;
                    case 'does_not_contain':
                        $this->doesNotContain($value); break;
                    default:                    
                        break;
                }              
            }
        }
        return $this->policy;;
    }
}

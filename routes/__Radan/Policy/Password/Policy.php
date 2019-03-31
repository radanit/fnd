<?php 

namespace App\Radan\Policy\Password;

class Policy
{
    private $rules = [];

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return Rule[]
     */
    public function rules()
    {
        return $this->rules;
    }
}

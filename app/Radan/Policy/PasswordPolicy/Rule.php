<?php 

namespace App\Radan\Policy\PasswordPolicy;

interface Rule
{
    /**
     * Test a rule
     *
     * @param $subject
     *
     * @return bool
     */
    public function test($subject);
}

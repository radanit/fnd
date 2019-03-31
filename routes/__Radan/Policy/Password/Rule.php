<?php 

namespace App\Radan\Policy\Password;


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

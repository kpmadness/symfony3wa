<?php

namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TelValidValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        $pattern='#^0[0-9]([ .-]?[0-9]{2}){4}$#';

        if(preg_match($pattern, $value)==false){
            $this->context->addViolation($constraint->message);
        }

    }
}
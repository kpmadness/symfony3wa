<?php

namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordCheckValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        $pattern='#^([a-zA-Z0-9$\.\/-_%]){4,}$#';

        if($value!="admin" && (preg_match($pattern, $value)==false)){

            $this->context->addViolation($constraint->message);
        }

    }
}


// Correction Ludo
//
//class StrongPasswordValidator extends ConstraintValidator
//{
//    public function validate($value, Constraint $constraint)
//    {
//        if(strlen($value) < $constraint->min)
//        {
//            $this->context->buildViolation($constraint->messageMin)
//                ->setParameter('{{ limit }}', $constraint->min)
//                ->addViolation();
//        }
//        elseif($constraint->caractere && !preg_match("#[".$constraint->caractere."]#", $value))
//        {
//            $this->context->buildViolation($constraint->messageCaractere)
//                ->setParameter('{{ valid }}', $constraint->caractere)
//                ->addViolation();
//        }
//
//    }
//}
<?php

namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntibadwordsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // Créer un tableau de gros mots
        // Si la valeur tapé par l'utilisateur est dans le tableau
        // Création d'une erreur

        $badwords = array('con','connard','bouffon','truffe','cruche');

        foreach($badwords as $val){

            $pattern = '#\b'.$val.'\b#i';

            if(preg_match($pattern, $value)){
                $this->context->addViolation($constraint->message);
            }
        }
    }
}
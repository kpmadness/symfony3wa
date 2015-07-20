<?php


namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TelValid extends Constraint
{
    public $message = "Le numéro de téléphone saisi n'est pas valide.";


}
<?php


namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antibadwords extends Constraint
{
    public $message = "Un gros mot est présent.";


}
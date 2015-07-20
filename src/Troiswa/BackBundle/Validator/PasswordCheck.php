<?php


namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordCheck extends Constraint
{
    public $message = "Le mot de passe saisi est invalide.";


}


// Correction Ludo

//class StrongPassword extends Constraint
//{
//    public $min = 8;
//    public $messageMin = "Votre mot de passe n'est pas assez fort. Il doit faire {{ limit }} caractères";
//    public $caractere = "%-_";
//    public $messageCaractere = "Votre mot de passe doit contenir les caractères suivants {{ valid }}";
//
//}



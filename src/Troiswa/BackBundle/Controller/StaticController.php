<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Troiswa\BackBundle\Form\ContactType;


class StaticController extends Controller
{

    public function displayCGVAction()
    {
        return $this->render("TroiswaBackBundle:Static:cgv.html.twig", array( "firstname" => "ludo",
                                                                              "age" => 27,
                                                                              "lastname" => "verechia"));
    }

    public function displayCGUAction()
    {
        return $this->render("TroiswaBackBundle:Static:cgu.html.twig");
    }

    public function displayTrainingPageAction($chaine)
    {
        return $this->render("TroiswaBackBundle:Static:cgu.html.twig");
    }

    public function displayTemplatePageAction()
    {
        return $this->render("TroiswaBackBundle:Static:heritage-template.html.twig");
    }

    public function displayTemplateTestAction()
    {
        return $this->render("TroiswaBackBundle:Static:test-integration.html.twig");
    }

    public function contactAction(Request $request)
    {
        // creation d'un formulaire de contact avec différents types de champ
        $formContact = $this->createForm(new ContactType(), null , array("attr" => array("novalidate" => "novalidate")));
//        dump($formContact);
//        die();
//                        ->getForm();

//        if($request->isMethod("POST")) {
//            // on hydrate ou binde le formulaire avec les infos du POST(données utilisateur=
//            $formContact->submit($request);
//            if($formContact->isValid()){
//                // on récupère les infos du formulaire
//                $data = $formContact->getData();
//                dump($data);
//                die();
//            }
//        }

        // remplace le if de la ligne 54-56
        $formContact->handleRequest($request);

        if($formContact->isValid()) {
            // on récupère les infos du formulaire
            $data = $formContact->getData();
//           dump($data);
//           die();


            $message = \Swift_Message::newInstance()
                ->setSubject($data['objet'])
                ->setFrom($data['email'])
                //->setTo('kevin.plaideur@free.fr')
//            ->setBody($data['message']);
                ->setBody($this->renderView('TroiswaBackBundle:Mails:contact-email.html.twig', array()), 'text/html')
                ->addPart($this->renderView('TroiswaBackBundle:Mails:contact-email.txt.twig', array()), 'text/plain');

            $this->get('mailer')->send($message);

            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre mail a bien été envoyé");

            return $this->redirectToRoute('troiswa_back_contact');
        }

        return $this->render("TroiswaBackBundle:Static:contact.html.twig",array("formContact" =>$formContact->createView()));
    }



    public function feedbackAction(Request $request)
    {
        // creation d'un formulaire de contact avec différents types de champ
        $formFeedback = $this->createFormBuilder(null , array("attr" => array("novalidate" => "novalidate")))
            ->add("firstname","text",
                array('constraints'=>
                    array(
                        new Assert\Length(
                            array(
                                'min'        => 2,
                                'max'        => 25,
                                'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères',
                                'maxMessage' => 'Votre prénom ne peut pas être plus long que {{ limit }} caractères',
                            )
                        ),
                        new Assert\NotBlank()
                    )
                )
            )
            ->add("lastname","text",
                array('constraints'=>
                    array(
                        new Assert\Length(
                            array(
                                'min'        => 2,
                                'max'        => 50,
                                'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                                'maxMessage' => 'Votre nom ne peut pas être plus long que {{ limit }} caractères',
                            )
                        ),
                        new Assert\NotBlank()
                    )
                )
            )
            ->add("email","text",
                array('constraints'=>
                    array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add("url","url",
                array(
                    'default_protocol' => 'http',
                    'constraints'=>
                        array(
                            new Assert\NotBlank()
                        )
                )
            )
            ->add('statut', 'choice',
                array(
                    'choices'  =>
                        array(
                            1 => 'bug affichage',
                            2 => 'bug fonctionnel',
                            3 => 'rien ne marche'
                        ),
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'constraints'=>
                        array(
                            new Assert\NotBlank()
                        )
                )
            )
            ->add("description","textarea",
                array('constraints'=>
                    array(
                        new Assert\Length(
                            array(
                                'min'        => 10,
                                'max'        => 400,
                                'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                                'maxMessage' => 'Votre message ne peut dépasser { limit }} caractères',
                            )
                        ),
                        new Assert\NotBlank()
                    )
                )
            )
            ->add('date', 'date',
                array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'years'  => range(date('Y')-10, date('Y')+10)
                )
            )
            ->add('Envoyer', 'submit')
            ->getForm();

        $formFeedback->handleRequest($request);

        if($formFeedback->isValid()) {
            // on récupère les infos du formulaire
            $data = $formFeedback->getData();
//           dump($data);
//           die();


            $message = \Swift_Message::newInstance()
                ->setSubject($data['statut'])
                ->setFrom($data['email'])
                //->setTo('kevin.plaideur@free.fr')
//            ->setBody($data['message']);
                ->setBody($this->renderView('TroiswaBackBundle:Mails:feedback-mail.html.twig', array()), 'text/html')
                ->addPart($this->renderView('TroiswaBackBundle:Mails:feedback-mail.txt.twig', array()), 'text/plain');

            $this->get('mailer')->send($message);

            $logger = $this->get('logger');

            if($date['statut']=1){
                $logger->info('Erreur : bug d\'affichage');
            } else {
                $logger->error('Erreur : bug fonctionnel');
            }




            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre mail a bien été envoyé");

            return $this->redirectToRoute('troiswa_back_feedback');
        }

        return $this->render("TroiswaBackBundle:Contact:feedback.html.twig",array("formFeedback" =>$formFeedback->createView()));
    }


}

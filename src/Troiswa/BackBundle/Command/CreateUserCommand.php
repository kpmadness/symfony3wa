<?php

namespace Troiswa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Troiswa\BackBundle\Entity\User;

class CreateUserCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
        ->setName('user:create')
        ->setDescription("Permet de créer un utilisateur en BDD
        Cette commande prend 2 paramètres obligatoires : le login et le mot de passe
        Elle insert en BDD le nouvelle utilisateur")
        ->addArgument('pseudo', InputArgument::REQUIRED, 'Veuillez saisir le pseudo de votre utilisateur ?')
        ->addArgument('password', InputArgument::REQUIRED, 'Veuillez saisir le mot de passe de votre utilisateur ?')
        ->addOption('update', '--exist', InputOption::VALUE_NONE,
            'Si une option existe (ex : --exist) alors cela met à jour un utilisateur'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $templating=$this->getContainer()->get("templating");

        $pseudo=$input->getArgument("pseudo");
        $pass=$input->getArgument("password");

        $option= $input->getOption("update");

//        $style = new OutputFormatterStyle('yellow', 'red', ['bold']);
//        $output->getFormatter()->setStyle('fire', $style);

        if($option){
            $user=$this->updateUserWithEncryptPassword($pseudo,$pass);

            if($user){
                $output->writeln("<info>L'utilisateur " . $pseudo . " a bien été mis à jour</info>");
            } else {
                $output->writeln("<info>L'utilisateur " . $pseudo . " n'existe pas</info>");
            }

         } else {
            $this->createUserWithEncryptPassword($pseudo,$pass);
            $output->writeln("<info>Nouvel utilisateur crée</info>");
        }



//        $message = \Swift_Message::newInstance()
//            ->setSubject('Alerte Stock')
//            ->setFrom("kevin.plaideur@gmail.com")
//            ->setTo("kevin.plaideur@gmail.com")
//            ->setBody($data['message'])
//            ->setBody($templating->render('TroiswaBackBundle:Mails:contact-email.html.twig', array( 'products' => $products)), 'text/html')
//            ->addPart($templating->render('TroiswaBackBundle:Mails:contact-email.txt.twig', array()), 'text/plain');
//
//        $this->getContainer()->get('mailer')->send($message);



    }


    protected function createUserWithEncryptPassword($pseudo, $pass)
    {

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();

        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $passEncrypt = $encoder->encodePassword($pass, $user->getSalt());

        $user->setFirstname('Toto');
        $user->setLastname('Tutu');
        $user->setMail('toto@toto.fr');
        $user->setPhone('0102030405');
        $user->setAddress("12 rue test");
        $user->setPseudo($pseudo);
        $user->setPassword($passEncrypt);

    //        $date = new DateTime('2015-04-18');
        $user->setBirthdate(new \DateTime('now'));

        $em->persist($user);
        $em->flush();
    }


    protected function updateUserWithEncryptPassword($pseudo, $pass)
    {

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $factory = $this->getContainer()->get('security.encoder_factory');


//        $user = $em->getRepository('TroiswaBackBundle:User')
//            ->findOneBy(['pseudo' => $input->getArgument('pseudo')]);


        $user = $em->getRepository('TroiswaBackBundle:User')
            ->findOneByPseudo($pseudo);


        if ($user) {
            $encoder = $factory->getEncoder($user);
            $newPassword = $encoder->encodePassword($pass, $user->getSalt());
            $user->setPassword($newPassword);
            $em->persist($user);
            $em->flush();


            return true;
        }

    }

}
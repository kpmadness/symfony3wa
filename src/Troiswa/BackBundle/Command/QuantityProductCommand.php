<?php

namespace Troiswa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QuantityProductCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
        ->setName('product:quantity')
        ->setDescription("Permet d'envoyer un mail des produits dont la quantité est inférieur à 5")
        ->addArgument('nombre', InputArgument::OPTIONAL, 'Quantité demandé ?')
        ->addOption('message', 'm', InputOption::VALUE_NONE,
            'Si définie, un petit message apparaitra'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $templating=$this->getContainer()->get("templating");

        //$qty=5;

        $qty=$input->getArgument("nombre");

        $option= $input->getOption("message");

        if($option){
            $output->writeln("<comment>Un autre message</comment>");
        }

        $products=$em->getRepository("TroiswaBackBundle:Product")->findProductByQuantity($qty);

        $output->writeln("<info>Bravo</info>");

//        dump($products);
//        die();

        $message = \Swift_Message::newInstance()
            ->setSubject('Alerte Stock')
            ->setFrom("kevin.plaideur@gmail.com")
            ->setTo("kevin.plaideur@gmail.com")
//            ->setBody($data['message'])
            ->setBody($templating->render('TroiswaBackBundle:Mails:contact-email.html.twig', array( 'products' => $products)), 'text/html')
            ->addPart($templating->render('TroiswaBackBundle:Mails:contact-email.txt.twig', array()), 'text/plain');

        $this->getContainer()->get('mailer')->send($message);



    }


}
<?php
namespace ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ApiBundle\Document\Change;
use ApiBundle\Document\Logs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;


class BteCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this
            ->setName('btetasks:run')
            ->setDescription('Runs Cron Tasks if needed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron Tasks...</comment>');

        $this->output = $output;
        $repository = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $em = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');


            $html = @file_get_contents("http://www.bte.com.tn/?lang=fr&idart=8"); //getting the file content


            $banque = $repository->getRepository('ApiBundle:Banque')->findOneBy(array('raison_social' => 'Bte'));

         if(!$html){
             $logs = new Logs();
             $logs->setBanque($banque);
             $logs->setDcr(new \Datetime());
             $logs->setData("Probleme recuperation pour la banque ". $banque->getRaisonSocial());
             $em->persist($logs);
             $em->flush();
         }
         //$html = file_get_contents("http://www.bte.com.tn/?lang=fr&idart=8");
        $crawler = new Crawler($html);
        $link = $crawler->filter('td.bottomline');
        $i=0;
        $j=0;
        $array_receive= array();
        foreach($link  as $domElement){
            // print $domElement->nodeValue;
            $k=$domElement->nodeValue;

            if($i<=5)
            {

                if($i==0)
                    $array_receive[$j]["designation"]=$k;

                else
                    if($i==1)

                        $array_receive[$j]["code"]=substr($k, 2, 3);
                    else
                        if($i==2)
                            $array_receive[$j]["nbre_unité"]=$k;
                        else

                            if($i==3)
                                $array_receive[$j]["cours_achat"]=$k;
                            else
                                if($i==4)
                                    $array_receive[$j]["cours_vente"]=$k;
                $i++;
                if($i==5)
                {
                    $i=0;
                    $j++;
                }


            }
        }
        //pour chaque élément de $agenda crée la variable $adresse
        foreach($array_receive as $adresse){

            $taux = new Change();
            $taux->setType(true);
            $taux->setDateTime(new \Datetime());
            $taux->setTauxAchat($adresse["cours_achat"]);
            $taux->setTauxVente($adresse["cours_vente"]);

            $repository = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
            $devise = $repository->getRepository('ApiBundle:Devise')->findOneBy(array('code_iso' => $adresse["code"]));
            $taux->setDevise($devise);

            $repository = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
            $banque = $repository->getRepository('ApiBundle:Banque')->findOneBy(array('raison_social' => 'Bte'));
            $taux->setBanque($banque);




            // On récupère l'EntityManager
            $em = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
            // Étape 1 : On « persiste » l'entité
            $em->persist($taux);
            // Étape 2 : On « flush » tout ce qui a été persisté avant
            $em->flush();
            //A chaque nouveau $adresse, saute une ligne
        }


        $output->writeln('<comment>Done!</comment>');
    }

    private function runCommand($string)
    {
        // Split namespace and arguments
        $namespace = split(' ', $string)[0];

        // Set input
        $command = $this->getApplication()->find($namespace);
        $input = new StringInput($string);

        // Send all output to the console
        $returnCode = $command->run($input, $this->output);

        return $returnCode != 0;
    }
}
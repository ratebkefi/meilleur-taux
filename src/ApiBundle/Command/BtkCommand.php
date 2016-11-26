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


class BtkCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this
            ->setName('btktasks:run')
            ->setDescription('Runs Cron Tasks if needed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {$output->writeln('<comment>Running Cron Tasks...</comment>');

        $this->output = $output;
        $repository = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $em = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');


            $html = @file_get_contents("http://www.btknet.com/site/fr/convertisseur.php?id_article=33"); //getting the file content
            $banque = $repository->getRepository('ApiBundle:Banque')->findOneBy(array('raison_social' => 'BTK'));
        if(!$html){
            $logs = new Logs();
            $logs->setBanque($banque);
            $logs->setDcr(new \Datetime());
            $logs->setData("Probleme recuperation pour la banque ". $banque->getRaisonSocial());
            $em->persist($logs);
            $em->flush();
        }
        //$html = file_get_contents("http://www.btknet.com/site/fr/convertisseur.php?id_article=33");
        $crawler = new Crawler($html);
        $link = $crawler->filter('td.ligne_devise_interne td > strong ');
        $i = 0;
        $j = 0;
        $s = 0;
        $p = 0;
        $array_receive = array();
        $array_receive1 = array();
        foreach ($link as $domElement) {
            // print $domElement->nodeValue;
            $k = $domElement->nodeValue;
            if ($s < 7) {
                $array_receive1[$s] = $k;
                $s++;


            }
        }

        $link = $crawler->filter('td.ligne_devise_interne');
        foreach ($link as $domElement) {
            // print $domElement->nodeValue;
            $k = $domElement->nodeValue;

            if ($i <= 4) {


                if ($i == 0) {
                    $array_receive[$j]["code"] = $array_receive1[$p];
                    $p++;
                } else
                    if ($i == 1)
                        $array_receive[$j]["nbre_unité"] = $k;
                    else

                        if ($i == 2)
                            $array_receive[$j]["cours_achat"] = $k;
                        else
                            if ($i == 3)
                                $array_receive[$j]["cours_vente"] = $k;
                $i++;
                if ($i == 4) {
                    $i = 0;
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
            $banque = $repository->getRepository('ApiBundle:Banque')->findOneBy(array('raison_social' => 'BTK'));
            $taux->setBanque($banque);




            // On récupère l'EntityManager
            $em = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
            // Étape 1 : On « persiste » l'entité
            $em->persist($taux);
            // Étape 2 : On « flush » tout ce qui a été persisté avant
            $em->flush();
            //A chaque nouveau $adresse, saute une ligne
        }

        /***--------------------------------------------**/
        $crawler = new Crawler($html);
        $link = $crawler->filter('td.ligne_devise_interne2 td > strong ');
        $i = 0;
        $j = 0;
        $s = 0;
        $p = 0;
        $array_receive = array();
        $array_receive1 = array();
        foreach ($link as $domElement) {
            // print $domElement->nodeValue;
            $k = $domElement->nodeValue;
            if ($s < 7) {
                $array_receive1[$s] = $k;
                $s++;


            }
        }

        $link = $crawler->filter('td.ligne_devise_interne2');
        foreach ($link as $domElement) {
            // print $domElement->nodeValue;
            $k = $domElement->nodeValue;

            if ($i <= 4) {


                if ($i == 0) {
                    $array_receive[$j]["code"] = $array_receive1[$p];
                    $p++;
                } else
                    if ($i == 1)
                        $array_receive[$j]["nbre_unité"] = $k;
                    else

                        if ($i == 2)
                            $array_receive[$j]["cours_achat"] = $k;
                        else
                            if ($i == 3)
                                $array_receive[$j]["cours_vente"] = $k;
                $i++;
                if ($i == 4) {
                    $i = 0;
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
            $banque = $repository->getRepository('ApiBundle:Banque')->findOneBy(array('raison_social' => 'BTK'));
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
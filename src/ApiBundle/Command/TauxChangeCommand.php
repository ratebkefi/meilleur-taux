<?php
namespace ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ApiBundle\Document\TauxChange;
use ApiBundle\Document\Logs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;


class TauxChangeCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this
            ->setName('TauxChangetasks:run')
            ->setDescription('Runs Cron Tasks if needed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron Tasks...</comment>');
        $repository = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $em = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $this->output = $output;

        $repository = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $em = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $membres = $repository->getRepository('ApiBundle:Membre')->findBy(array("resumer_quotidien" => 1));
        //afficher taux de change
        $tauxChange = $repository->getRepository('ApiBundle:Change')->findBy(array('date_time' => new \DateTime()));
        /**/
        foreach ($membres as $value) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Taux de change journaliére')
                ->setFrom('ali.belhadjj@gmail.com')
                ->setTo($value->getEmail())
                ->setBody($this->renderView('ApiBundle:Email:resumer_quatidien.html.twig', array("client" => $value,"change" => $tauxChange)));
            $message->setContentType("text/html");
            $this->get('mailer')->send($message);
        }

        /**/


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
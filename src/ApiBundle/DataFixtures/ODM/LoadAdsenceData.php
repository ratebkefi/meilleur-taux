<?php
namespace ApiBundle\DataFixtures\ODM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ApiBundle\Document\Adsence;

class LoadAdsenceData  implements FixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        /*
         * Pour excuter la dataFixtures
         * php app/console doctrine:mongodb:fixtures:load --fixtures=src/ApiBundle/DataFixtures/ODM --append
         */

        /* Ajouter adsense dans header web */
        $adsense = new Adsence();
        $adsense->setEtat(false);
        $adsense->setNom('adsense_header');
        $adsense->setCode('');
        $manager->persist($adsense);
        $manager->flush();

        /* Ajouter adsense dans header mobile */
        $adsense = new Adsence();
        $adsense->setEtat(false);
        $adsense->setNom('adsense_header_mobile');
        $adsense->setCode('');
        $manager->persist($adsense);
        $manager->flush();

        /* Ajouter adsense dans footer web */
        $adsense = new Adsence();
        $adsense->setEtat(false);
        $adsense->setNom('adsense_footer');
        $adsense->setCode('');
        $manager->persist($adsense);
        $manager->flush();

        /* Ajouter adsense dans footer web */
        $adsense = new Adsence();
        $adsense->setEtat(false);
        $adsense->setNom('adsense_footer_mobile');
        $adsense->setCode('');
        $manager->persist($adsense);
        $manager->flush();
    }

}
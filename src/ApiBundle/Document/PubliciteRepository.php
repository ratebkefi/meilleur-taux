<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * PubliciteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PubliciteRepository extends DocumentRepository
{

    public function pubactive()
    {
        $datecours = new \DateTime(date('Y-m-d H:i:s'));
        //$datecours = new \DateTime();
        $qb = $this->getDocumentManager()->createQueryBuilder('ApiBundle:Publicite');
        $qb->find('ApiBundle:Publicite')->field('etat')->equals(true);
        $qb->find('ApiBundle:Publicite')->field('date_debut')->lte($datecours);
        $qb->find('ApiBundle:Publicite')->field('date_fin')->gte($datecours);
        $query = $qb->getQuery();
        $result = $query->toArray();
        return $result;
    }
}
<?php

namespace FrontBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiBundle\Document\Change;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

class BanqueController extends Controller
{
    /**
     * Lister les banques.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request               $request      the request object
     *
     * @return array
     */
    public function listAction(Request $request)
    {

        $em = $this->getDocumentManager();
        $banques = $em->getRepository('ApiBundle:Banque')->findAll();
        return $banques;
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

}

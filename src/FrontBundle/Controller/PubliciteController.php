<?php

namespace FrontBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiBundle\Document\Change;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

class PubliciteController extends Controller
{
    public function listAction(Request $request)
    {
        /**
         * Lister les publicités.
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
         * @param Request $request the request object
         *
         * @return array
         */
        $em = $this->getDocumentManager();
        $pub = $em->getRepository('ApiBundle:Publicite')->findAll();
        return $pub;
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

    /**
     * Affiche les pub actives.
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
     * @param Request $request the request object
     *
     * @return array
     */
    public function activeAction(Request $request)
    {

        $em = $this->getDocumentManager();
        $pub = $em->getRepository('ApiBundle:Publicite')->pubactive();
        return $pub;
    }

    /**
     * Affiche une pub.
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
     * @param Request $request the request object
     *
     * @return array
     */
    public function showAction($id)
    {
        $em = $this->getDocumentManager();
        $pub = $em->getRepository('ApiBundle:Publicite')->find($id);
        return $pub;
    }

}

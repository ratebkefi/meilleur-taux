<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Change;
use ApiBundle\Document\Banque;
use ApiBundle\Document\Devise;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TauxChangeController extends FOSRestController
{

    /**
     * Afficher tous les taux de change.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */

    public function listerTauxChangeAction($itemsPerPage, $pagenumber)
    {
        $em = $this->getDocumentManager();
        //echo $request->get('page');
        //echo $request->get('perPage');
        $form = ($pagenumber - 1) * $itemsPerPage;
        $to = $itemsPerPage + $form;
        $services = $em->getRepository('ApiBundle:Change')->findBy(array(), array(),
            $to, $form);
        // return $devises;


        return $services;

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
     * total Change.
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
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function totalAction(Request $request)
    {

        $dm = $this->getDocumentManager();
        $services = $dm
            ->getRepository('ApiBundle:Change')
            ->recupererTotalChange($request);

        return count($services);
    }

    /**
     * filtrerTauxChangeActions un nouveau taux de change.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     *
     * @return String
     */
    public function filtrerTauxChangeAction(Request $request, $itemsPerPage, $pagenumber)
    {


        $dm = $this->getDocumentManager();
        $services = $dm
            ->getRepository('ApiBundle:Change')
            ->recupererListChange($request, $itemsPerPage, $pagenumber);


        return $services;
    }

    /**
     * Afficher Une Page.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function afficherTauxChangeAction($id)
    {

        $dm = $this->getDocumentManager();
        $change = $dm->getRepository('ApiBundle:Change')->find($id);
        return $change;
    }

    /**
     * Supprimer Une page.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int $id the Page id
     *
     * @return String
     */
    public function supprimerTauxChangeAction($id)
    {


        $dm = $this->getDocumentManager();
        $change = $dm->getRepository('ApiBundle:Change')->find($id);

        if (!$change) {
            throw $this->createNotFoundException('Unable to find Change document.');
        }
        $dm->remove($change);
        $dm->flush();
        return "Change Supprimer !";
    }

    /**
     * Ajouter un nouveau taux de change.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     *
     * @return String
     */
    public function ajouterTauxChangeAction(Request $request)
    {
        $token = $this->securityContext->getToken();
        $user = $token->getUser();
        if ($user == 'anon.') {
            return 401;
            exit;
        } else {
            $roles = $user->getGroupe()->getRole();
            $valid = true;
            $route = $request->attributes->get('_route');
            foreach ($roles as $role) {
                if (!in_array($route, $roles)) {
                    $valid = false;
                }
                if (!$valid) {
                    return 403;
                    exit;
                }
            }
        }
        $dm = $this->getDocumentManager();
        $change = new Change();
        $banque = $dm->getRepository('ApiBundle:Banque')->find($request->get('banque'));
        $devise = $dm->getRepository('ApiBundle:Devise')->find($request->get('devise'));

        $change->setDateTime(new \DateTime($time = '00:00:00'));
        $change->setTauxAchat($request->get('taux_achat'));
        $change->setTauxVente($request->get("taux_vente"));
        $change->setType(0);
        $change->setBanque($banque);
        $change->setDevise($devise);
        $dm->persist($change);
        $dm->flush();
        return "Taux de change ajouté";
    }

    /**
     * Exporter les taux de change.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param Request $request the request object
     *
     * @return String
     */
    public function exporterTauxChangeAction(Request $request)
    {
        $dm = $this->getDocumentManager();
        $dateDebut = $request->get("date_debut");
        $dateFin = $request->get("date_fin");
        $change = $dm->getRepository('ApiBundle:Change')->recupererListChange($dateDebut, $dateFin);
        return $change;
    }

}

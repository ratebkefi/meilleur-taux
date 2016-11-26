<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ApiBundle\Document\Alerte;


class AlerteController extends FOSRestController {

    /**
     * Afficher une Alerte.
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
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function afficherAlerteAction($id) {
        $dm = $this->getDocumentManager();
        $alerte = $dm->getRepository('ApiBundle:Alerte')->find($id);
        return $alerte;
    }

    /**
     * Lister les alertes.
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
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function listerAlerteAction() {
        $dm = $this->getDocumentManager();
        $pages = $dm->getRepository('ApiBundle:Alerte')->findAll();
        return $pages;
    }

    /**
     * Supprimer une Alerte.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int     $id      ID de l'alerte
     *
     * @return String
     */
    public function supprimerAlerteAction($id) {
        $dm = $this->getDocumentManager();
        $document = $dm->getRepository('ApiBundle:Alerte')->find($id);
        if (!$document) {
            throw $this->createNotFoundException('impossible de trouver l\'alerte.');
        }
        $dm->remove($document);
        $dm->flush();
        return "Alerte Supprimée";
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    private function getDocumentManager() {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * Ajouter une alerte.
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
    public function ajouterAlerteAction(Request $request) {
        $alerte = new Alerte();
        $dm = $this->getDocumentManager();
        $membre = $dm->getRepository('ApiBundle:Membre')->find($request->get('membre'));
        $devise = $dm->getRepository('ApiBundle:Devise')->find($request->get('devise'));
        $alerte->setMembre($membre);
        $alerte->setDevise($devise);
        $alerte->setEquation($request->get('equation'));
        $alerte->setType($request->get('type'));
        $alerte->setValeur($request->get('valeur'));
        $dm->persist($alerte);
        $dm->flush();

        return "Alerte ajoutée";
    }

    /**
     * Modifier Alerte.
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
    public function modifierAlerteAction(Request $request) {
        $dm = $this->getDocumentManager();
        $alerte = $dm->getRepository('ApiBundle:Alerte')->find($request->get('id'));
        $membre = $dm->getRepository('ApiBundle:Membre')->find($request->get('membre'));
        $devise = $dm->getRepository('ApiBundle:Devise')->find($request->get('devise'));
        $alerte->setMembre($membre);
        $alerte->setDevise($devise);
        $alerte->setEquation($request->get('equation'));
        $alerte->setType($request->get('type'));
        $alerte->setValeur($request->get('valeur'));
        $dm->persist($alerte);
        $dm->flush();
        return "Alerte ajoutée";
    }

}

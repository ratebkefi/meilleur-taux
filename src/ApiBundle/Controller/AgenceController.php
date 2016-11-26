<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Agence;
use ApiBundle\Document\Banque;
use ApiBundle\Document\Devise;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AgenceController extends FOSRestController {

    /**
     * Afficher toutes les agences.
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
    public function listerAgencesAction() {
        $dm = $this->getDocumentManager();
        $agences = $dm->getRepository('ApiBundle:Agence')->findAll();
        return $agences;
    }

    /**
     * Afficher une agence.
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
    public function afficherAgenceAction($id) {
        $dm = $this->getDocumentManager();
        $agence = $dm->getRepository('ApiBundle:Agence')->find($id);
        return $agence;
    }

    /**
     * Supprimer Une agence.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int     $id      ID de l'agence
     *
     * @return String
     */
    public function supprimerAgenceAction($id) {
        $dm = $this->getDocumentManager();
        $agence = $dm->getRepository('ApiBundle:Agence')->find($id);
        if (!$agence) {
            throw $this->createNotFoundException('Impossible de trouver l\'agence');
        }
        $dm->remove($agence);
        $dm->flush();
        return "Agence supprimée";
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
     * Ajouter Nouvelle Agence.
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
    public function ajouterAgenceAction(Request $request) {
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
        $banque = $dm->getRepository('ApiBundle:Banque')->find($request->get('banque'));
        $agence = new Agence();
        $agence->setNom($request->get('nom'));
        $agence->setAdresse($request->get('adresse'));
        $agence->setTel($request->get('tel'));
        $agence->setFax($request->get('fax'));
        $agence->setLatitude($request->get('latitude'));
        $agence->setLongitude($request->get('longitude'));
        $agence->setType($request->get('type'));
        $agence->setBanque($banque);
        $dm->persist($agence);
        $dm->flush();
        return "Agence ajoutée";
    }

    /**
     * Modifier une agence.
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
    public function modifierAgenceAction(Request $request) {
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
        $agence = $dm->getRepository('ApiBundle:Agence')->find($request->get('id'));
        $banque = $dm->getRepository('ApiBundle:Banque')->find($request->get('banque'));
        $agence->setNom($request->get('nom'));
        $agence->setAdresse($request->get('adresse'));
        $agence->setTel($request->get('tel'));
        $agence->setFax($request->get('fax'));
        $agence->setLatitude($request->get('latitude'));
        $agence->setLongitude($request->get('longitude'));
        $agence->setType($request->get('type'));
        $agence->setBanque($banque);
        $dm->persist($agence);
        $dm->flush();
        return "Agence modifiée";
    }

}

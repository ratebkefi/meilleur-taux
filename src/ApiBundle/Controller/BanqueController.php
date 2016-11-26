<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Banque;
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

class BanqueController extends FOSRestController {

    /**
     * Afficher une banque.
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
    public function afficherBanqueAction($id) {
        $dm = $this->getDocumentManager();
        $banque = $dm->getRepository('ApiBundle:Banque')->find($id);
        return $banque;
    }

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
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function listerBanqueAction() {
        $dm = $this->getDocumentManager();
        $banques = $dm->getRepository('ApiBundle:Banque')->findAll();
        return $banques;
    }

    /**
     * Supprimer une banque.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int     $id      the Banque id
     *
     * @return String
     */
    public function supprimerBanqueAction($id) {
        $dm = $this->getDocumentManager();
        $banque = $dm->getRepository('ApiBundle:Banque')->find($id);
        if (!$banque) {
            throw $this->createNotFoundException('Impossible de trouver la Banque.');
        }
        $dm->remove($banque);
        $dm->flush();
        return "Banque supprimée";
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
     * Ajouter une banque.
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
    public function ajouterBanqueAction(Request $request) {
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
        $banque = new Banque();
        $dm = $this->getDocumentManager();
        $banque->setAdresse($request->get('adresse'));
        $banque->setCapital($request->get('capital'));
        $banque->setCentrale($request->get('centrale'));
        $banque->setEmail($request->get('email'));
        $banque->setFax($request->get('fax'));
        $banque->setLogo($request->get('logo'));
        $banque->setOffshore($request->get('offshore'));
        $banque->setRemarque($request->get('remarque'));
        $banque->setSiteweb($request->get('site_web'));
        $banque->setTel($request->get('tel'));
        $banque->setTel2($request->get('tel2'));
        $banque->setRaisonSocial($request->get('raison_social'));
        $banque->setUrlDevise($request->get('url_devise'));

        $dm->persist($banque);
        $dm->flush();

        return "Banque ajoutée";
    }

    /**
     * Modifier une banque.
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
    public function modifierBanqueAction(Request $request) {
        /* $token = $this->securityContext->getToken();
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
        } */
        $dm = $this->getDocumentManager();
        $banque = $dm->getRepository('ApiBundle:Banque')->find($request->get('id'));
        $banque->setAdresse($request->get('adresse'));
        $banque->setCapital($request->get('capital'));
        $banque->setCentrale($request->get('centrale'));
        $banque->setEmail($request->get('email'));
        $banque->setFax($request->get('fax'));
        $banque->setLogo($request->get('logo'));
        $banque->setOffshore($request->get('offshore'));
        $banque->setRemarque($request->get('remarque'));
        $banque->setSiteweb($request->get('web_site'));
        $banque->setTel($request->get('tel'));
        $banque->setTel2($request->get('tel2'));
        $banque->setRaisonSocial($request->get('raison_social'));
        $banque->setUrlDevise($request->get('url_devise'));
        $dm->persist($banque);
        $dm->flush();
        return "Banque modifiée";
    }

}

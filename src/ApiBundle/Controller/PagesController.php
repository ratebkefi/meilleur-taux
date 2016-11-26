<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Pages;
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

class PagesController extends FOSRestController {

    /**
     * Afficher toutes les Pages.
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
    public function listerPagesAction() {
        $dm = $this->getDocumentManager();
        $pages = $dm->getRepository('ApiBundle:Pages')->findAll();
        return $pages;
    }

    /**
     * Afficher une page.
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
    public function afficherPagesAction($id) {
        $dm = $this->getDocumentManager();
        $page = $dm->getRepository('ApiBundle:Pages')->find($id);
        return $page;
    }

    /**
     * Supprimer une page.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int     $id      the Page id
     *
     * @return String
     */
    public function supprimerPagesAction($id) {
        $dm = $this->getDocumentManager();
        $page = $dm->getRepository('ApiBundle:Pages')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Impossible de trouver la page');
        }
        $dm->remove($page);
        $dm->flush();
        return "Page supprimée";
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
     * Ajouter une nouvelle page.
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
    public function ajouterPagesAction(Request $request) {
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
        $page = new Pages();
        $dm = $this->getDocumentManager();
        $page->setNom($request->get('nom'));
        $page->setText($request->get('text'));
        $page->setBalDesc($request->get('bal_desc'));
        $page->setBalTitre($request->get('bal_titre'));
        $dm->persist($page);
        $dm->flush();
        return "Page ajoutée";
    }

    /**
     * Modifier une page.
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
    public function modifierPagesAction($id,Request $request) {
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
        $page = $dm->getRepository('ApiBundle:Pages')->find($id);
        $page->setNom($request->get('nom'));
        $page->setText($request->get('text'));
        $page->setBalDesc($request->get('bal_desc'));
        $page->setBalTitre($request->get('bal_titre'));
        $dm->persist($page);
        $dm->flush();
        return "Page modifiée";
    }

}

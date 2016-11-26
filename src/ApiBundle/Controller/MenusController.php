<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Menu;
use ApiBundle\Document\Pages;
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

class MenusController extends FOSRestController {

    /**
     * Afficher tous les menus.
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
    public function listerMenusAction() {

        $dm = $this->getDocumentManager();
        $menus = $dm->getRepository('ApiBundle:Menu')->findAll();
        return $menus;
    }

    /**
     * Afficher un menu.
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
    public function afficherMenusAction($id) {

        $dm = $this->getDocumentManager();
        $menu = $dm->getRepository('ApiBundle:Menu')->find($id);
        return $menu;
    }

    /**
     * Supprimer un menu.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int     $id      ID du menu
     *
     * @return String
     */
    public function supprimerMenusAction($id) {

        $dm = $this->getDocumentManager();
        $menu = $dm->getRepository('ApiBundle:Menu')->find($id);

        if (!$menu) {
            throw $this->createNotFoundException('Impossible de trouver le menu');
        }
        $dm->remove($menu);
        $dm->flush();
        return "Menu supprimé";
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
     * Ajouter un nouveau menu.
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
    public function ajouterMenusAction(Request $request) {
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
        $page = $dm->getRepository('ApiBundle:Pages')->find($request->get('page'));
        $menu = new Menu();

        $menu->setType($request->get('type'));
        $menu->setTitre($request->get('titre'));
        $menu->setPages($page);
        $dm->persist($menu);
        $dm->flush();
        return "Menu ajouté";
    }

    /**
     * Modifier un menu.
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
    public function modifierMenusAction(Request $request) {
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
        $menu = $dm->getRepository('ApiBundle:Menu')->find($request->get('id'));
        $page = $dm->getRepository('ApiBundle:Pages')->find($request->get('page'));
        $menu->setType($request->get('type'));
        $menu->setTitre($request->get('titre'));
        $menu->setPages($page);
        $dm->persist($menu);
        $dm->flush();
        return "Menu modifié";
    }

}

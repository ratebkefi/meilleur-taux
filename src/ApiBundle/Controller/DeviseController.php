<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ApiBundle\Document\Devise;

class DeviseController extends FOSRestController {

//Cette fonction retourne le document(entity) manager.
    private function getDocumentManager() {

        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * Lister total les devise.
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
    public function listerTotalDevisesAction() {
        $dm = $this->getDocumentManager();
        $devise = $dm->getRepository('ApiBundle:Devise')->findAll();
        return $devise;
    }
    // retour de la liste des Devises.

    /**
     * Lister les devises.
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
    public function listerDevisesAction($itemsPerPage, $pagenumber) {
        $em = $this->getDocumentManager();
        //echo $request->get('page');
        //echo $request->get('perPage');
        $form = ($pagenumber-1 ) * $itemsPerPage;
        $to = $itemsPerPage+$form;
        $devises = $em->getRepository('ApiBundle:Devise')->findBy(array(),array() ,
            $to, $form     );
       // return $devises;
        return $devises;
    }
    /**
     * total devises.
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
    public function totalAction() {
        $em = $this->getDocumentManager();
        $devisesList = count($em->getRepository('ApiBundle:Devise')->findAll());

        return $devisesList;
    }

    /**
     *  Afficher une devise.
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
    public function afficherDeviseAction($id) {
        $em = $this->getDocumentManager();
        $devise = $em->getRepository('ApiBundle:Devise')->find($id);
        return $devise;
    }
// Ajout Devise.

    /**
     * Ajouter une devise.
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
    public function ajouterDeviseAction(Request $request) {
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
        $em = $this->getDocumentManager();
        $devise = new Devise();
        $devise->setCodeIso($request->get('code_iso'));
        $devise->setIcone($request->get('icone'));
        $devise->setNom($request->get('nom'));
        $devise->setSigle($request->get('sigle'));
        $devise->setUnite($request->get('unite'));
        $em->persist($devise);
        $em->flush();

        return "Devise Ajoutée";
    }

// Modifier Devise.

    /**
     * modifier une devise.
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
    public function modifierDeviseAction( Request $request) {
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
        $em = $this->getDocumentManager();
        $devise = $em->getRepository('ApiBundle:Devise')->find($request->get('id'));
        $devise->setCodeIso($request->get('code_iso'));
        $devise->setIcone($request->get('icone'));
        $devise->setNom($request->get('nom'));
        $devise->setSigle($request->get('sigle'));
        $devise->setUnite($request->get('unite'));
        $em->persist($devise);
        $em->flush();
        return "Devise Modifiée";
    }

    //Supprimer Devise.

    /**
     * supprimer une devise.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int     $id      the Group id
     *
     * @return String
     */
    public function supprimerDeviseAction($id) {
        $em = $this->getDocumentManager();
        $devise = $em->getRepository('ApiBundle:Devise')->find($id);
        if (!$devise) {
            throw $this->createNotFoundException('Impssible de trouver la devise.');
        }
        $em->remove($devise);
        $em->flush();
        return "Devise supprimée";
    }

}

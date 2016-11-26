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
use ApiBundle\Document\Publicite;

class PubliciteController extends FOSRestController {

//Cette fonction retourne le document(entity) manager.
    private function getDocumentManager() {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    // retour de la liste des Publicites.   
    /**
     * Liste des publicités.
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
    public function listerPublicitesAction() {
        $em = $this->getDocumentManager();
        $publicites = $em->getRepository('ApiBundle:Publicite')
                ->findAll();
        return $publicites;
    }

    /**
     *  afficher une publicité.
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
    public function afficherPubliciteAction($id) {
        $em = $this->getDocumentManager();
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($id);
        return $publicite;
    }

    /**
     * Ajouter une publicité.
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
    public function ajouterPubliciteAction(Request $request) {

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
        }*/
        $em = $this->getDocumentManager();
        $publicite = new Publicite();
        $publicite->setClick(0);
        $publicite->setDateDebut($request->get('date_debut'));
        $publicite->setDateFin($request->get('date_fin'));
        $publicite->setEtat($request->get('etat'));
        $publicite->setMaxClick($request->get('max_click'));
        $publicite->setMaxVu($request->get('max_vu'));
        $publicite->setNom($request->get('nom'));
        $publicite->setPhoto($request->get('photo'));
        $publicite->setType($request->get('type'));
        $publicite->setUrl($request->get('url'));
        $publicite->setUrlBlanck($request->get('url_blanck'));
        $publicite->setVu(0);
        $em->persist($publicite);
        $em->flush();
        return "publicité ajoutée";
    }

// Modifier Publicite.

    /**
     * modifier une publicité.
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
    public function modifierPubliciteAction(Request $request) {
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
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($request->get('id'));
        $publicite->setClick(0);
        $publicite->setDateDebut($request->get('date_debut'));
        $publicite->setDateFin($request->get('date_fin'));
        $publicite->setEtat($request->get('etat'));
        $publicite->setMaxClick($request->get('max_click'));
        $publicite->setMaxVu($request->get('max_vu'));
        $publicite->setNom($request->get('nom'));
        $publicite->setPhoto($request->get('photo'));
        $publicite->setType($request->get('type'));
        $publicite->setUrl($request->get('url'));
        $publicite->setUrlBlanck($request->get('url_blanck'));
        $publicite->setVu(0);
        $em->persist($publicite);
        $em->flush();
        
    }

    //Supprimer une publicité.

    /**
     * supprimer une publicite.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int $id the Group id
     *
     * @return String
     */
    public function supprimerPubliciteAction($id) {
        $em = $this->getDocumentManager();
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($id);
        if (!$publicite) {
            throw $this->createNotFoundException('Impossible de trouver la publicité');
        }
            $em->remove($publicite);
            $em->flush();
        
    }

    // retour du nombre de click des Publicités.

    /**
     * Afficher le nombre de click d'une publicité.
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
    public function nbrClickPublicitesAction($id) {
        $em = $this->getDocumentManager();
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($id);
        return $publicite->getClick();
    }

    // Incrémenter le nombre de clicks d'une publicité.

    /**
     * Incrémenter le nombre de clicks d'une publicité.
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
    public function incClickPublicitesAction($id) {
        $em = $this->getDocumentManager();
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($id);
        $nombreClique = $publicite->getClick();
        $publicite->setClick($nombreClique + 1);
        return $publicite->getClick();
    }

    // Afficher nombre de vu de 1 Publicite.

    /**
     * incrémenter me nombre de vus d'une Publicité.
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
    public function nbrVuPublicitesAction($id) {
        $em = $this->getDocumentManager();
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($id);
        return $publicite->getVu();
    }

    // incrémenter nombre de vu Publicites.

    /**
     * List all Publicites.
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
    public function incNbrVuPublicitesAction($id) {
        $em = $this->getDocumentManager();
        $publicite = $em->getRepository('ApiBundle:Publicite')->find($id);
        $nombrevu = $publicite->getVu();
        $publicite->setVu($nombrevu + 1);
        return $publicite->getVu();
    }

}

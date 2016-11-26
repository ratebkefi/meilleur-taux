<?php

namespace Admin\FrontendUserBundle\Controller;

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
use Admin\FrontendUserBundle\Document\FrontendUser;

class UtilisateurController extends FOSRestController
{

//Cette fonction retourne le document(entity) manager.
    private function getDocumentManager()
    {

        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    // retour de la liste des utilisateurs.   

    /**
     * Liste des utilisateurs.
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
    public function listerUtilisateursAction()
    {
        $em = $this->getDocumentManager();
        $utilisateur = $em->getRepository('AdminFrontendUserBundle:FrontendUser')->findAll();
        return $utilisateur;
    }

    /**
     *  afficher un utilisateur.
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
    public function afficherUtilisateurAction($id)
    {
        $em = $this->getDocumentManager();

        $utilisateur = $em->getRepository('AdminFrontendUserBundle:FrontendUser')->find($id);
        return $utilisateur;
    }

// Ajout Utilisateur.
    /**
     * Ajouter un utilisateur.
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
    public function ajouterUtilisateurAction(Request $request)
    {
        $em = $this->getDocumentManager();
        $groupe = $em->getRepository('AdminFrontendUserBundle:Groupe')->find($request->get('groupe'));
        $utilisateur = new FrontendUser();
        $utilisateur->setEmail($request->get('email'));
        $utilisateur->setPassword($request->get('pwd'));
        $utilisateur->setGroupe($groupe);
        $em->persist($utilisateur);
        $em->flush();
    }

// Modifier Utilisateur.
    /**
     * modifier un utilisateur.
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
    public function modifierUtilisateurAction(Request $request)
    {
        $dm = $this->getDocumentManager();
        $utilisateur = $dm->getRepository('AdminFrontendUserBundle:FrontendUser')->find($request->get('id'));
        $groupe = $dm->getRepository('AdminFrontendUserBundle:Groupe')->find($request->get('groupe'));
        $utilisateur->setUsername($request->get('username'));
        $utilisateur->setEmail($request->get('email'));
        $utilisateur->setPassword($request->get('password'));
        $utilisateur->setGroupe($groupe);
        $utilisateur->setEnabled($request->get('enabled'));
        $dm->persist($utilisateur);
        $dm->flush();
    }

    //Supprimer un utilisateur.
    /**
     * supprimer un utilisateur.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int $id the User id
     *
     * @return String
     */
    public function supprimerUtilisateurAction($id)
    {
        $em = $this->getDocumentManager();
        $utilisateur = $em->getRepository('AdminFrontendUserBundle:FrontendUser')->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('impssible de trouver l\'utilisateur.');
        }
        $em->remove($utilisateur);
        $em->flush();
    }

}

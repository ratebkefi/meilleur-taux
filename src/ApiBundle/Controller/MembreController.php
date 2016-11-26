<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Membre;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class MembreController extends FOSRestController
{

    /**
     * Afficher tous les Membres.
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
    public function listerMembreAction()
    {
        $dm = $this->getDocumentManager();
        $membres = $dm->getRepository('ApiBundle:Membre')->findAll();
        return $membres;
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
     * Supprimer un membre.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param int $id ID du membre
     *
     * @return String
     */
    public function supprimerMembreAction($id)
    {
        $dm = $this->getDocumentManager();
        $membre = $dm->getRepository('ApiBundle:Membre')->find($id);
        if (!$membre) {
            throw $this->createNotFoundException('Impossible de trouver le membre.');
        }
        $dm->remove($membre);
        $dm->flush();
        return "Membre Supprimé";
    }

    /**
     * Ajouter un nouveau membre.
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
    public function ajouterMembreAction(Request $request)
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
        $membre = new Membre();
        $dm = $this->getDocumentManager();
        $membre->setDateNaissance($request->get('date_naissance'));
        $membre->setEmail($request->get('email'));
        $membre->setEmploi($request->get('emploi'));
        $membre->setEtat($request->get('etat'));
        $membre->setNomPrenom($request->get('nom_prenom'));
        $membre->setPwd($request->get('pwd'));
        $membre->setSexe($request->get('sexe'));
        $membre->setSociete($request->get('societe'));
        $membre->setTel($request->get('tel'));
        $membre->setResumerQuotidien($request->get('resumer_quotidien'));
        $dm->persist($membre);
        $dm->flush();
        return "Membre ajouté";
    }

    /**
     * Modifier un membre.
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
    public function modifierMembreAction(Request $request)
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
        $membre = $dm->getRepository('ApiBundle:Membre')->find($request->get('id'));
        $membre->setDateNaissance($request->get('date_naissance'));
        $membre->setEmail($request->get('email'));
        $membre->setEmploi($request->get('emploi'));
        $membre->setEtat($request->get('etat'));
        $membre->setNomPrenom($request->get('nom_prenom'));
        $membre->setPwd($request->get('pwd'));
        $membre->setSexe($request->get('sexe'));
        $membre->setSociete($request->get('societe'));
        $membre->setTel($request->get('tel'));
        $membre->setResumerQuotidien($request->get('resumer_quotidien'));
        $dm->persist($membre);
        $dm->flush();
        return "Membre Modifié";
    }

    /**
     * Activer/desactiver Membre.
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
    public function activerDesactiverMembreAction($id)
    {
        $dm = $this->getDocumentManager();
        $membre = $dm->getRepository('ApiBundle:Membre')->find($id);
        if ($membre->getEtat() == true) {
            $membre->setEtat(false);
            $dm->persist($membre);
            $dm->flush();
            return "Membre désactivée";
        } else {
            $membre->setEtat(true);
            $dm->persist($membre);
            $dm->flush();
            return "Membre activée";
        }
    }

}

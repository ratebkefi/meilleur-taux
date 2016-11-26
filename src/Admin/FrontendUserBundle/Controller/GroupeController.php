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
use Admin\FrontendUserBundle\Document\Groupe;

class GroupeController extends FOSRestController
{

//Cette fonction retourne le document(entity) manager.
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    private function refactorRoles($originRoles)
    {
        $roles = array();
        $rolesAdded = array();
        // Add herited roles
        foreach ($originRoles as $roleParent => $rolesHerit) {
            $tmpRoles = array_values($rolesHerit);
            $rolesAdded = array_merge($rolesAdded, $tmpRoles);
            //$roles[$roleParent] = array_combine($tmpRoles, $tmpRoles);
        }
        return $rolesHerit;
    }
    // retour de la liste des Groupes.

    /**
     * Liste des roles.
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
    public function listerrolesAction()
    {
        $getRoles = array('roles' => $this->container->getParameter('security.role_hierarchy.roles'));
        $roles = $this->refactorRoles($getRoles);
        return $roles;
    }
    // retour de la liste des Groupes.   

    /**
     * Liste des Groupes.
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
    public function listerGroupesAction()
    {
        $em = $this->getDocumentManager();
        $groupe = $em->getRepository('AdminFrontendUserBundle:Groupe')->findAll();
        return $groupe;
    }

    /**
     *  afficher un groupe.
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
    public function afficherGroupeAction($id)
    {
        $em = $this->getDocumentManager();

        $groupe = $em->getRepository('AdminFrontendUserBundle:Groupe')->find($id);
        return $groupe;
    }

// Ajouter un Groupe.

    /**
     * Ajouter un Groupe.
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
    public function ajouterGroupeAction(Request $request)
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
        $params = json_decode($request->getContent(), true);
        $em = $this->getDocumentManager();
        $groupe = new Groupe();
        $groupe->setNom($params['nom']);
        $groupe->setRole($params['role']);
        $em->persist($groupe);
        $em->flush();
    }

// Modifier Groupe.

    /**
     * modifier un groupe.
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
    public function modifierGroupeAction(Request $request)
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
        $params = json_decode($request->getContent(), true);
        $em = $this->getDocumentManager();
        $groupe = $em->getRepository('AdminFrontendUserBundle:Groupe')->find($params['id']);
        $groupe->setNom($params['nom']);
        $groupe->setRole($params['role']);
        $em->persist($groupe);
        $em->flush();
    }

    //Supprimer Groupe.

    /**
     * supprimer un groupe.
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
    public function supprimerGroupeAction($id)
    {
        $em = $this->getDocumentManager();
        $groupe = $em->getRepository('AdminFrontendUserBundle:Groupe')->find($id);

        if (!$groupe) {
            throw $this->createNotFoundException('impssible de trouver groupe document.');
        }
        $em->remove($groupe);
        $em->flush();
    }

}

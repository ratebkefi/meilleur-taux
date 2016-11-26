<?php

namespace ApiBundle\Controller;

use ApiBundle\Document\Adsence;
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

class AdsenceController extends FOSRestController {

    /**
     * Afficher tous les Adsence.
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
    public function listerAdsenceAction() {

        $dm = $this->getDocumentManager();
        $adsenses = $dm->getRepository('ApiBundle:Adsence')->findAll();
        return $adsenses;
    }

    /**
     * Afficher une pub adsence.
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
    public function afficherAdsenceAction($id) {

        $dm = $this->getDocumentManager();
        $adsense = $dm->getRepository('ApiBundle:Adsence')->find($id);
        return $adsense;
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
     * Modifier une pub adsence.
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
    public function modifierAdsenceAction(Request $request) {
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
        $adsense = $dm->getRepository('ApiBundle:Adsence')->find($request->get('id'));
        $adsense->setEtat($request->get('etat'));
        $adsense->setCode($request->get('code'));
        $dm->persist($adsense);
        $dm->flush();
        return "Pub Adsense Modifiée";
    }


    /**
     * désactiver une pub adsence.
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
    public function activerDesactiverAdsenceAction($id) {
        $dm = $this->getDocumentManager();
        $adsense = $dm->getRepository('ApiBundle:Adsence')->find($id);
        if($adsense->getEtat())
        {
            $adsense->setEtat(false);
            $dm->persist($adsense);
            $dm->flush();
            return "Pub Adsense désactivée";
        }

        else
        {
            $adsense->setEtat(true);
            $dm->persist($adsense);
            $dm->flush();
            return "Pub Adsense activée";
        }

    }

}

<?php

namespace FrontBundle\Controller;

use ApiBundle\Document\Devise;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiBundle\Document\Change;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

class ChangeController extends Controller
{
    /**
     * Lister les dernier taux de chaque banque et de chaque devise.
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
     *
     * @return array
     */
    public function listAction(Request $request)
    {
        $em = $this->getDocumentManager();
        $banques = $em->getRepository('ApiBundle:Banque')->findAll();
        $devises = $em->getRepository('ApiBundle:Devise')->findAll();
        $changes = $em->getRepository('ApiBundle:Change')->derniertaux($banques, $devises);
        return $changes;
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
     * Simulateur de vente de dinar tunisien
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
     * @param integer $montant montant à vendre/acheter
     * @param boolean $operation vente = true/achat = false
     * @param Devise $devise
     *
     * @return array
     */
    public function simulateurAction($montant, $operation, $devise_id)
    {
        $em = $this->getDocumentManager();
        $banques = $em->getRepository('ApiBundle:Banque')->findAll();
        $devise = $em->getRepository('ApiBundle:Devise')->find($devise_id)->getSigle();
        if ($devise == null) {
            return 'Devise introuvable';
        }
        $changes = $em->getRepository('ApiBundle:Change')->derniertauxdevise($banques, $devise_id);
        //var_dump($changes);exit;
        //var_dump($devise);exit;
        $tab = array();
        //si on VEND du dinar tunisien ==> on utilise le taux d'ACHAT de la banque
        if ($operation == 'true') {
            foreach ($changes as $key => $value) {
                $achat = $value->getTauxAchat();
                $banque = $value->getBanque()->getRaisonSocial();
                $resultat = $montant * $achat;
                $tan2 = array($resultat, $banque, $devise);
                $tabfinal = array_push($tab, $tan2);
            }

            //Trier le tableau en ordre décroissant! La première valeur est la plus grande et donc la meilleure
            rsort($tab);
        } //si on ACHETE ==> on utilise le taux de VENTE de la banque
        else
            if ($operation == 'false') {
                foreach ($changes as $key => $value) {
                    $vente = $value->getTauxVente();
                    $banque = $value->getBanque()->getRaisonSocial();
                    $resultat = $montant * $vente;
                    $tan2 = array($resultat, $banque, $devise);
                    $tabfinal = array_push($tab, $tan2);
                }
                //Trier le tableau en ordre décroissant! La première valeur est la plus grande et donc la meilleure
                rsort($tab);
            } else {
                return 'Erreur d\'opération';
            }
        // Retourne un tableau trié décroissant , chaque case contenant la banque,
        //le resultat du montant à changer et le sigle de la devise
        return $tab;
    }

}

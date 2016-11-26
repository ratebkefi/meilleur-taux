<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use ApiBundle\Document\Banque;
use ApiBundle\Document\Devise;
/**
 * ApiBundle\Document\Change
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\ChangeRepository"
 * )
 * @ExclusionPolicy("all")
 * */
class Change {

    /**
     * @var MongoId $id
     * @ODM\Id(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @var date $date_time
     *
     * @ODM\Field(name="date_time", type="date")
     * @Expose
     */
    protected $date_time;

    /**
     * @var float $taux_achat
     *
     * @ODM\Field(name="taux_achat", type="float")
     * @Expose
     */
    protected $taux_achat;

    /**
     * @var float $taux_vente
     *
     * @ODM\Field(name="taux_vente", type="float")
     * @Expose
     */
    protected $taux_vente;

    /**
     * @var boolean $type
     *
     * @ODM\Field(name="type", type="boolean")
     * @Expose

     */
    protected $type;

    /**
     * Set banque
     *
     * @param ApiBundle\Document\Banque $banque
     * @return self
     */

    /** @ODM\ReferenceOne(targetDocument="Banque", inversedBy="change")
     * @Expose
     */
    private $banque;

    /** @ODM\ReferenceOne(targetDocument="Devise", inversedBy="change")
     * @Expose

     */
    private $devise;

    public function setBanque(\ApiBundle\Document\Banque $banque) {
        $this->banque = $banque;
        return $this;
    }

    /**
     * Get banque
     *
     * @return ApiBundle\Document\Banque $banque
     */
    public function getBanque() {
        return $this->banque;
    }

    /**
     * Set devise
     *
     * @param ApiBundle\Document\Devise $devise
     * @return self
     */
    public function setDevise(\ApiBundle\Document\Devise $devise) {
        $this->devise = $devise;
        return $this;
    }

    /**
     * Get devise
     *
     * @return ApiBundle\Document\Devise $devise
     */
    public function getDevise() {
        return $this->devise;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateTime
     *
     * @param date $dateTime
     * @return self
     */
    public function setDateTime($dateTime) {
        $this->date_time = $dateTime;
        return $this;
    }

    /**
     * Get dateTime
     *
     * @return date $dateTime
     */
    public function getDateTime() {
        return $this->date_time;
    }

    /**
     * Set tauxAchat
     *
     * @param float $tauxAchat
     * @return self
     */
    public function setTauxAchat($tauxAchat) {
        $this->taux_achat = $tauxAchat;
        return $this;
    }

    /**
     * Get tauxAchat
     *
     * @return float $tauxAchat
     */
    public function getTauxAchat() {
        return $this->taux_achat;
    }

    /**
     * Set tauxVente
     *
     * @param float $tauxVente
     * @return self
     */
    public function setTauxVente($tauxVente) {
        $this->taux_vente = $tauxVente;
        return $this;
    }

    /**
     * Get tauxVente
     *
     * @return float $tauxVente
     */
    public function getTauxVente() {
        return $this->taux_vente;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return self
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean $type
     */
    public function getType() {
        return $this->type;
    }

}

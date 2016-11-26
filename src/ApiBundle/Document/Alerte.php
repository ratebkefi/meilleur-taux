<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Alerte
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\AlerteRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Alerte {

    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean type
     *
     * @ODM\Field(name="type", type="boolean")
     */
    protected $type;

    /**
     * @var string $equation
     *
     * @ODM\Field(name="equation", type="string")
     */
    protected $equation;

    /**
     * @var float $valeur
     *
     * @ODM\Field(name="valeur", type="float")
     */
    protected $valeur;

    /** @ODM\ReferenceOne(targetDocument="Membre", inversedBy="alerte") */
    private $membre;

    /** @ODM\ReferenceOne(targetDocument="Devise", inversedBy="alerte") */
    private $devise;

    /**
     * Set membre
     *
     * @param ApiBundle\Document\Membre $membre
     * @return self
     */
    public function setMembre(\ApiBundle\Document\Membre $membre) {
        $this->membre = $membre;
        return $this;
    }

    /**
     * Get membre
     *
     * @return ApiBundle\Document\Membre $membre
     */
    public function getMembre() {
        return $this->membre;
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

    /**
     * Set equation
     *
     * @param string $equation
     * @return self
     */
    public function setEquation($equation) {
        $this->equation = $equation;
        return $this;
    }

    /**
     * Get equation
     *
     * @return string $equation
     */
    public function getEquation() {
        return $this->equation;
    }

    /**
     * Set valeur
     *
     * @param float $valeur
     * @return self
     */
    public function setValeur($valeur) {
        $this->valeur = $valeur;
        return $this;
    }

    /**
     * Get valeur
     *
     * @return float $valeur
     */
    public function getValeur() {
        return $this->valeur;
    }

}

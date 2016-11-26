<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Adsence
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\AdsenceRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Adsence
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $etat
     *
     * @ODM\Field(name="etat", type="boolean")
     */
    protected $etat;

    /**
     * @var string $nom
     *
     * @ODM\Field(name="nom", type="string")
     */
    protected $nom;

    /**
     * @var string $code
     *
     * @ODM\Field(name="code", type="string")
     */
    protected $code;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return self
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean $etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get nom
     *
     * @return string $nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }
}

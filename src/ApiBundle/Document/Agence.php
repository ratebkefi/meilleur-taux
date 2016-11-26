<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Agence
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\AgenceRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Agence {

    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nom
     *
     * @ODM\Field(name="nom", type="string")
     */
    protected $nom;

    /**
     * @var string $adresse
     *
     * @ODM\Field(name="adresse", type="string")
     */
    protected $adresse;

    /**
     * @var integer $tel
     *
     * @ODM\Field(name="tel", type="integer")
     */
    protected $tel;

    /**
     * @var integer $fax
     *
     * @ODM\Field(name="fax", type="integer")
     */
    protected $fax;

    /**
     * @var string $latitude
     *
     * @ODM\Field(name="latitude", type="string")
     */
    protected $latitude;

    /**
     * @var string $longitude
     *
     * @ODM\Field(name="longitude", type="string")
     */
    protected $longitude;

    /**
     * @var boolean $type
     *
     * @ODM\Field(name="type", type="boolean")
     */
    protected $type;

    /** @ODM\ReferenceOne(targetDocument="Banque", inversedBy="agence") */
    private $banque;


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
     * Set adresse
     *
     * @param string $adresse
     * @return self
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string $adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     * @return self
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
    }

    /**
     * Get tel
     *
     * @return integer $tel
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set fax
     *
     * @param integer $fax
     * @return self
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * Get fax
     *
     * @return integer $fax
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return self
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return self
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set banque
     *
     * @param ApiBundle\Document\Banque $banque
     * @return self
     */
    public function setBanque(\ApiBundle\Document\Banque $banque)
    {
        $this->banque = $banque;
        return $this;
    }

    /**
     * Get banque
     *
     * @return ApiBundle\Document\Banque $banque
     */
    public function getBanque()
    {
        return $this->banque;
    }
}

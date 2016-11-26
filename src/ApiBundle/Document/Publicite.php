<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Publicite
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\PubliciteRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Publicite {

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
     * @var string $photo
     *a
     * @ODM\Field(name="photo", type="string")
     */
    protected $photo;

    /**
     * @var integer $type
     *
     * @ODM\Field(name="type", type="integer")
     */
    protected $type;

    /**
     * @var integer $max_vu
     *
     * @ODM\Field(name="max_vu", type="integer")
     */
    protected $max_vu;

    /**
     * @var integer $max_click
     *
     * @ODM\Field(name="max_click", type="integer")
     */
    protected $max_click;

    /**
     * @var integer $vu
     *
     * @ODM\Field(name="vu", type="integer")
     */
    protected $vu;

    /**
     * @var integer $click
     *
     * @ODM\Field(name="click", type="integer")
     */
    protected $click;

    /**
     * @var string $url
     *
     * @ODM\Field(name="url", type="string")
     */
    protected $url;

    /**
     * @var boolean $url_blanck
     *
     * @ODM\Field(name="url_blanck", type="boolean")
     */
    protected $url_blanck;

    /**
     * @var boolean $etat
     *
     * @ODM\Field(name="etat", type="boolean")
     */
    protected $etat;

    /**
     * @var date $date_debut
     *
     * @ODM\Field(name="date_debut", type="date")
     */
    protected $date_debut;

    /**
     * @var date $date_fin
     *
     * @ODM\Field(name="date_fin", type="date")
     */
    protected $date_fin;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return self
     */
    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get nom
     *
     * @return string $nom
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return self
     */
    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Get photo
     *
     * @return string $photo
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return self
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return integer $type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set maxVu
     *
     * @param integer $maxVu
     * @return self
     */
    public function setMaxVu($maxVu) {
        $this->max_vu = $maxVu;
        return $this;
    }

    /**
     * Get maxVu
     *
     * @return integer $maxVu
     */
    public function getMaxVu() {
        return $this->max_vu;
    }

    /**
     * Set maxClick
     *
     * @param integer $maxClick
     * @return self
     */
    public function setMaxClick($maxClick) {
        $this->max_click = $maxClick;
        return $this;
    }

    /**
     * Get maxClick
     *
     * @return integer $maxClick
     */
    public function getMaxClick() {
        return $this->max_click;
    }

    /**
     * Set vu
     *
     * @param integer $vu
     * @return self
     */
    public function setVu($vu) {
        $this->vu = $vu;
        return $this;
    }

    /**
     * Get vu
     *
     * @return integer $vu
     */
    public function getVu() {
        return $this->vu;
    }

    /**
     * Set click
     *
     * @param integer $click
     * @return self
     */
    public function setClick($click) {
        $this->click = $click;
        return $this;
    }

    /**
     * Get click
     *
     * @return integer $click
     */
    public function getClick() {
        return $this->click;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return self
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set urlBlanck
     *
     * @param boolean $urlBlanck
     * @return self
     */
    public function setUrlBlanck($urlBlanck) {
        $this->url_blanck = $urlBlanck;
        return $this;
    }

    /**
     * Get urlBlanck
     *
     * @return boolean $urlBlanck
     */
    public function getUrlBlanck() {
        return $this->url_blanck;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return self
     */
    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean $etat
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Set dateDebut
     *
     * @param date $dateDebut
     * @return self
     */
    public function setDateDebut($dateDebut) {
        $this->date_debut = $dateDebut;
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return date $dateDebut
     */
    public function getDateDebut() {
        return $this->date_debut;
    }

    /**
     * Set dateFin
     *
     * @param date $dateFin
     * @return self
     */
    public function setDateFin($dateFin) {
        $this->date_fin = $dateFin;
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return date $dateFin
     */
    public function getDateFin() {
        return $this->date_fin;
    }

}

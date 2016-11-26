<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * ApiBundle\Document\Banque
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\BanqueRepository"
 * )
 * @ExclusionPolicy("all")
 */
class Banque
{

    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @var string $raison_social
     *
     * @ODM\Field(name="raison_social", type="string")
     * @Expose
     */
    protected $raison_social;

    /**
     * @var integer $capital
     *
     * @ODM\Field(name="capital", type="integer")
     * @Expose
     */
    protected $capital;

    /**
     * @var string $adresse
     *
     * @ODM\Field(name="adresse", type="string")
     * @Expose
     */
    protected $adresse;

    /**
     * @var integer $tel
     *
     * @ODM\Field(name="tel", type="integer")
     * @Expose
     */
    protected $tel;

    /**
     * @var integer $tel2
     *
     * @ODM\Field(name="tel2", type="integer")
     * @Expose
     */
    protected $tel2;

    /**
     * @var integer $fax
     *
     * @ODM\Field(name="fax", type="integer")
     * @Expose
     */
    protected $fax;

    /**
     * @var string $site_web
     *
     * @ODM\Field(name="site_web", type="string")
     * @Expose
     */
    protected $site_web;

    /**
     * @var string $email
     *
     * @ODM\Field(name="email", type="string")
     * @Expose
     */
    protected $email;

    /**
     * @var string $logo
     *
     * @ODM\Field(name="logo", type="string")
     * @Expose
     */
    protected $logo;

    /**
     * @var string $remarque
     *
     * @ODM\Field(name="remarque", type="string")
     * @Expose
     */
    protected $remarque;

    /**
     * @var boolean $offshore
     *
     * @ODM\Field(name="offshore", type="boolean")
     * @Expose
     */
    protected $offshore;

    /**
     * @var boolean $centrale
     *
     * @ODM\Field(name="centrale", type="boolean")
     * @Expose
     */
    protected $centrale;

    /**
     * @var string $url_devise
     *
     * @ODM\Field(name="url_devise", type="string")
     * @Expose
     */
    private $url_devise;

    /** @ODM\ReferenceMany(targetDocument="Change", mappedBy="banque", cascade={"remove"}) */
    private $change;

    /** @ODM\ReferenceMany(targetDocument="Agence", mappedBy="banque", cascade={"remove"}) */
    private $agence;

    public function __toString()
    {
        return $this->raison_social;
    }

    public function __construct()
    {
        $this->change = new \Doctrine\Common\Collections\ArrayCollection();
        $this->agence = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set raisonSocial
     *
     * @param string $raisonSocial
     * @return self
     */
    public function setRaisonSocial($raisonSocial)
    {
        $this->raison_social = $raisonSocial;
        return $this;
    }

    /**
     * Get raisonSocial
     *
     * @return string $raisonSocial
     */
    public function getRaisonSocial()
    {
        return $this->raison_social;
    }

    /**
     * Set capital
     *
     * @param integer $capital
     * @return self
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;
        return $this;
    }

    /**
     * Get capital
     *
     * @return integer $capital
     */
    public function getCapital()
    {
        return $this->capital;
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
     * Set tel2
     *
     * @param integer $tel2
     * @return self
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;
        return $this;
    }

    /**
     * Get tel2
     *
     * @return integer $tel2
     */
    public function getTel2()
    {
        return $this->tel2;
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
     * Set siteWeb
     *
     * @param string $siteWeb
     * @return self
     */
    public function setSiteWeb($siteWeb)
    {
        $this->site_web = $siteWeb;
        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string $siteWeb
     */
    public function getSiteWeb()
    {
        return $this->site_web;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return self
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * Get logo
     *
     * @return string $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     * @return self
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;
        return $this;
    }

    /**
     * Get remarque
     *
     * @return string $remarque
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * Set offshore
     *
     * @param boolean $offshore
     * @return self
     */
    public function setOffshore($offshore)
    {
        $this->offshore = $offshore;
        return $this;
    }

    /**
     * Get offshore
     *
     * @return boolean $offshore
     */
    public function getOffshore()
    {
        return $this->offshore;
    }

    /**
     * Set centrale
     *
     * @param boolean $centrale
     * @return self
     */
    public function setCentrale($centrale)
    {
        $this->centrale = $centrale;
        return $this;
    }

    /**
     * Get centrale
     *
     * @return boolean $centrale
     */
    public function getCentrale()
    {
        return $this->centrale;
    }

    /**
     * Set urlDevise
     *
     * @param string $urlDevise
     * @return self
     */
    public function setUrlDevise($urlDevise)
    {
        $this->url_devise = $urlDevise;
        return $this;
    }

    /**
     * Get urlDevise
     *
     * @return string $urlDevise
     */
    public function getUrlDevise()
    {
        return $this->url_devise;
    }

    /**
     * Add change
     *
     * @param ApiBundle\Document\Change $change
     */
    public function addChange(\ApiBundle\Document\Change $change)
    {
        $this->change[] = $change;
    }

    /**
     * Remove change
     *
     * @param ApiBundle\Document\Change $change
     */
    public function removeChange(\ApiBundle\Document\Change $change)
    {
        $this->change->removeElement($change);
    }

    /**
     * Get change
     *
     * @return \Doctrine\Common\Collections\Collection $change
     */
    public function getChange()
    {
        return $this->change;
    }

    /**
     * Add agence
     *
     * @param ApiBundle\Document\Agence $agence
     */
    public function addAgence(\ApiBundle\Document\Agence $agence)
    {
        $this->agence[] = $agence;
    }

    /**
     * Remove agence
     *
     * @param ApiBundle\Document\Agence $agence
     */
    public function removeAgence(\ApiBundle\Document\Agence $agence)
    {
        $this->agence->removeElement($agence);
    }

    /**
     * Get agence
     *
     * @return \Doctrine\Common\Collections\Collection $agence
     */
    public function getAgence()
    {
        return $this->agence;
    }
}

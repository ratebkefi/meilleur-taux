<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Membre
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\MembreRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Membre {

    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nom_prenom
     *
     * @ODM\Field(name="nom_prenom", type="string")
     */
    protected $nom_prenom;

    /**
     * @var string $email
     *
     * @ODM\Field(name="email", type="string")
     */
    protected $email;

    /**
     * @var string $pwd
     *
     * @ODM\Field(name="pwd", type="string")
     */
    protected $pwd;

    /**
     * @var boolean $sexe
     *
     * @ODM\Field(name="sexe", type="boolean")
     */
    protected $sexe;

    /**
     * @var date $date_naissance
     *
     * @ODM\Field(name="date_naissance", type="date")
     */
    protected $date_naissance;

    /**
     * @var integer $tel
     *
     * @ODM\Field(name="tel", type="integer")
     */
    protected $tel;

    /**
     * @var string $societe
     *
     * @ODM\Field(name="societe", type="string")
     */
    protected $societe;

    /**
     * @var string $emploi
     *
     * @ODM\Field(name="emploi", type="string")
     */
    protected $emploi;

    /**
     * @var boolean $etat
     *
     * @ODM\Field(name="etat", type="boolean")
     */
    protected $etat;

    /**
     * @var boolean $resumer_quotidien
     *
     * @ODM\Field(name="resumer_quotidien", type="boolean")
     */
    protected $resumer_quotidien;

    /** @ODM\ReferenceMany(targetDocument="Alerte", mappedBy="membre", cascade={"persist", "remove"}) */
    private $alerte;

   
    public function __construct()
    {
        $this->alerte = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nomPrenom
     *
     * @param string $nomPrenom
     * @return self
     */
    public function setNomPrenom($nomPrenom)
    {
        $this->nom_prenom = $nomPrenom;
        return $this;
    }

    /**
     * Get nomPrenom
     *
     * @return string $nomPrenom
     */
    public function getNomPrenom()
    {
        return $this->nom_prenom;
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
     * Set pwd
     *
     * @param string $pwd
     * @return self
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
        return $this;
    }

    /**
     * Get pwd
     *
     * @return string $pwd
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return self
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean $sexe
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param date $dateNaissance
     * @return self
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->date_naissance = $dateNaissance;
        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return date $dateNaissance
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
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
     * Set societe
     *
     * @param string $societe
     * @return self
     */
    public function setSociete($societe)
    {
        $this->societe = $societe;
        return $this;
    }

    /**
     * Get societe
     *
     * @return string $societe
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set emploi
     *
     * @param string $emploi
     * @return self
     */
    public function setEmploi($emploi)
    {
        $this->emploi = $emploi;
        return $this;
    }

    /**
     * Get emploi
     *
     * @return string $emploi
     */
    public function getEmploi()
    {
        return $this->emploi;
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
     * Set resumerQuotidien
     *
     * @param boolean $resumerQuotidien
     * @return self
     */
    public function setResumerQuotidien($resumerQuotidien)
    {
        $this->resumer_quotidien = $resumerQuotidien;
        return $this;
    }

    /**
     * Get resumerQuotidien
     *
     * @return boolean $resumerQuotidien
     */
    public function getResumerQuotidien()
    {
        return $this->resumer_quotidien;
    }

    /**
     * Add alerte
     *
     * @param ApiBundle\Document\Alerte $alerte
     */
    public function addAlerte(\ApiBundle\Document\Alerte $alerte)
    {
        $this->alerte[] = $alerte;
    }

    /**
     * Remove alerte
     *
     * @param ApiBundle\Document\Alerte $alerte
     */
    public function removeAlerte(\ApiBundle\Document\Alerte $alerte)
    {
        $this->alerte->removeElement($alerte);
    }

    /**
     * Get alerte
     *
     * @return \Doctrine\Common\Collections\Collection $alerte
     */
    public function getAlerte()
    {
        return $this->alerte;
    }
}

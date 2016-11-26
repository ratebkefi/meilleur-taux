<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * ApiBundle\Document\Devise
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\DeviseRepository"
 * )
 * @ExclusionPolicy("all")
 */
class Devise {

    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @var string $code_iso
     *
     * @ODM\Field(name="code_iso", type="string")
     * @Expose
     */
    protected $code_iso;

    /**
     * @var string $nom
     *
     * @ODM\Field(name="nom", type="string")
     * @Expose
     */
    protected $nom;

    /**
     * @var string $sigle
     *
     * @ODM\Field(name="sigle", type="string")
     * @Expose
     */
    protected $sigle;

    /**
     * @var integer $unite
     *
     * @ODM\Field(name="unite", type="integer")
     * @Expose
     */
    protected $unite;

    /**
     * @var string $icone
     *
     * @ODM\Field(name="icone", type="string")
     */
    protected $icone;

    /** @ODM\ReferenceMany(targetDocument="Change", mappedBy="devise", cascade={"remove"}) */
    private $change;

    /** @ODM\ReferenceMany(targetDocument="Alerte", mappedBy="devise", cascade={"remove"}) */
    private $alerte;

    public function __toString()
    {
        return $this->nom;
    }
    public function __construct()
    {
        $this->change = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codeIso
     *
     * @param string $codeIso
     * @return self
     */
    public function setCodeIso($codeIso)
    {
        $this->code_iso = $codeIso;
        return $this;
    }

    /**
     * Get codeIso
     *
     * @return string $codeIso
     */
    public function getCodeIso()
    {
        return $this->code_iso;
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
     * Set sigle
     *
     * @param string $sigle
     * @return self
     */
    public function setSigle($sigle)
    {
        $this->sigle = $sigle;
        return $this;
    }

    /**
     * Get sigle
     *
     * @return string $sigle
     */
    public function getSigle()
    {
        return $this->sigle;
    }

    /**
     * Set unite
     *
     * @param integer $unite
     * @return self
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
        return $this;
    }

    /**
     * Get unite
     *
     * @return integer $unite
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * Set icone
     *
     * @param string $icone
     * @return self
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
        return $this;
    }

    /**
     * Get icone
     *
     * @return string $icone
     */
    public function getIcone()
    {
        return $this->icone;
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

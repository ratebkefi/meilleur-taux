<?php

namespace Admin\FrontendUserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Admin\FrontendUserBundle\Document\Groupe
 *
 * @ODM\Document(
 *     repositoryClass="Admin\FrontendUserBundle\Document\GroupeRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Groupe
{
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
     * @var collection $role
     *
     * @ODM\Field(name="role", type="collection")
     */
    protected $role;

    /** @ODM\ReferenceMany(targetDocument="FrontendUser",mappedBy="groupe")
     *
     */
    private $utilisateur;
    public function __construct()
    {
        $this->utilisateur = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set role
     *
     * @param collection $role
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role
     *
     * @return collection $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add utilisateur
     *
     * @param Admin\FrontendUserBundle\Document\FrontendUser $utilisateur
     */
    public function addUtilisateur(\Admin\FrontendUserBundle\Document\FrontendUser $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;
    }

    /**
     * Remove utilisateur
     *
     * @param Admin\FrontendUserBundle\Document\FrontendUser $utilisateur
     */
    public function removeUtilisateur(\Admin\FrontendUserBundle\Document\FrontendUser $utilisateur)
    {
        $this->utilisateur->removeElement($utilisateur);
    }

    /**
     * Get utilisateur
     *
     * @return \Doctrine\Common\Collections\Collection $utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}

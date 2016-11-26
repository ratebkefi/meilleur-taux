<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Menu
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\MenuRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Menu
{

    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $type
     *
     * @ODM\Field(name="type", type="integer")
     */
    protected $type;

    /**
     * @var boolean $titre
     *
     * @ODM\Field(name="titre", type="string")
     */
    protected $titre;

    /** @ODM\ReferenceOne(targetDocument="Pages", inversedBy="menu") */
    private $pages;

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
     * Set type
     *
     * @param integer $type
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
     * @return integer $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return self
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * Get titre
     *
     * @return string $titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set pages
     *
     * @param ApiBundle\Document\Pages $pages
     * @return self
     */
    public function setPages(\ApiBundle\Document\Pages $pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Get pages
     *
     * @return ApiBundle\Document\Pages $pages
     */
    public function getPages()
    {
        return $this->pages;
    }
}

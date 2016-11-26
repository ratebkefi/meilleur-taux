<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Pages
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\PagesRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Pages {

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
     * @var string $text
     *
     * @ODM\Field(name="text", type="string")
     */
    protected $text;

    /**
     * @var string $bal_titre
     *
     * @ODM\Field(name="bal_titre", type="string")
     */
    protected $bal_titre;

    /**
     * @var string $bal_desc
     *
     * @ODM\Field(name="bal_desc", type="string")
     */
    protected $bal_desc;

    /**
     * @var string $url
     *
     * @ODM\Field(name="url", type="string")
     */
    protected $url;

    /** @ODM\ReferenceMany(targetDocument="Menu", mappedBy="pages", cascade={"persist", "remove"}) */
    private $menu;

    public function __construct()
    {
        $this->menu = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set text
     *
     * @param string $text
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set balTitre
     *
     * @param string $balTitre
     * @return self
     */
    public function setBalTitre($balTitre)
    {
        $this->bal_titre = $balTitre;
        return $this;
    }

    /**
     * Get balTitre
     *
     * @return string $balTitre
     */
    public function getBalTitre()
    {
        return $this->bal_titre;
    }

    /**
     * Set balDesc
     *
     * @param string $balDesc
     * @return self
     */
    public function setBalDesc($balDesc)
    {
        $this->bal_desc = $balDesc;
        return $this;
    }

    /**
     * Get balDesc
     *
     * @return string $balDesc
     */
    public function getBalDesc()
    {
        return $this->bal_desc;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add menu
     *
     * @param ApiBundle\Document\Menu $menu
     */
    public function addMenu(\ApiBundle\Document\Menu $menu)
    {
        $this->menu[] = $menu;
    }

    /**
     * Remove menu
     *
     * @param ApiBundle\Document\Menu $menu
     */
    public function removeMenu(\ApiBundle\Document\Menu $menu)
    {
        $this->menu->removeElement($menu);
    }

    /**
     * Get menu
     *
     * @return \Doctrine\Common\Collections\Collection $menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}

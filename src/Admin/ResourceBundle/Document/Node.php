<?php

/*
 * This file is part of the Admin package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\ResourceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

use Admin\ResourceBundle\Domain\IdTrait;
use Admin\ResourceBundle\Domain\LocaleTrait;
use Admin\ResourceBundle\Domain\TitleTrait;
use Admin\ResourceBundle\Domain\StatusTrait;
use Admin\ResourceBundle\Domain\UpdateCreateTrait;
use Admin\ResourceBundle\Document\NodeInterface;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
abstract class Node implements NodeInterface
{

    use IdTrait;
    use UpdateCreateTrait;
    use LocaleTrait;
    use TitleTrait;
    use StatusTrait;

    /**
     * @ODM\ReferenceOne(targetDocument="Admin\ResourceBundle\Document\Node", inversedBy="children")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("Admin\ResourceBundle\Document\Node")
     */
    protected $parent = null;

    /**
     * @ODM\ReferenceMany(targetDocument="Admin\ResourceBundle\Document\Node", mappedBy="parent")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<Admin\ResourceBundle\Document\Node>")
     */
    protected $children = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Add children
     *
     * @param  Node $children
     * @return Node
     */
    public function addChild($children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Node $children
     */
    public function removeChild($children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param  Node $parent
     * @return Node
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Node
     */
    public function getParent()
    {
        return $this->parent;
    }

}

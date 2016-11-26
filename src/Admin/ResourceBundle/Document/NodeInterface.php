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

/**
 * NodeInterface
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
interface NodeInterface
{

    /**
     * Set metaUrl
     *
     * @param $parent
     */
    public function setParent($parent);

    /**
     * Get Parent
     */
    public function getParent();

    /**
     * Get Children
     */
    public function getChildren();

    /**
     * Add children
     *
     * @param  $child
     */
    public function addChild($child);

    /**
     * Remove children
     *
     * @param $child
     */
    public function removeChild($child);


}

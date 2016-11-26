<?php

/*
 * This file is part of the Admin package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\FrontendUserBundle\Document;

use Admin\ResourceBundle\Repository\CollectionRepository;

/**
 * Frontend user repository
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class FrontendUserRepository extends CollectionRepository
{
    protected $model = 'AdminFrontendUserBundle:FrontendUser';

}

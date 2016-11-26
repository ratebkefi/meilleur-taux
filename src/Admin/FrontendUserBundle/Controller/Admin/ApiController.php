<?php

/*
 * This file is part of the Admin package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\FrontendUserBundle\Controller\Admin;

use Admin\ResourceBundle\Controller\ApiController as BaseApiController;

/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends BaseApiController
{

    /**
     * @var string
     */
    protected $model = "Admin\FrontendUserBundle\Document\FrontendUser";

}

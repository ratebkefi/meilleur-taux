<?php

/*
 * This file is part of the Admin package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Admin\FrontendUserBundle\Controller;

use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\Admin\FrontendUserBundle\Controller\ApiController');
    }

}

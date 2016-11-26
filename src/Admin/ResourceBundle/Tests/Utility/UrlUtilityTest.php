<?php

/*
 * This file is part of the Admin package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\ResourceBundle\Tests\Utility;

use Admin\ResourceBundle\Utility\UrlUtility;
use Admin\ResourceBundle\Tests\AbstractKernelTestCase;

/**
 * UrlUtilityTest
 */
class UrlUtilityTest extends AbstractKernelTestCase
{

    /**
     * testUrlUtiliry
     */
    public function testUrlUtiliry()
    {
        $url = 'текст урл на русском с пробелами';
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        $this->assertEquals('tekst-url-na-russkom-s-probelami', $validUrl);
    }

}

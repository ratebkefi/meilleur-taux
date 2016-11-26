<?php

namespace Admin\ResourceBundle\Tests;

/**
 * Class AbstractBackendWebTestCase.
 *
 */
abstract class AbstractBackendWebTestCase extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->logInBackend();
    }

}

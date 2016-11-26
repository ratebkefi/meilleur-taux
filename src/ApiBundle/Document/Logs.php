<?php

namespace ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * ApiBundle\Document\Logs
 *
 * @ODM\Document(
 *     repositoryClass="ApiBundle\Document\LogsRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Logs
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $data
     *
     * @ODM\Field(name="data", type="string")
     */
    protected $data;

    /**
     * @var date $dcr
     *
     * @ODM\Field(name="dcr", type="date")
     */
    protected $dcr;


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
     * Set data
     *
     * @param string $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return string $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set dcr
     *
     * @param date $dcr
     * @return self
     */
    public function setDcr($dcr)
    {
        $this->dcr = $dcr;
        return $this;
    }

    /**
     * Get dcr
     *
     * @return date $dcr
     */
    public function getDcr()
    {
        return $this->dcr;
    }
}

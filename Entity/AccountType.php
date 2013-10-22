<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * AccountType
 *
 * @ORM\Table(name="acc_account_types")
 * @ORM\Entity()
 *
 * @Serializer\ExclusionPolicy("all")
 *
 */
class AccountType
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     *
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1)
     *
     * @Serializer\Expose
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="Account", mappedBy="type")
     */
    private $accounts;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

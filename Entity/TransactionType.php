<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TransactionType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TransactionTypeRepository")
 */
class TransactionType
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isAdjustment = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPositive = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="transactionType")
     */
    protected $transactions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}

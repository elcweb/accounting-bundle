<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entry
 *
 * @ORM\Table
 * @ORM\Entity()
 *
 */
class Entry
{
    /**
     * @var integer
     *
     * @ORM\Column( type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Transaction", inversedBy="entries")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $transaction;

    /**
     * @var \DateTime
     * @ORM\Column( type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="entries")
     * @ORM\JoinColumn( referencedColumnName="id", nullable=false)
     */
    protected $account;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $comment;

}
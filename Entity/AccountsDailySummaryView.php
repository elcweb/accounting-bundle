<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 *
 * @ORM\Table(name="view_AccountsDailySummary",uniqueConstraints={@ORM\UniqueConstraint(columns={"account_id", "day"})})
 * @ORM\Entity(readOnly=true)
 */
class AccountsDailySummaryView
{

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     * @ORM\Id
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="dailySummary")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     * @Serializer\Expose
     */
    private $account;

    /**
     * @var \DateTime
     * @ORM\Column( type="date", nullable=false)
     * @Serializer\Expose
     */
    private $day;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2)
     */
    private $total;


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get account
     *
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}

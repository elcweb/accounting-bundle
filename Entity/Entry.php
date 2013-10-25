<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entry
 *
 * @ORM\Table(name="acc_entries")
 * @ORM\Entity(repositoryClass="EntryRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Entry
{
    /**
     * @var integer
     *
     * @ORM\Column( type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Transaction", inversedBy="entries", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $transaction;

    /**
     * @var \DateTime
     * @ORM\Column( type="datetime")
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Expose
     */
    protected $createdAt;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="entries")
     * @ORM\JoinColumn( referencedColumnName="id", nullable=false)
     *
     * @Serializer\Expose
     */
    protected $account;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Serializer\Expose
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Expose
     */
    protected $comment;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Entry
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Entry
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Entry
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set transaction
     *
     * @param \Elcweb\AccountingBundle\Entity\Transaction $transaction
     * @return Entry
     */
    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \Elcweb\AccountingBundle\Entity\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set account
     *
     * @param \Elcweb\AccountingBundle\Entity\Account $account
     * @return Entry
     */
    public function setAccount(Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Elcweb\AccountingBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $this->transaction = null;
        }
    }
}

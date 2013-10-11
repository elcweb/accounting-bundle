<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Transaction
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="TransactionRepository")
 *
 */
class Transaction
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
     * @ORM\ManyToOne(targetEntity="TransactionType", inversedBy="transactions", fetch="EAGER")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $transactionType;


    /**
     * @var \DateTime
     * @ORM\Column( type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column( type="date")
     * @Gedmo\Timestampable(on="create")
     */
    protected $debitDate;

    /**
     * @var Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction", inversedBy="childrens")
     * @ORM\JoinColumn( referencedColumnName="id",onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    protected $comment;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="parent")
     */
    protected $childrens;

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
     * @return Transaction
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
     * Set debitDate
     *
     * @param \DateTime $debitDate
     * @return Transaction
     */
    public function setDebitDate($debitDate)
    {
        $this->debitDate = $debitDate;

        return $this;
    }

    /**
     * Get debitDate
     *
     * @return \DateTime
     */
    public function getDebitDate()
    {
        return $this->debitDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Transaction
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
     * Set transactionType
     *
     * @param TransactionType $transactionType
     * @return Transaction
     */
    public function setTransactionType(TransactionType $transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get transactionType
     *
     * @return TransactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Set parent
     *
     * @param Transaction $parent
     * @return Transaction
     */
    public function setParent(Transaction $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Transaction
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return '' . $this->getId() . '';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childrens = new ArrayCollection();
    }

    /**
     * Add childrens
     *
     * @param Transaction $childrens
     * @return Transaction
     */
    public function addChildren(Transaction $childrens)
    {
        $this->childrens[] = $childrens;

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param Transaction $childrens
     */
    public function removeChildren(Transaction $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return Transaction[]
     */
    public function getChildrens()
    {
        return $this->childrens;
    }
}

<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\Taggable\Taggable;

/**
 * Transaction
 *
 * @ORM\Table(name="acc_transactions")
 * @ORM\Entity(repositoryClass="TransactionRepository")
 *
 */
class Transaction implements Taggable
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

    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="transaction", cascade={"persist"})
     */
    protected $entries;

    public function __construct()
    {
        $this->entries = $this->entries ?: new ArrayCollection();
    }

    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return 'accounting_transaction_tag';
    }

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

    /**
     * Get entries
     *
     * @return Entry[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Add entry
     *
     * @param Entry $entry
     * @return Entry
     */
    public function addEntry(Entry $entry)
    {
        $entry->setTransaction($this);
        $this->entries[] = $entry;

        return $this;
    }
}

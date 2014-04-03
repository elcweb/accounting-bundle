<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\Taggable\Taggable;
use JMS\Serializer\Annotation as Serializer;

/**
 * Transaction
 *
 * @ORM\Table(name="acc_transactions",indexes={@ORM\Index(columns={"date"})})
 * @ORM\Entity(repositoryClass="TransactionRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Transaction implements Taggable
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
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column( type="datetime")
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Expose
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column( type="date")
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Expose
     */
    private $date;

    /**
     * @var Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction", inversedBy="childrens", fetch="EAGER")
     * @ORM\JoinColumn( referencedColumnName="id",onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=80, nullable=true)
     *
     * @Serializer\Expose
     */
    private $comment;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="parent", fetch="EAGER")
     */
    private $childrens;

    /**
     *
     * @Serializer\Expose
     */
    private $tags;

    /**
     * @var string $ref
     *
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     *
     * @Serializer\Expose
     */
    private $ref;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="transaction", cascade={"persist"})
     *
     * @Serializer\Expose
     */
    private $entries;

    public function getTags()
    {
        $this->tags = $this->tags ? : new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return 'accounting_transaction_tag';
    }

    public function getTaggableId()
    {
        return $this->getId();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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

    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    public function getRef()
    {
        return $this->ref;
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
        $this->entries   = $this->entries ? : new ArrayCollection();
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
     * @return Collection
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Get entries
     *
     * @return Collection
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

    /**
     * Remove entry
     *
     * @param Entry $entry
     */
    public function removeEntry(Entry $entry)
    {
        $this->entries->removeElement($entry);
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;

            $entries = $this->getEntries();
            foreach ($entries as $entry) {
                $clone = clone $entry;
                $this->removeEntry($entry);
                $this->addEntry($clone);
            }
        }
    }

    /**
     * Add entries
     *
     * @param Entry $entries
     * @return Transaction
     */
    public function addEntrie(Entry $entries)
    {
        $this->entries[] = $entries;

        return $this;
    }

    /**
     * Remove entries
     *
     * @param Entry $entries
     */
    public function removeEntrie(Entry $entries)
    {
        $this->entries->removeElement($entries);
    }
}

<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use DateTime;

/**
 * Account
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="acc_accounts")
 * @ORM\Entity(repositoryClass="AccountRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Account implements Taggable
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3")
     *
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Account", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="account")
     */
    private $entries;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="AccountType", inversedBy="accounts")
     * @ORM\JoinColumn( referencedColumnName="id", nullable=false)
     *
     * @Serializer\Expose
     */
    protected $type;

    /**
     *
     * @Serializer\Expose
     */
    private $tags;

    // todo: currency
    /**
     * @Assert\Currency
     *
     * @Serializer\Expose
     */
    protected $currency = 'CAD';

    /**
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     * @Assert\Regex("/^\w+/")
     *
     * @Serializer\Expose
     */
    private $slug;

    /**
     * @var string $ref
     *
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     *
     * @Assert\Type(type="integer")
     *
     * @Serializer\Expose
     */
    private $ref;

    /**
     * @ORM\OneToMany(targetEntity="AccountsDailySummaryView", mappedBy="account")
     */
    private $dailySummary;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->entries  = new ArrayCollection();
        $this->dailySummary  = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Account
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Account
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Account
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Account
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Account
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Account
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set parent
     *
     * @param Account $parent
     * @return Account
     */
    public function setParent(Account $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Account
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Account $children
     * @return Account
     */
    public function addChildren(Account $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Account $children
     */
    public function removeChildren(Account $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add entries
     *
     * @param Entry $entries
     * @return Account
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
     * Get dailySummary
     *
     * @return Collection
     */
    public function getDailySummary()
    {
        return $this->dailySummary;
    }

    /**
     * Set type
     *
     * @param AccountType $type
     * @return Account
     */
    public function setType(AccountType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return AccountType
     */
    public function getType()
    {
        return $this->type;
    }


    public function getTags()
    {
        $this->tags = $this->tags ? : new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return 'accounting_account_tag';
    }

    public function getTaggableId()
    {
        return $this->getId();
    }

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getBalance()
    {
        $sign = (int)($this->getType()->getValue() . "1");

        return $this->getSum() * $sign;
    }

    public function getBalanceChildren()
    {
        $balance = $this->getBalance();
        foreach ($this->getChildren() AS $child) {
            $balance += $child->getBalanceChildren();
        }

        return $balance;
    }

    /**
     * Get the sum of all the account entries with optional start end date parameters
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return float|int
     */
    public function getSum(DateTime $startDate = null, DateTime $endDate = null)
    {
        $balance = 0;

        /** @var $entries AccountsDailySummaryView[] */
        $entries = $this->getDailySummary()->filter(
            function (AccountsDailySummaryView $entry) use ($startDate, $endDate) {

                $filter = true;

                if ($startDate) {
                    $filter &= $entry->getDay()->format('Y-m-d') >= $startDate->format('Y-m-d');
                }

                if ($endDate) {
                    $filter &= $entry->getDay()->format('Y-m-d') <= $endDate->format('Y-m-d');
                }

                return $filter;
            }
        );

        foreach ($entries as $entry) {
            $balance += $entry->getTotal();
        }

        return $balance;
    }

    public function getSumChildren()
    {
        $balance = $this->getSum();
        foreach ($this->getChildren() AS $child) {
            $balance += $child->getSumChildren();
        }

        return $balance;
    }
}

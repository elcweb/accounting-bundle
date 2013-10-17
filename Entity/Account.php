<?php

namespace Elcweb\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validation\Constraints AS Assert;

/**
 * Account
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="acc_accounts")
 * @ORM\Entity(repositoryClass="AccountRepository")
 *
 */
class Account implements Taggable
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\NotBlank()
     */
    private $name;

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

    private $tags;

    // todo: currency
    /**
     * @Assert\Currency
     */
    protected $currency = 'CAD';

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", unique=true, nullable=true)
     * @Assert\Regex("/^\w+/")
     */
    private $slug;

    /**
     * @var string $ref
     *
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     *
     * @Assert\Type(type="integer")
     */
    private $ref;

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
        return 'accounting_account_tag';
    }

    public function getTaggableId()
    {
        return $this->getId();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setParent(Account $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
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
        return (string) $this->getName();
    }

    public function getBalance()
    {
        $balance = 0;
        foreach ($this->entries AS $entry) {
            $balance += $entry->getAmount();
        }
        
        return $balance;
    }
}
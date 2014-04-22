<?php

namespace Elcweb\AccountingBundle\Manager;

use DateTime;
use Doctrine\ORM\EntityManager;
use FPN\TagBundle\Entity\TagManager;

use Elcweb\AccountingBundle\Entity\Account;

class AccountManager
{
    protected $em, $tm;

    public function __construct(EntityManager $em, TagManager $tm)
    {
        $this->em = $em;
        $this->tm = $tm;
    }

    public function create($name, $slug, $tags = array(), $parent = null)
    {
        $repo = $this->em->getRepository('ElcwebAccountingBundle:Account');

        $parentAccount = $repo->findOneBySlug($parent);

        if (!$parentAccount) {
            // todo: throw error
        }

        // todo: validate if not existent
        $account = $repo->findOneBySlug($slug);

        if (!$account) {
            $account = new Account;
            $account->setParent($parentAccount);
            $account->setName($name);
            $account->setSlug($slug);
            $account->setType($parentAccount->getType());

            foreach ($tags as $tag) {
                $tag = $this->tm->loadOrCreateTag($tag);
                $this->tm->addTag($tag, $account);
            }

            $this->em->persist($account);
            $this->em->flush();

            $this->tm->saveTagging($account);
        }
    }

    public function findByCode() {}

    /**
     *
     * @param $tag
     * @return Account[]
     */
    public function findByTag($tag)
    {
        // get Tag
        $tagRepo = $this->em->getRepository('ElcwebTagBundle:Tag');

        // find all article ids matching a particular query
        $ids = $tagRepo->getResourceIdsForTag('accounting_account_tag', $tag);

        $accounts = array();

        if (count($ids) > 0) {
            $accounts = $this->em->getRepository('ElcwebAccountingBundle:Account')->findById($ids);
        }

        return $accounts;
    }

    public function getBalance(Account $account)
    {

    }

    public function getBalanceByDateRange(Account $account, DateTime $start, DateTime $stop) {}

    public function getBalanceUntil(Account $account, DateTime $stop) {}
}

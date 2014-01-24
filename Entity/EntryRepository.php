<?php

namespace Elcweb\AccountingBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;

class EntryRepository extends EntityRepository
{
    /**
     * get Account balance
     *
     * @param Account $account
     * @param DateTime $stop
     * @param DateTime $start
     *
     * @return float $amount
     */
    public function getBalance(Account $account, DateTime $stop = null, DateTime $start = null)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('SUM(a.amount)');
        $qb->where('a.account = :accountId');
        $qb->setParameter('accountId', $account->getId());

        $qb->leftJoin('ElcwebAccountingBundle:Transaction', 't', 'WITH', 'a.transaction = t.id');

        if ($stop) {
            $qb->andWhere($qb->expr()->lte('t.date', ':endDate'));
            $qb->setParameter('endDate', $stop->format('Y-m-d'));
        }

        if ($start) {
            $qb->andWhere($qb->expr()->gte('t.date', ':startDate'));
            $qb->setParameter('startDate', $start->format('Y-m-d'));
        }

        return $qb->getQuery()->getSingleScalarResult() + 0; // +0 is to convert string to number.
    }
}

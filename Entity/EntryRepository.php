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

        if ($stop) {
            $qb->andWhere($qb->expr()->lte('a.createdAt', ':endDate'));
            $qb->setParameter('endDate', $stop->format('Y-m-d H:i:s'));
        }

        if ($start) {
            $qb->andWhere($qb->expr()->gte('a.createdAt', ':startDate'));
            $qb->setParameter('startDate', $start->format('Y-m-d H:i:s'));
        }

        return $qb->getQuery()->getSingleScalarResult() + 0; // +0 is to convert string to number.
    }
}

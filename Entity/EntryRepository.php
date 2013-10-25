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

        //todo: implement time filtering....
        if ($stop) {
            $qb->andWhere($qb->expr()->lte('a.debitDate', ':endday'));
            $qb->setParameter('endday', $stop->format('Y-m-d'));
        }

        if ($start) {
            //$qb->andWhere($qb->expr()->lte('a.debitDate', ':startday'));
            //$qb->setParameter('startday', $start->format('Y-m-d'));
        }

        return $qb->getQuery()->getSingleScalarResult() + 0; // +0 is a PHP float fix.
    }
}

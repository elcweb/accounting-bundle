<?php

namespace Elcweb\AccountingBundle\Entity;

use DateTime;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class AccountRepository extends NestedTreeRepository
{
    // todo: this is currently not working
    /**
     * get Account balance
     *
     * @param string $code
     * @param DateTime $stop
     * @param DataTime $start
     *
     * @return float $amount
     */
    public function getBalance($code, DateTime $stop = null, DateTime $start = null)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('SUM(a.amount)');
        $qb->where('a.code = :code');

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

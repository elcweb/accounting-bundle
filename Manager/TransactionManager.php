<?php

namespace Elcweb\AccountingBundle\Manager;

use DateTime;
use Doctrine\ORM\EntityManager;
use FPN\TagBundle\Entity\TagManager;

use Elcweb\AccountingBundle\Entity\Account;
use Elcweb\AccountingBundle\Entity\Entry;
use Elcweb\AccountingBundle\Entity\Transaction;

class TransactionManager
{
    protected $em, $am;

    public function __construct(EntityManager $em, AccountManager $am)
    {
        $this->em = $em;
        $this->am = $am;
    }

    /*
        $entries = array(
            array(
                'code'    => $code,
                'amount'  => $amount,
                'comment' => $comment
            ),
            array(
                'code'    => $code,
                'amount'  => $amount,
                'comment' => $comment
            )
        );
    */
    public function create($type, $entries = array())
    {
        $transactionType = $this->em->getRepository('ElcwebAccountingBundle:TransactionType')->find($type);
        if (!$transactionType) {
            // todo: throw error
        }

        // check integrity
        if (!$this->checkIntegrity($entries)) {
            // todo: throw error
        }

        $transaction = new Transaction;
        $transaction->setTransactionType($transactionType);

        foreach ($entries as $elem) {
            $account = $this->em->getRepository('ElcwebAccountingBundle:Account')->findOneByCode($elem['code']);
            if (!$account) {
                // todo: throw error
            }

            $entry = new Entry;
            $entry->setAccount($account);
            $entry->setAmount($elem['amount']);
            if (array_key_exists('comment', $elem)) {
                $entry->setComment($elem['comment']);
            }
            
            $transaction->addEntry($entry);
        }

        $this->em->persist($transaction);
        $this->em->flush();
    }

    protected function checkIntegrity($entries)
    {
        $sum = 0;
        foreach ($entries as $entry) {
            $sum += $entry['amount'];
        }

        return ($sum == 0);
    }
}

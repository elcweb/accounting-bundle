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
    public function create($type, $entries = array(), $comment = null, $parentId = null)
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
        $transaction->setComment(null);

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

        if ($parentId) {
            $transaction->setParent($this->get($parentId));
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

    public function reverse($transactionId, $comment = null)
    {
        $transactionOld = $this->get($transactionId);

        // todo: check if not already reversed.
        
        if (!$comment) {
            $comment = 'Transaction reversal for transaction ID #'.$transactionId;
        }
        
        $entries = array();
        foreach ($transactionOld->getEntries() as $oldEntry) {
            $entry = array(
                'code'    => $oldEntry->getAccount()->getCode(),
                'amount'  => $oldEntry->getAmount() * -1,
                'comment' => $comment
            );

            $entries[] = $entry;
        }

        $this->create('R', $entries, $comment, $transactionId);
    }

    protected function get($transactionId)
    {
        $transaction = $this->em->getRepository('ElcwebAccountingBundle:Transaction')->find($transactionId);
        if (!$transaction) {
            // todo: throw error
        }

        return $transaction;
    }
}

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
    protected $em, $am, $tagManager;

    public function __construct(EntityManager $em, TagManager $tagManager, AccountManager $am)
    {
        $this->em = $em;
        $this->am = $am;
        $this->tagManager = $tagManager;
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
    public function create($entries = array(), $tags = array(), $comment = null, $parentId = null)
    {
        // check integrity
        if (!$this->checkIntegritySum($entries)) {
            // todo: throw error
        }

        $transaction = new Transaction;
        $transaction->setComment(null);

        foreach ($entries as $elem) {
            $account = $this->em->getRepository('ElcwebAccountingBundle:Account')->findOneBySlug($elem['slug']);
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

        // Tags
        foreach ($tags as $tag) {
            $tag = $this->tagManager->loadOrCreateTag($tag);
            $this->tagManager->addTag($tag, $transaction);
        }

        // Parent transaction
        if ($parentId) {
            $transaction->setParent($this->get($parentId));
        }

        $this->em->persist($transaction);
        $this->em->flush();
        $this->tagManager->saveTagging($transaction);
    }

    protected function checkIntegritySum($entries)
    {
        $sum = 0;
        foreach ($entries as $entry) {
            $sum += $entry['amount'];
        }

        return ($sum == 0);
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

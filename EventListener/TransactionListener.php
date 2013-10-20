<?php

namespace Elcweb\AccountingBundle\EventListener;

use Elcweb\AccountingBundle\Manager\TransactionManager;
use Jmikola\WildcardEventDispatcherBundle\EventDispatcher\ContainerAwareEventDispatcher as EventDispatcher;
use Elcweb\EventStoreBundle\Event\BaseEvent as Event;

class TransactionListener
{
    protected $tm;

    public function __construct(TransactionManager $tm)
    {
        $this->tm = $tm;
    }

    public function create(Event $event)
    {
        $entries  = $event->getArgument('entries');
        $tags     = ($event->hasArgument('tags'))     ? $event->getArgument('tags')     : array();
        $comment  = ($event->hasArgument('comment'))  ? $event->getArgument('comment')  : null;
        $parentId = ($event->hasArgument('parentId')) ? $event->getArgument('parentId') : null;

        $this->tm->create($entries, $comment, $parentId);

        $event->getDispatcher()->dispatch('elcweb.accounting.transaction.created', $event);
    }
}

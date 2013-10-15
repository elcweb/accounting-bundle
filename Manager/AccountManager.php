<?php

namespace Elcweb\AccountingBundle\Manager;

use \DateTime;
use Elcweb\AccountingBundle\Entity\Account;

class AccountManager
{
    public function getBalance(Account $account) {}

    public function getBalanceByDateRange(Account $account, DateTime $start, DateTime $stop) {}

    public function getBalanceUntil(Account $account, DateTime $stop) {}
}

<?php

namespace Elcweb\AccountingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Elcweb\AccountingBundle\Entity\AccountType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Elcweb\AccountingBundle\Entity\Account;

class AccountData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     *
     * Ref : http://en.wikipedia.org/wiki/Chart_of_accounts#Types_of_accounts
     */
    public function load(ObjectManager $manager)
    {
        /** @var $accountTypeDebit AccountType */
        $accountTypeDebit  = $this->getReference('typeDebit'); // load the stored reference

        /** @var $accountTypeCredit AccountType */
        $accountTypeCredit = $this->getReference('typeCredit');

        $root = new Account();
        $root->setName('Root');
        $root->setSlug('root');

        $root->setType($accountTypeDebit);
        $manager->persist($root);

        // Assets / Actif
        $assets = new Account();
        $assets->setName('Assets');
        $assets->setParent($root);
        $assets->setType($accountTypeDebit);
        $manager->persist($assets);
        $this->addReference('account_assets', $assets);

        // Assets : Cash
        $cash = new Account();
        $cash->setName('Cash');
        $cash->setParent($assets);
        $cash->setType($accountTypeDebit);
        $manager->persist($cash);
        $this->addReference('account_cash', $cash);

        // Assets : Accounts Receivable
        $receivable = new Account();
        $receivable->setName('Accounts Receivable');
        $receivable->setParent($assets);
        $receivable->setType($accountTypeDebit);
        $manager->persist($receivable);
        $this->addReference('account_receivable', $receivable);

        // liability / Passif
        $liability = new Account();
        $liability->setName('Liability');
        $liability->setParent($root);
        $liability->setType($accountTypeCredit);
        $manager->persist($liability);
        $this->addReference('account_liability', $liability);

        // liability : Accounts Payable
        $payable = new Account();
        $payable->setName('Accounts Payable');
        $payable->setParent($liability);
        $payable->setType($accountTypeCredit);
        $manager->persist($payable);
        $this->addReference('account_payable', $payable);

        // Equity / Avoir
        $equity = new Account();
        $equity->setName('Equity');
        $equity->setParent($root);
        $equity->setType($accountTypeCredit);
        $manager->persist($equity);
        $this->addReference('account_equity', $equity);


        // Revenue / Produits
        $revenue = new Account();
        $revenue->setName('Revenue');
        $revenue->setParent($root);
        $revenue->setType($accountTypeCredit);
        $manager->persist($revenue);
        $this->addReference('account_revenue', $revenue);

        // Expense / Charges
        $expense = new Account();
        $expense->setName('Expense');
        $expense->setParent($root);
        $expense->setType($accountTypeDebit);
        $manager->persist($expense);
        $this->addReference('account_expense', $expense);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}

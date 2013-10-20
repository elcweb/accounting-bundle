<?php

namespace Elcweb\AccountingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
        $root = new Account();
        $root->setName('Root');
        $root->setSlug('root');
        $root->setType(
            $this->getReference('typeDebit') // load the stored reference
        );
        $manager->persist($root);

            // Assets / Actif
            $assets = new Account();
            $assets->setName('Assets');
            $assets->setParent($root);
            $assets->setType(
                $this->getReference('typeDebit')
            );
            $manager->persist($assets);
            $this->addReference('account_assets', $assets);

            // Assets : Cash
            $cash = new Account();
            $cash->setName('Cash');
            $cash->setParent($assets);
            $cash->setType(
                $this->getReference('typeDebit')
            );
            $manager->persist($cash);
            $this->addReference('account_cash', $cash);

            // Assets : Accounts Receivable 
            $receivable = new Account();
            $receivable->setName('Accounts Receivable');
            $receivable->setParent($assets);
            $receivable->setType(
                $this->getReference('typeDebit')
            );
            $manager->persist($receivable);
            $this->addReference('account_receivable', $receivable);

            // liability / Passif
            $liability = new Account();
            $liability->setName('Liability');
            $liability->setParent($root);
            $liability->setType(2);
            $liability->setType(
                $this->getReference('typeCredit')
            );
            $manager->persist($liability);
            $this->addReference('account_liability', $liability);

            // liability : Accounts Payable 
            $payable = new Account();
            $payable->setName('Accounts Payable');
            $payable->setParent($liability);
            $payable->setType(2);
            $payable->setType(
                $this->getReference('typeCredit')
            );
            $manager->persist($payable);
            $this->addReference('account_payable', $payable);

            // Equity / Avoir
            $equity = new Account();
            $equity->setName('Equity');
            $equity->setParent($root);
            $equity->setType(
                $this->getReference('typeCredit')
            );
            $manager->persist($equity);
            $this->addReference('account_equity', $equity);


            // Revenue / Produits
            $revenue = new Account();
            $revenue->setName('Revenue');
            $revenue->setParent($root);
            $revenue->setType(
                $this->getReference('typeCredit')
            );
            $manager->persist($revenue);
            $this->addReference('account_revenue', $revenue);

            // Expense / Charges
            $expense = new Account();
            $expense->setName('Expense');
            $expense->setParent($root);
            $expense->setType(
                $this->getReference('typeDebit')
            );
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

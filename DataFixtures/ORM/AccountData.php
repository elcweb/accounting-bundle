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
     */
    public function load(ObjectManager $manager)
    {
        // Ref : http://en.wikipedia.org/wiki/Chart_of_accounts#Types_of_accounts

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

        // liability / Passif
        $liability = new Account();
        $liability->setName('Liability');
        $liability->setParent($root);
        $liability->setType(2);
        $liability->setType(
                $this->getReference('typeCredit')
            );
        $manager->persist($liability);

        // Equity / Avoir
        $equity = new Account();
        $equity->setName('Equity');
        $equity->setParent($root);
        $equity->setType(
                $this->getReference('typeCredit')
            );
        $manager->persist($equity);


        // Revenue / Produits
        $revenue = new Account();
        $revenue->setName('Revenue');
        $revenue->setParent($root);
        $revenue->setType(
                $this->getReference('typeCredit')
            );
        $manager->persist($revenue);

        // Expense / Charges
        $expense = new Account();
        $expense->setName('Expense');
        $expense->setParent($root);
        $expense->setType(
                $this->getReference('typeDebit')
            );
        $manager->persist($expense);

//
//            $a20000 = new Account();
//            $a20000->setName('Account Receivable');
//            $a20000->setParent($assets);
//            $a20000->setType(1);
//            $manager->persist($a20000);
//
//            $a21000 = new Account();
//            $a21000->setName('Bank');
//            $a21000->setParent($assets);
//            $a21000->setType(1);
//            $manager->persist($a21000);
//
//                $a21100 = new Account();
//                $a21100->setName('Bank 1');
//                $a21100->setParent($a21000);
//                $a21100->setSlug('bank1');
//                $a21100->setType(1);
//                $manager->persist($a21100);
//
//        // Equity
//        $equity = new Account();
//        $equity->setName('Equity');
//        $equity->setParent($root);
//        $equity->setType(2);
//        $manager->persist($equity);
//
//            $a30000 = new Account();
//            $a30000->setName('Opening Balance Equity');
//            $a30000->setParent($equity);
//            $a30000->setType(2);
//            $manager->persist($a30000);
//
//        // Profit and Lost
//        $pl = new Account();
//        $pl->setName('Profit and Lost');
//        $pl->setParent($root);
//        $pl->setType(2);
//        $manager->persist($pl);
//        
//            $a42000 = new Account();
//            $a42000->setName('Income');
//            $a42000->setParent($pl);
//            $a42000->setType(2);
//            $manager->persist($a42000);
//
//                $a42100 = new Account();
//                $a42100->setName('E-Lending');
//                $a42100->setParent($a42000);
//                $a42100->setType(2);
//                $manager->persist($a42100);
//
//                    $a42110 = new Account();
//                    $a42110->setName('Interest');
//                    $a42110->setParent($a42100);
//                    $a42110->setSlug('interest');
//                    $a42110->setType(2);
//                    $manager->persist($a42110);
//
//                    $a42120 = new Account();
//                    $a42120->setName('Fees');
//                    $a42120->setParent($a42100);
//                    $a42120->setType(2);
//                    $manager->persist($a42120);
//
//                        $a42121 = new Account();
//                        $a42121->setName('Origination');
//                        $a42121->setParent($a42120);
//                        $a42121->setSlug('fee-origination');
//                        $a42121->setType(2);
//                        $manager->persist($a42121);
//
//                        $a42122 = new Account();
//                        $a42122->setName('Platform');
//                        $a42122->setParent($a42120);
//                        $a42122->setSlug('fee-platform');
//                        $a42122->setType(2);
//                        $manager->persist($a42122);
//
//                        $a42123 = new Account();
//                        $a42123->setName('Risk');
//                        $a42123->setParent($a42120);
//                        $a42123->setSlug('fee-risk');
//                        $a42123->setType(2);
//                        $manager->persist($a42123);
//
//                $a48700 = new Account();
//                $a48700->setName('Service Income');
//                $a48700->setParent($a42000);
//                $a48700->setType(2);
//                $manager->persist($a48700);
//
//                    $a48710 = new Account();
//                    $a48710->setName('Wire Fee');
//                    $a48710->setParent($a48700);
//                    $a48710->setSlug('fee-wire');
//                    $a48710->setType(2);
//                    $manager->persist($a48710);
//
//                    $a48720 = new Account();
//                    $a48720->setName('Return Fee');
//                    $a48720->setParent($a48700);
//                    $a48720->setSlug('fee-return');
//                    $a48720->setType(2);
//                    $manager->persist($a48720);
//
//            $a67000 = new Account();
//            $a67000->setName('Expense');
//            $a67000->setParent($pl);
//            $a67000->setType(2);
//            $manager->persist($a67000);
//
//                $a67300 = new Account();
//                $a67300->setName('Uncollectable AR');
//                $a67300->setParent($a67000);
//                $a67300->setType(2);
//                $manager->persist($a67300);
//
//                    $a67310 = new Account();
//                    $a67310->setName('Write Off');
//                    $a67310->setParent($a67300);
//                    $a67310->setType(2);
//                    $manager->persist($a67310);
//
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

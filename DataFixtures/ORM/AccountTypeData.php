<?php

namespace Elcweb\AccountingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Elcweb\AccountingBundle\Entity\AccountType;

class AccountTypeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        
        $typeDebit = new AccountType();
        $typeDebit->setId(1);
        $typeDebit->setName('Debit');
        $typeDebit->setValue('+');
        $manager->persist($typeDebit);

        $typeCredit = new AccountType();
        $typeCredit->setId(2);
        $typeCredit->setName('Credit');
        $typeCredit->setValue('-');
        $manager->persist($typeCredit);

        $manager->flush();

        // store reference to admin role for Account relation to AccountType
        $this->addReference('typeDebit', $typeDebit);
        $this->addReference('typeCredit', $typeCredit);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }
}

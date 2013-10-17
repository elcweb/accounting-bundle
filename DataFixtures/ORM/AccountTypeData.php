<?php

namespace Elcweb\AccountingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Elcweb\AccountingBundle\Entity\AccountType;

class AccountTypeData implements FixtureInterface, ContainerAwareInterface
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
        
        $type = new AccountType();
        $type->setName('Debit');
        $type->setValue('+');
        $manager->persist($type);

        $type = new AccountType();
        $type->setName('Credit');
        $type->setValue('-');
        $manager->persist($type);

        $manager->flush();
    }
}

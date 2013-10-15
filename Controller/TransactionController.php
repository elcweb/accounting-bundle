<?php

namespace Elcweb\AccountingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Elcweb\AccountingBundle\Entity\Transaction;

/**
 * @Route("/admin/accounting/transaction")
 */
class TransactionController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $transactions = $em->getRepository('ElcwebAccountingBundle:Transaction')->findAll();

        return array('transactions' => $transactions);
    }

    /**
     * @Route("/{id}/show")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function showAction(Transaction $transaction)
    {
        return array('transaction' => $transaction);
    }
}

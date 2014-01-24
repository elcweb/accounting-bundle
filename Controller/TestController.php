<?php

namespace Elcweb\AccountingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Elcweb\AccountingBundle\Entity\Account;

/**
 * @Route("/admin/test/accounting")
 */
class TestController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /*
        $tm = $this->get('elcweb.accounting.manager.transaction');

        $entries = array(
            array(
                'code'    => 'fee-platform-loan-20',
                'amount'  => 100
            ),
            array(
                'code'    => 'fee-risk-loan-20',
                'amount'  => 75,
                'comment' => 'test comment'
            ),
            array(
                'code'    => 'interest-loan-20',
                'amount'  => -175,
                'comment' => 'test comment'
            )
        );

        $tm->create('P', $entries);
        */
        //$tm = $this->get('mercantile.accounting.manager.transaction');
        //$tm->create('P', 123, 'comment1');
        $am = $this->get('elcweb.accounting.manager.account');
        $tm = $this->get('elcweb.accounting.manager.transaction');
        //$tm->get(7);

        return array('accounts' => array());
    }

    /**
     * @Route("/test1")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function test1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $loan = $em->getRepository('MercantileElendingLoanBundle:Loan')->find(20);
        $this->get('mercantile.manager.loan')->createAccounts($loan);

        return array('accounts' => array());
    }
}

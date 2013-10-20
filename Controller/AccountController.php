<?php

namespace Elcweb\AccountingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Elcweb\AccountingBundle\Entity\Account;

/**
 * @Route("/admin/accounting/account")
 */
class AccountController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tree = $em->getRepository('ElcwebAccountingBundle:Account')->childrenHierarchy();

        $accounts = $em->getRepository('ElcwebAccountingBundle:Account')->findAll();

        return array('tree' => $tree, 'accounts' => $accounts);
    }

    /**
     * @Route("/{id}/show")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function showAction(Account $account)
    {
        return array('account' => $account);
    }
}

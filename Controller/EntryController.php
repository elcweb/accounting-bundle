<?php

namespace Elcweb\AccountingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * @Route("/admin/accounting/entry")
 */
class EntryController extends Controller
{

    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entries = $em->getRepository('ElcwebAccountingBundle:Entry')->findAll();

        return array('entries' => $entries);
    }
}

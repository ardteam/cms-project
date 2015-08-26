<?php

namespace AT\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return $this->render('@ATCms/Core/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/baseHeader", name="base_header")
     * @Template()
     */
    public function partialBaseHeaderAction()
    {
        return $this->render('@ATCms/Core/partials/header.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/baseFooter", name="base_footer")
     * @Template()
     */
    public function partialBaseFooterAction()
    {
        return $this->render('@ATCms/Core/partials/footer.html.twig');
    }
}

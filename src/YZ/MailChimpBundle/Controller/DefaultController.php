<?php

namespace YZ\MailChimpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('YZMailChimpBundle:Default:index.html.twig');
    }
}

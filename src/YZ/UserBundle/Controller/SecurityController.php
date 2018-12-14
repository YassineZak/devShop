<?php
/**
 * Created by PhpStorm.
 * User: yassine
 * Date: 14/12/18
 * Time: 21:34
 */

namespace YZ\UserBundle\Controller;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;


class SecurityController extends BaseController
{

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
{
    $securityContext = $this->container->get('security.authorization_checker');
    if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        return $this->redirectToRoute('yz_ecommerce_homepage');
    }
    else{
        return $this->render('@FOSUser/Security/login.html.twig', $data);
    }
}

}
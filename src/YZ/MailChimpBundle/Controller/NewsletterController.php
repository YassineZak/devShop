<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/01/19
 * Time: 11:06
 */

namespace YZ\MailChimpBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \DrewM\MailChimp\MailChimp;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;




class NewsletterController extends Controller
{
    public function newsletterAction(){
            $form = $this->createFormBuilder(null)
                ->add('newsletter', EmailType::class)
                ->getForm();
            return $this->render('YZMailChimpBundle:Newsletter:newsletter.html.twig', array('form' =>$form->createView()));
    }
    public function addUserAction(Request $request){
        $userMail = $request->get('form')['newsletter'];
        $dotenv = new Dotenv();
        $dotenv->load('/var/www/html/devshop/.env');
        $mailchimpApiKey = getenv('MAILCHIMP_API_KEY');
        $mailChimp = new MailChimp($mailchimpApiKey);
        $mailChimp->verify_ssl = false;
        $listId = "6bbe9bec78";
        $membersMail= $mailChimp->get("lists/$listId/members");
        
        $result = $mailChimp->post("lists/$listId/members", [
            'email_address' => 'davy@example.com',
            'status'        => 'subscribed',
        ]);

        $log = $mailChimp->getLastResponse();
        dump($mailChimp);
        die;

    }
}
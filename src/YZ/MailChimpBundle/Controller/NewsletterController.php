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
        $emailExist = false;
        if (is_array($membersMail)){
            foreach ($membersMail['members'] as $member) {
                if ($member['email_address'] == $userMail){
                    $emailExist = true;
                }
            }
        }
        if ($emailExist){
            $request->getSession()->getFlashBag()->add('notice', 'Votre addresse mail est déja inscrite à notre newletter');
        }
        else{
            $result = $mailChimp->post("lists/$listId/members", [
            'email_address' => $userMail,
            'status'        => 'subscribed',
        ]);
            if ($result['email_address'] == $userMail){
                $request->getSession()->getFlashBag()->add('success', 'Votre addresse email a été ajouté avec succes');
            }
            else{
                $request->getSession()->getFlashBag()->add('error', 'Une erreur s\'est produite');
            }
        }
        return $this->redirectToRoute('yz_ecommerce_homepage');

    }
    public function deleteUserAction(){

    }
}
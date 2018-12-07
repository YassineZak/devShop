<?php
namespace YZ\ContactFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Dotenv\Dotenv;

class ContactController extends Controller
{
    public function formAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('YZ\ContactFormBundle\Form\ContactType',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('yz_contact_form'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){
                  $request->getSession()->getFlashBag()->add('notice', 'Votre message a bien été envoyé.');

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('yz_contact_form');
                }else{
                    $request->getSession()->getFlashBag()->add('error', 'Une erreur s\'est produite.');
                }
            }
        }
        return $this->render('YZContactFormBundle:ContactForm:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data){
        $dotenv = new Dotenv();
        $dotenv->load('/var/www/html/devshop/.env');
        $myappContactMail = getenv('MAILER_USER');
        $myappContactPassword = getenv('MAILER_PASSWORD');
        $transport = \Swift_SmtpTransport::newInstance(getenv('MAILER_HOST'), 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Our Code World Contact Form ". $data["subject"])
        ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
        ->setTo(array(
            $myappContactMail => $myappContactMail
        ))
        ->setBody($data["message"]."<br>ContactMail :".$data["email"]);

        return $mailer->send($message);
    }
}

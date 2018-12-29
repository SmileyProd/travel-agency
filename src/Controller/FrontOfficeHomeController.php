<?php
/**
 * Gestion de la page d'accueil de l'application
 *
 * @copyright  2017 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Home controller.
 */
class FrontOfficeHomeController extends Controller
{    
    /**
     * Displays welcome page.
     * 
     * @Route("/", name="front_home", methods="GET")
     */
    public function indexAction()
    {
        return $this->render('/front/home.html.twig');
    }

    /**
     * Displays news page.
     * 
     * @Route("/actualites", name="front_news", methods="GET")
     */
    public function indexNews()
    {
        return $this->render('/front/news.html.twig');
    }

    /**
     * Displays contact page.
     * 
     * @Route("/Nous-contacter", name="front_contact", methods="GET|POST")
     */
    public function contact(Request $request) {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendMessageMail($contact);
            $this->sendConfirmationMail($contact);

            return $this->redirectToRoute('front_home');
        }
        return $this->render('/front/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Send the contact to SymfTravel
     *
     */
    public function sendMessageMail(Contact $contact) {
        $mail = new \Swift_Message();
        $mail->setFrom('no-reply@symftravel.com')
             ->setTo('contact@symftravel.com')
             ->setSubject('Contact de ' . $contact->getFirstname() . ' ' . $contact->getLastname())
             ->setBody('
                 <html>
                    <head>
                        <link rel="stylesheet" href="/css/back/boostrap.min.css">
                    </head>
                    <body>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1>Sujet : '.$contact->getSubject().'</h1>
                                </div>
                                <div class="col-md-6">
                                    <p>Nom : '.$contact->getLastname().'</p>
                                    <p>Prenom : '.$contact->getFirstname().'</p>    
                                </div>
                                <div>
                                    <p>Email : '.$contact->getEmail().'</p>
                                </div>
                                <div class="col-lg-12">
                                    <p>Message : '.$contact->getMessage().'</p>
                                </div>
                            </div>
                        </div>
                    </body>
                 </html>
                 ');
        $this->get('mailer')->send($mail);
    }

    /**
     * Send confirmation mail to the contact
     */
    public function sendConfirmationMail(Contact $contact) {
        $mail = new \Swift_Message();
        $mail->setFrom('no-reply@symftravel.com')
             ->setTo($contact->getEmail())
             ->setSubject('Confirmation contact Symftravel')
             ->setBody('
                 <html>
                    <head>
                        <link rel="stylesheet" href="/css/back/boostrap.min.css">
                    </head>
                    <body>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1>Confirmation mail SymfTravel</h1>
                                </div>
                                <div">
                                    <p>Sujet : '.$contact->getSubject().'</p> 
                                </div>
                                <div>
                                    <p>Message : '.$contact->getMessage().'</p>
                                </div>
                            </div>
                        </div>
                    </body>
                 </html>
                 ');
        $this->get('mailer')->send($mail);
    }
}


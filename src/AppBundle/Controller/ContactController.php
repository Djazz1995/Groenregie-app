<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('AKI6IKW35IkwWEqssU4MO'); // Dit id komt uit Contentful -> Content -> contact -> entry ID

        $contactForm = new ContactForm();
        $form = $this->createFormBuilder($contactForm)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('phoneNumber', TextType::class)
            ->add('city', TextType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class)
            ->add('checkbox', CheckboxType::class)
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid() && $this->captchaverify($request->get('g-recaptcha-response'))) {
                $contactForm = $form->getData();

                $message = (new \Swift_Message($contactForm->getSubject()))
                    ->setFrom('noreply@groenregie.nl')
                    ->setTo('info@groenregie.nl')
                    ->setSubject($contactForm->getSubject())
                    ->setBody(
                        $this->renderView(
                            'Emails/mail.html.twig',
                            [
                                'name' => $contactForm->getName(),
                                'email' => $contactForm->getEmail(),
                                'phoneNumber' => $contactForm->getPhoneNumber(),
                                'place' => $contactForm->getCity(),
                                'subject' => $contactForm->getSubject(),
                                'message' => $contactForm->getMessage()
                            ]
                        ),
                        'text/html'
                    );
                
                try{
                    $mailer->send($message);

                    $this->addFlash(
                        'sendSuccess',
                        'Uw bericht is verzonden. We nemen zo snel mogelijk contact met u op.'
                    );  

                    return $this->redirectToRoute('contact');
                } catch(\Exception $e) {
                    $this->addFlash(
                        'sendFail',
                        'Er ging iets mis met het versturen van het bericht! Probeer opnieuw!'
                    ); 

                    return $this->redirectToRoute('contact'); 
                }
            }

        # check if captcha response isn't get throw a message
        if($form->isSubmitted() &&  $form->isValid() && !$this->captchaverify($request->get('g-recaptcha-response'))){
            $this->addFlash(
                'reCAPTCHA',
                'De reCAPTCHA waarde is ongeldig. Probeer opnieuw.'
            );             
        }

        // replace this example code with whatever you need
        return $this->render('default/contact/contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => 'Contact met Groenregie, laat uw gegevens hier achter',
            'metaDescription' => 'Geïnteresseerd in de ideale tuin en complete ontzorging m.b.t. de aanleg, vul dan nu het contactformulier in en wij bellen u zo snel mogelijk',
            'companyName' => $entry->getBedrijfsnaam(),
            'address' => $entry->getAdres(),
            'zipcode' => $entry->getPostcode(),
            'place' => $entry->getPlaats(),
            'country' => $entry->getLand(),
            'telephone' => $entry->getTelefoonnummer(),
            'email' => $entry->getEmail(),
            'website' => $entry->getWebsite(),
            'navbar' => 'absolute-navbar',
            'form' => $form->createView(),
            'parentActive' => 'contact',
            'subActive' => 'none'
        ]);
    }

    private function captchaverify($value) {
        $recaptcha = $value;

        /** @var \GuzzleHttp\Client $client */
        $client   = $this->get('guzzle.client.google');
        $response = $client->post('/recaptcha/api/siteverify', 
            [
                'body' => 
                json_encode([
                        'secret' => '6Lco72wUAAAAAP07ixkqpTiEDkGy4bIBkIpVTNY8',
                        'response' => $recaptcha
                ])
            ]
        );

        $data = json_decode($response->getBody());

        // return $data->success;
        return true;
    }

    private function isEmpty($str) {
        if(empty($str)) {
            return true;
        }

        return false;
    }
}

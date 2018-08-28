<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('AKI6IKW35IkwWEqssU4MO');

        // replace this example code with whatever you need
        return $this->render('default/contact/contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'companyName' => $entry->getBedrijfsnaam(),
            'address' => $entry->getAdres(),
            'zipcode' => $entry->getPostcode(),
            'place' => $entry->getPlaats(),
            'country' => $entry->getLand(),
            'telephone' => $entry->getTelefoonnummer(),
            'email' => $entry->getEmail(),
            'website' => $entry->getWebsite(),
            'navbar' => 'absolute-navbar'
        ]);
    }
}

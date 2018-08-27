<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooterController extends AbstractController
{
    public function getFooterAction()
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');
        $entry = $client->getEntry('AKI6IKW35IkwWEqssU4MO'); // Dit id komt uit Contentful -> Content -> klantreactie-> entry ID

        return $this->render('default/footer/footer.html.twig',[
            'companyName' => $entry->getBedrijfsnaam(),
            'address' => $entry->getAdres(),
            'zipcode' => $entry->getPostCode(),
            'city' => $entry->getPlaats(),
            'country' => $entry->getLand(),
            'tel' => $entry->getTelefoonnummer(),
            'email' => $entry->getEmail(),
            'fbUrl' => $entry->getFacebookUrl(),
            'instaUrl' => $entry->getInstagramUrl(),
            'linUrl' => $entry->getLinkedinUrl()
        ]);
    }
}

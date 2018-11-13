<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LegalController extends Controller
{
    /**
     * @Route("/privacy-overeenkomst", name="privacy_declaration")
     */
    public function privacyAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('1jBtmhLUYGiYskQEKEM8cg');

        return $this->redirect($entry->getPrivacyPdf()->getFile()->getUrl());
    }

    /**
     * @Route("/algemene-voorwaarden", name="general_declaration")
     */
    public function generalAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('1Wkh46L7V2EYG06424ES0M');

        // replace this example code with whatever you need
        return $this->render('default/legal/declaration.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'fullContent' => $entry->getInhoud(),
            'parentActive' => 'declaration',
            'subActive' => 'none'
        ]);
    }
}

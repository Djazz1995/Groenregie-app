<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;


class AboutUsController extends Controller
{
    /**
     * @Route("/over-ons", name="about_us")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5NqYtprbZSO0CES0Og0SMG'); // Dit id komt uit Contentful -> Content -> Over ons -> entry ID
        
        // replace this example code with whatever you need
        return $this->render('default/aboutUs/about_us.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'content' => $entry->getInhoud(),
            'contentAuthor' => $entry->getInhoudAuteur(),
            'quote' => $entry->getQuote(),
            'quoteAuthor' => $entry->getQuoteAuteur(),
            'profilePhoto' => $entry->getPasfoto()
        ]);
    }
}

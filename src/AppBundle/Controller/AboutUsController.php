<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;


class AboutUsController extends Controller
{
    /**
     * @Route("/over-ons/visie", name="about_us")
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
            'image' => $entry->getPasfoto(),
            'quote' => $entry->getQuote(),
            'quoteAuthor' => $entry->getQuoteAuteur(),
            'profilePhoto' => $entry->getPasfoto(),
            'parentActive' => 'aboutUs',
            'subActive' => 'vision',
            'direction' => 'left',
            'pageBackground' => $entry->getPaginaAchtergrond(),

        ]);
    }

    /**
     * @Route("/over-ons/design", name="about_us_design")
     */
    public function designAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5VFb4Cl4qcYWmwSmmsoAyo'); // Dit id komt uit Contentful -> Content -> Ons aanbod -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/aboutUs/about_us.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getOntwerpTitel(),
            'content' => $entry->getOntwerp(),
            'parentActive' => 'aboutUs',
            'subActive' => 'gardenDesign',
            'direction' => $entry->getOntwerpLayoutRechts() == true ? 'right' : 'left'
        ]);
    }

    /**
     * @Route("/over-ons/aanleg", name="about_us_build")
     */
    public function buildAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5VFb4Cl4qcYWmwSmmsoAyo'); // Dit id komt uit Contentful -> Content -> Ons aanbod -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/aboutUs/about_us.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getAanlegTitel(),
            'content' => $entry->getAanleg(),
            'parentActive' => 'aboutUs',
            'subActive' => 'gardenBuild',
            'direction' => $entry->getAanlegLayoutRechts() == true ? 'right' : 'left'
        ]);
    }

    /**
     * @Route("/over-ons/onderhoud", name="about_us_maintain")
     */
    public function maintainAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5VFb4Cl4qcYWmwSmmsoAyo'); // Dit id komt uit Contentful -> Content -> Ons aanbod -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/aboutUs/about_us.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getOnderhoudTitel(),
            'content' => $entry->getOnderhoud(),
            'parentActive' => 'aboutUs',
            'subActive' => 'gardenMaintainance',
            'direction' => $entry->getOnderhoudLayoutRechts() == true ? 'right' : 'left'
        ]);
    }
}

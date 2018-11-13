<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;


class OurPartnersController extends Controller
{
    /**
     * @Route("/onze-partners", name="our_partners")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('744S6RI9lCgusGAQe2iKi8'); // Dit id komt uit Contentful -> Content -> Onze partners -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/ourPartners/our_partners.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'partners' => $entry->getPartners(),
            'parentActive' => 'ourPartners',
            'subActive' => 'none'
        ]);
    }

    /**
     * @Route("/onze-partners/{name}/{id}", name="our_partners_specific")
     */
    public function partnerSpecificAction(Request $request, $name, $id)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry($id); // Dit id komt uit Contentful -> Content -> partner-> entry ID

        // replace this example code with whatever you need
        return $this->render('default/ourPartners/our_partner_specific.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getNaam(),
            'thumbnail' => $entry->getThumbnail(),
            'fullContent' => $entry->getVolleText(),
            'website' => $entry->getWebsite(),
            'parentActive' => 'ourPartners',
            'subActive' => 'none'
        ]);
    }
}

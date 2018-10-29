<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class OurServicesController extends Controller
{
    /**
     * @Route("/ons-aanbod", name="our_services")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5VFb4Cl4qcYWmwSmmsoAyo'); // Dit id komt uit Contentful -> Content -> Ons aanbod -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/ourServices/our_services.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'foto' => $entry->getFoto(),
            'ontwerpTitle' => $entry->getOntwerpTitel(),
            'aanlegTitle' => $entry->getAanlegTitel(),
            'onderhoudTitle' => $entry->getOnderhoudTitel(),
            'ontwerp' => $entry->getOntwerp(),
            'aanleg' => $entry->getAanleg(),
            'onderhoud' => $entry->getOnderhoud()
        ]);
    }
}

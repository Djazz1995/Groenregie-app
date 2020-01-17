<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class CustomerReactionsController extends Controller
{
    /**
     * @Route("/klantreacties", name="customer_reactions")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5p80mbwi9q8SKiOg0mIQiO'); // Dit id komt uit Contentful -> Content -> Klantreacties -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/customerReactions/customer_reactions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getMetatitle(),
            'metaDescription' => $entry->getMetadescription(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'customerReactions' => $entry->getKlantreacties(),
            'parentActive' => 'customerReactions',
            'subActive' => 'none'
        ]);
    }
}

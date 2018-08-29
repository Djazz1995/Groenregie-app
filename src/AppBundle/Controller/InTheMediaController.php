<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class InTheMediaController extends Controller
{
    /**
     * @Route("/in-de-media", name="in_the_media")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('4zYGo95b0sykcSwsisyOMe'); // Dit id komt uit Contentful -> Content -> In de Media -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/inTheMedia/in_the_media.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'mediaItems' => $entry->getMediaItems()
        ]);
    }

    /**
     * @Route("/in-de-media/{name}/{id}", name="in_the_media_specific")
     */
    public function partnerAction(Request $request, $name, $id)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry($id); // Dit id komt uit Contentful -> Content -> klantreactie-> entry ID

        // replace this example code with whatever you need
        return $this->render('default/inTheMedia/in_the_media_specific.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getNaam(),
            'pageHeader' => $entry->getNaam(),
            'thumbnail' => $entry->getThumbnail(),
            'fullContent' => $entry->getVolleText(),
            'pdf' => $entry->getPdf()
        ]);
    }
}
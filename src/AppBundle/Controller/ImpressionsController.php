<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

use Psr\Log\LoggerInterface;

class ImpressionsController extends Controller
{

    /**
     * @Route("/projecten/keuze", name="impressions_choose")
     */
    public function chooseAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2'); // Dit id komt uit Contentful -> Content -> Klantreacties -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions_choose.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => '',
            'parentActive' => 'ourProjects',
            'subActive' => 'none'
        ]);
    }

    /**
     * @Route("/projecten/moderne-tuinen", name="impressions_modern_gardens")
     */
    public function indexModernAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2'); // Dit id komt uit Contentful -> Content -> Klantreacties -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'projectPhotos' => $entry->getModerneTuinen(),
            'parentActive' => 'ourProjects',
            'subActive' => 'modernGardens'
        ]);
    }

    /**
     * @Route("/projecten/natuurlijke-tuinen", name="impressions_nature_gardens")
     */
    public function indexNatureAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2'); // Dit id komt uit Contentful -> Content -> Klantreacties -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'projectPhotos' => $entry->getNatuurlijkeTuinen(),
            'parentActive' => 'ourProjects',
            'subActive' => 'natureGardens'
        ]);
    }

    /**
     * @Route("/projecten/dakterrassen", name="impressions_patios")
     */
    public function patioAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2'); // Dit id komt uit Contentful -> Content -> Klantreacties -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'projectPhotos' => $entry->getNatuurlijkeTuinen(),
            'parentActive' => 'ourProjects',
            'subActive' => 'patios'
        ]);
    }

    /**
     * @Route("/impressies/{name}/{id}", name="impression_specific")
     */
    public function impressionAction(Request $request, $name, $id)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry($id); // Dit id komt uit Contentful -> Content -> klantreactie-> entry ID
        
        return $this->render('default/impressions/impressions_specific.html.twig', [
            'pageTitle' => $entry->getTitel(),
            'pageHeader' => $entry->getTitel(),
            'thumbnail' => $entry->getThumbnail(),
            'fullContent' => $entry->getVolleText(),
            'fotos' => $entry->getFotos(),
            'parentActive' => 'ourProjects',
            'subActive' => 'none'
        ]);
    }
}

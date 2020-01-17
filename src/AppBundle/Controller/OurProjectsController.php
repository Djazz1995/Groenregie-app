<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

use Psr\Log\LoggerInterface;

class OurProjectsController extends Controller
{

    /**
     * @Route("/projecten/keuze", name="impressions_choose")
     */
    public function chooseAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2');

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions_choose.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getMetatitle(),
            'metaDescription' => $entry->getMetaDescription(),
            'parentActive' => 'ourProjects',
            'subActive' => 'none',
            'entry' => $entry
        ]);
    }

    /**
     * @Route("/projecten/moderne-tuinen", name="impressions_modern_gardens")
     */
    public function indexModernAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2');

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getModernMetaTitle(),
            'metaDescription' => $entry->getModernMetaDescription(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'projectPhotos' => $entry->getModerneTuinen(),
            'parentActive' => 'ourProjects',
            'subActive' => 'modernGardens',
            'entry' => $entry
        ]);
    }

    /**
     * @Route("/projecten/natuurlijke-tuinen", name="impressions_nature_gardens")
     */
    public function indexNatureAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2');

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getNatuurlijkMetaTitle(),
            'metaDescription' => $entry->getNatuurlijkMetaDescription(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'projectPhotos' => $entry->getNatuurlijkeTuinen(),
            'parentActive' => 'ourProjects',
            'subActive' => 'natureGardens',
            'entry' => $entry
        ]);
    }

    /**
     * @Route("/projecten/daktuinen", name="impressions_roof_gardens")
     */
    public function indexRoofAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('5hJyBJIxfUuAKSqWyEk4Y2');

        // replace this example code with whatever you need
        return $this->render('default/impressions/impressions.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getDakMetaTitle(),
            'metaDescription' => $entry->getDakMetaDescription(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'projectPhotos' => $entry->getDakTuinen(),
            'parentActive' => 'ourProjects',
            'subActive' => 'roofGardens',
            'entry' => $entry
        ]);
    }

    /**
     * @Route("/impressies/{name}/{id}", name="impression_specific")
     */
    public function impressionAction(Request $request, $name, $id)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry($id);
        
        return $this->render('default/impressions/impressions_specific.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getMetaTitle(),
            'metaDescription' => $entry->getMetaDescription(),
            'pageHeader' => $entry->getTitel(),
            'thumbnail' => $entry->getThumbnail(),
            'fullContent' => $entry->getVolleText(),
            'fotos' => $entry->getFotos(),
            'parentActive' => 'ourProjects',
            'subActive' => 'none',
            'entry' => $entry
        ]);
    }
}

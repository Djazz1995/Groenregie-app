<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class NewsUpdatesController extends Controller
{
    /**
     * @Route("/nieuws-en-updates", name="news_updates")
     */
    public function indexAction(Request $request)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry('6xlxqVQo8gsw0aUEq0EE0Q'); // Dit id komt uit Contentful -> Content -> Klantreacties -> entry ID

        // replace this example code with whatever you need
        return $this->render('default/newsAndUpdates/news_updates.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'metaTitle' => $entry->getMetaTitle(),
            'metaDescription' => $entry->getMetaDescription(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'news' => $entry->getNieuwsitems(),
            'parentActive' => 'news',
            'subActive' => 'newsAndUpdates'
        ]);
    }

    /**
     * @Route("/nieuws-en-updates/{name}/{id}", name="news_updates_specific")
     */
    public function newsAction(Request $request, $name, $id)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry($id); // Dit id komt uit Contentful -> Content -> klantreactie-> entry ID

        // replace this example code with whatever you need
        return $this->render('default/newsAndUpdates/news_updates_specific.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getNaam(),
            'pageHeader' => $entry->getNaam(),
            'image' => $entry->getThumbnail(),
            'content' => $entry->getVolleText(),
            'pdf' => $entry->getPdf(),
            'parentActive' => 'news',
            'subActive' => 'newsAndUpdates',
            'imageWidth' => $entry->getAfbeeldingBreedte() ? $entry->getAfbeeldingBreedte() . 'px' : null,
            'pageBackground' => $entry->getPaginaAchtergrond(),
            'direction' => $entry->getLayoutTextRechts() == true ? 'right' : 'left'
        ]);
    }
}

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
            'pageTitle' => $entry->getPaginaTitel(),
            'pageHeader' => $entry->getPaginaHeader(),
            'pageSubHeader' => $entry->getPaginaSubHeader(),
            'customerReactions' => $entry->getKlantreacties(),
            'parentActive' => 'customerReactions',
            'subActive' => 'none'
        ]);
    }

    /**
     * @Route("/klantreacties/{name}/{id}", name="customer_reaction_specific")
     */
    public function partnerAction(Request $request, $name, $id)
    {
        $client = new \Contentful\Delivery\Client('4113452de26e27759b744718344945d5afc601e64e217688758dbfd649076208', 'jjzsv0091dq4', 'master');

        $entry = $client->getEntry($id); // Dit id komt uit Contentful -> Content -> klantreactie-> entry ID

        // replace this example code with whatever you need
        return $this->render('default/customerReactions/customer_reaction_specific.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pageTitle' => $entry->getNaam(),
            'pageHeader' => $entry->getNaam(),
            'image' => $entry->getThumbnail(),
            'content' => $entry->getVolleText(),
            'contentAuthor' => $entry->getAuteur(),
            'parentActive' => 'customerReactions',
            'subActive' => 'none',
            'project' => $entry->getProject(),
            'imageWidth' => $entry->getAfbeeldingBreedte() ? $entry->getAfbeeldingBreedte() . 'px' : null,
            'pageBackground' => $entry->getPaginaAchtergrond(),
            'direction' => $entry->getLayoutTextRechts() == true ? 'right' : 'left'
        ]);
    }
}

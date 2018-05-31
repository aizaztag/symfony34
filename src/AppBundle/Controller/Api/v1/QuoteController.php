<?php
namespace AppBundle\Controller\Api\v1;

use AppBundle\Entity\Quote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuoteController extends Controller
{

    /**
     * @Route("/api/v1/quote")
     *
     */
    public function newAction(Request $request) {

        // Get the Query Parameters from the URL
        // We will trust that the input is safe (sanitized)
        $sourceQuery = $request->query->get('source');
        $quoteQuery = $request->query->get('quote');

        // Create a new empty object
        $quote = new Quote();

        // Use methods from the Quote entity to set the values
        $quote->setSource($sourceQuery);
        $quote->setQuote($quoteQuery);

        // Get the Doctrine service and manager
        $em = $this->getDoctrine()->getManager();

        // Add our quote to Doctrine so that it can be saved
        $em->persist($quote);

        // Save our quote
        $em->flush();

        return new Response('It\'s probably been saved', 201);


    }

}


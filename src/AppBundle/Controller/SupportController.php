<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ContactFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        $form = $this->createForm(ContactFormType::class , null ,  [
            'action' => $this->generateUrl('handle_form_submission'),
        ]);

        return $this->render('support/index.html.twig', [
            'our_form' => $form->createView(),
        ]);

    }

    /**
     * @param Request $request
     * @Route ("/form-submission" , name="handle_form_submission")
     * @Method("POST")
     */
    public function handleFormSubmissionAction(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        //NOTValid  form
        if (!$form->isSubmitted() || !$form->isValid()) {

            return $this->redirectToRoute('homepage');

        }

        $data = $form->getData();

        dump($data);

        $message = \Swift_Message::newInstance()
            ->setSubject('Contact Form Submission')
            ->setFrom($data['from'])
            ->setTo('cml17b+bnpwk32glorjs@sharklasers.com')
            ->setBody(
                $form->getData()['message'],
                'text/plain'
            );

        $this->get('mailer')->send($message);

        $this->addFlash('success' , 'Message was sent');

        return $this->redirectToRoute('homepage');

    }

}

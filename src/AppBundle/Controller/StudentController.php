<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class StudentController extends Controller
{

    /**
     * @Route("/student" , name="ajaxCall")
     */
    public function studentAction(Request $request)
    {
        $students = $this->getDoctrine()
            ->getRepository('AppBundle:Student')
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($students as $student) {
                $temp = array(
                    'name' => $student->getName(),
                    'address' => $student->getAddress(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('student/ajax.html.twig');
        }
    }


    /**
     * @Route("/session" , name="session")
     */
    public function sessionAction(Request $request)
    {

        $session = $request->getSession();

        $session->start();

// set and get session attributes
        $session->set('name', 'Drak');
        $session->get('name');



// set flash messages
        $session->getFlashBag()->add('notice', 'Profile updated');

// retrieve messages
        foreach ($session->getFlashBag()->get('notice', array()) as $message) {
            //echo '<div class="flash-notice">' . $message . '</div>';
           // dump($message);
        }


        $session->getFlashBag()->add(
            'warning',
            'Your config file is writable, it should be set read-only'
        );
        $session->getFlashBag()->add('error', 'Failed to update name');
        $session->getFlashBag()->add('error', 'Another error');

        foreach ($session->getFlashBag()->get('warning', array()) as $message) {
           // echo '<div class="flash-warning">'.$message.'</div>';
            dump($message);
        }



        return $this->render('student/ajax.html.twig' ,  ['session' => $session]);


    }


}

?>
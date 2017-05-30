<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 *
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function aboutAction(Request $request)
    {
        $form = $this->createForm(ContactType::class, null);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject("Subject" . $data["subject"])
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($this->container->getParameter('mailer_user'))
                ->setBody($data["message"] . "<br>ContactMail :" . $data["email"], 'text/html');
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/about.html.twig', array(
            'form_about' => $form->createView()
        ));
    }

}

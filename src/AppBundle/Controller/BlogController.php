<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class BlogController
 *
 * @package AppBundle\Controller
 * Controller managing blog index.
 */
class BlogController extends Controller
{

    /**
     * @param $page
     *
     * @return Response
     */
    public function indexAction($page)
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findLatest($page, 1);
        return $this->render('default/home.html.twig', array(
            'posts' => $posts
        ));
    }


    /**
     * @param $slug
     *
     * @return Response
     *
     * NOTE: The $post controller argument is automatically injected by Symfony
     * after performing a database query looking for a Post with the 'slug'
     * value given in the route.
     * See http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     */
    public function postShowAction(Post $post)
    {

        if ('dev' === $this->getParameter('kernel.environment')) {
            dump($post, $this->get('security.token_storage')->getToken()->getUser(), new \DateTime());
        }
        return $this->render('default/detail.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * @param Request $request
     * @param Post $post
     *
     * @return RedirectResponse|Response
     */
    public function commentFormAction(Request $request, Post $post)
    {
        $form = $this->createForm('AppBundle\Form\CommentType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Comment $comment */
            $comment = $form->getData();

            $comment->setAuthor($this->getUser());
            $comment->setPost($post);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_detail', array('slug' => $post->getSlug()));
        }

        return $this->render('default/comment_form.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogAdminController
 *
 * @package AppBundle\Controller
 * Controller managing the blog admin.
 */
class BlogAdminController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->createQueryBuilder('p')
            ->orderBy('p.publishedAt', 'DESC')->getQuery()->getResult();

        return $this->render('admin/index.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createPostAction(Request $request)
    {

        $post = new Post();
        $post->setAuthorEmail($this->getUser()->getEmail());
        $form = $this->createForm(PostType::class, $post);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setSlug($this->get('slugger')->slugify($post->getTitle()));

            // 4) save the Post!
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param Post $post
     *
     * @return Response
     */
    public function editPostAction(Request $request, Post $post)
    {

        if (!$post->isAuthor($this->getUser())) {
            return $this->redirectToRoute('admin');
        }

        $form = $this->createForm(PostType::class, $post);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $my_service = $this->container->get('app.bundle.service');
            $my_service->setFlash('Your changes were saved!', 'success');

            // 4) save the Post!
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Post $post
     *
     * @return RedirectResponse
     */
    public function deletePostAction(Post $post)
    {
        if (!$post) {
            throw $this->createNotFoundException('No  found');
        }
        $em = $this->getDoctrine()->getManager();

        $cache = $this->container->get('cache.provider.my_memcached');
        $cache->deleteItem('post_' . $post->getSlug());

        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('admin');
    }
}

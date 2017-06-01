<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findLatest($page);
        return $this->render('default/home.html.twig', array(
            'posts' => $posts
        ));
    }


    /**
     * @param Post $post
     *
     * @return Response
     *
     * NOTE: The $post controller argument is automatically injected by Symfony
     * after performing a database query looking for a Post with the 'slug'
     * value given in the route.
     * See http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     */
    public function postShowAction($slug)
    {
        $cache = $this->get( 'aequasi_cache.instance.default' );

        if ( !$cache->fetch('post_' . $slug) ){
            $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBy(array(
                'slug' => $slug
            ));
            $cache->save('post_' . $slug, $post);
        }

        $post = $cache->fetch('post_' . $slug);

        return $this->render('default/detail.html.twig', array(
            'post' => $post
        ));
    }
}

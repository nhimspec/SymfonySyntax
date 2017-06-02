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
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findLatest($page,1);
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
    public function postShowAction($slug)
    {
        $cache = $this->get('cache.provider.my_memcached');
        $item = $cache->getItem('post_' . $slug);

        if (!$item->isHit()) {
            $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBy(array(
                'slug' => $slug
            ));
            $item->set($post);
            $cache->save($item);
        }

        return $this->render('default/detail.html.twig', array(
            'post' => $item->get()
        ));
        
    }
}

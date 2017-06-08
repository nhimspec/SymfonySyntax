<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * This custom Doctrine repository contains some methods which are useful when
 * querying for blog post information.
 * See http://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 */
class PostRepository extends EntityRepository
{


    public function queryLatest()
    {
        return $this->getEntityManager()
            ->createQuery('
               SELECT p
               FROM AppBundle:Post p
               WHERE p.publishedAt <= :now
               ORDER BY p.publishedAt DESC
           ')
            ->setParameter('now', new \DateTime());
    }

    /**
     * @param int $page  Current Page
     * @param int $limit Limit post per page
     *
     * @return Pagerfanta
     */
    public function findLatest($page = 1, $limit = Post::NUM_ITEMS)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}

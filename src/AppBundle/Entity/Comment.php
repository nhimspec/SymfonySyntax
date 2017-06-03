<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 *
 * Defines the properties of the Comment entity to represent the blog comments.
 * See http://symfony.com/doc/current/book/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See http://symfony.com/doc/current/cookbook/doctrine/reverse_engineering.html
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userComments")
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please, Comment can't blank")
     * @Assert\Length(
     *     min = "5",
     *     minMessage = "Comment too short",
     *     max = "10000",
     *     maxMessage = "Comment too long"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $publishedAt;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    /**
     * @Assert\IsTrue(message = "Please, Dont spam comment")
     */
    public function isLegitComment()
    {
        $containsInvalidCharacters = false !== strpos($this->content, '@');

        return !$containsInvalidCharacters;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $user)
    {
        $this->author = $user;
    }


    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

}

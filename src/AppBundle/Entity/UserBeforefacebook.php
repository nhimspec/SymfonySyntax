<?php
//namespace AppBundle\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Symfony\Component\Security\Core\User\UserInterface;
//
///**
// * @ORM\Table(name="users")
// * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
// * @UniqueEntity(fields="email", message="Email already taken")
// * @UniqueEntity(fields="username", message="Username already taken")
// */
//class User implements UserInterface, \Serializable
//{
//    /**
//     * @ORM\Column(type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=25, unique=true)
//     * @Assert\NotBlank()
//     */
//    private $username;
//
//    /**
//     * @Assert\NotBlank()
//     * @Assert\Length(max=4096)
//     */
//    private $plainPassword;
//
//    /**
//     * @ORM\Column(type="string", length=64)
//     */
//    private $password;
//
//    /**
//     * @ORM\Column(type="string", length=60, unique=true)
//     * @Assert\NotBlank()
//     * @Assert\Email()
//     */
//    private $email;
//
//    /**
//     * @ORM\Column(name="is_active", type="boolean")
//     */
//    private $isActive;
//
//    /**
//     * @ORM\Column(type="json_array")
//     */
//    private $roles = array();
//
//    public function __construct()
//    {
//        $this->isActive = true;
//        // may not be needed, see section on salt below
//        // $this->salt = md5(uniqid(null, true));
//    }
//
//    public function getUsername()
//    {
//        return $this->username;
//    }
//
//    public function getSalt()
//    {
//        // you *may* need a real salt depending on your encoder
//        // see section on salt below
//        return null;
//    }
//
//    public function getPlainPassword()
//    {
//        return $this->plainPassword;
//    }
//
//    public function getPassword()
//    {
//        return $this->password;
//    }
//
//    public function getRoles()
//    {
//        $roles = $this->roles;
//        if (empty($roles)) {
//            $roles[] = 'ROLE_USER';
//        }
//
//        return array_unique($roles);
//    }
//
//    public function setRoles(array $roles)
//    {
//        $this->roles = $roles;
//
//        // allows for chaining
//        return $this;
//    }
//
//    public function eraseCredentials()
//    {
//    }
//
//    /** @see \Serializable::serialize() */
//    public function serialize()
//    {
//        return serialize(array(
//            $this->id,
//            $this->username,
//            $this->password,
//            // see section on salt below
//            // $this->salt,
//        ));
//    }
//
//    /** @see \Serializable::unserialize() */
//    public function unserialize($serialized)
//    {
//        list (
//            $this->id,
//            $this->username,
//            $this->password,
//            // see section on salt below
//            // $this->salt
//            ) = unserialize($serialized);
//    }
//
//    /**
//     * Get id
//     *
//     * @return integer
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Set username
//     *
//     * @param string $username
//     * @return User
//     */
//    public function setUsername($username)
//    {
//        $this->username = $username;
//
//        return $this;
//    }
//
//    /**
//     * Set Plain Password
//     *
//     * @param string $password
//     * @return User
//     */
//    public function setPlainPassword($password)
//    {
//        $this->plainPassword = $password;
//    }
//
//    /**
//     * Set password
//     *
//     * @param string $password
//     * @return User
//     */
//    public function setPassword($password)
//    {
//        $this->password = $password;
//
//        return $this;
//    }
//
//    /**
//     * Set email
//     *
//     * @param string $email
//     * @return User
//     */
//    public function setEmail($email)
//    {
//        $this->email = $email;
//
//        return $this;
//    }
//
//    /**
//     * Get email
//     *
//     * @return string
//     */
//    public function getEmail()
//    {
//        return $this->email;
//    }
//
//    /**
//     * Set isActive
//     *
//     * @param boolean $isActive
//     * @return User
//     */
//    public function setIsActive($isActive)
//    {
//        $this->isActive = $isActive;
//
//        return $this;
//    }
//
//    /**
//     * Get isActive
//     *
//     * @return boolean
//     */
//    public function getIsActive()
//    {
//        return $this->isActive;
//    }
//}
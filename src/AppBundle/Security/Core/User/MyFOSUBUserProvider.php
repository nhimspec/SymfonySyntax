<?php

namespace AppBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\User;

/**
 * Class MyFOSUBUserProvider
 *
 * @package AppBundle\Security\Core\User
 */
class MyFOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier
        $profilePicture = $response->getProfilePicture();
        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (is_null($existingUser)) {
            global $kernel;

            /** @var $user User */
            $user->setFacebookId($username);

            // If Null Profile Picture
            if (is_null($user->getProfilePicture())) {
                $image_name = pathinfo($profilePicture)['filename'];
                $extension = pathinfo($profilePicture)['extension'];
                if (strrpos($extension, '?') !== false) {
                    $extension = substr($extension, 0, strrpos($extension, '?'));
                }
                $image_file = $image_name . '.' . $extension;
                $newfile = $kernel->getContainer()->getParameter('user_avatar_upload') . '/' . $image_file;

                copy($profilePicture, $newfile);

                // Update Entity
                $user->setProfilePicture($image_file);
            }
        }

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $facebookId = $response->getUsername(); // get the unique user identifier
        $property = $this->getProperty($response);
        $email = $response->getEmail();
        $username = $response->getRealName();
        $profilePicture = $response->getProfilePicture();

        /**
         * @var $user User
         * check if facebook Id is not exist Or Connect User if email is exist
         */
        $user = $this->userManager->findUserBy(array($property => $facebookId));
        if (is_null($user)) {
            if (!is_null($this->userManager->findUserBy(array('email' => $email)))) {
                $user = $this->userManager->findUserBy(array('email' => $email));
                $user->setFacebookId($facebookId);
            } else {
                global $kernel;
                $user = $this->userManager->createUser();
                $user->setFacebookId($facebookId);
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword('');

                $image_name = pathinfo($profilePicture)['filename'];
                $extension = pathinfo($profilePicture)['extension'];
                if (strrpos($extension, '?') !== false) {
                    $extension = substr($extension, 0, strrpos($extension, '?'));
                }
                $image_file = $image_name . '.' . $extension;
                $newfile = $kernel->getContainer()->getParameter('user_avatar_upload') . '/' . $image_file;
                copy($profilePicture, $newfile);
                $user->setProfilePicture($image_file);

                $user->setEnabled(true);
            }
        }
        //  update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token

        return $user;
    }
}
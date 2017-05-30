<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Class RegistrationController
 *
 * @package AppBundle\Controller
 * Controller managing the Registration
 */
class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {
        if (true === $this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }
        $response = parent::registerAction($request);

        return $response;
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string $token
     *
     * @return RedirectResponse|Response
     */
    public function confirmAction(Request $request, $token)
    {
        $response = parent::confirmAction($request, $token);

        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            /** If user already confirm or token not found */
            return $this->redirectToRoute('homepage');
        }
        return $response;

    }

}
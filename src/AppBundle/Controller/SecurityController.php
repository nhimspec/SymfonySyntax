<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 *
 * @package AppBundle\Controller
 * Controller managing the Security
 */
class SecurityController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function loginAction(Request $request)
    {
        if (true === $this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }
        $response = parent::loginAction($request);
        return $response;
    }
}

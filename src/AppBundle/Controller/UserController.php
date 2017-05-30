<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 *
 * @package AppBundle\Controller
 * Controller managing the user Manager.
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function showUserAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $formFactory = $this->get('fos_user.registration.form.factory');

        $users = $userManager->findUsers();
        $user = $userManager->createUser();

        $user->setEnabled(true);

        $form = $formFactory->createForm();
        $form->setData($user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userManager->updateUser($user);


            return $this->redirectToRoute('showuser');
        }

        return $this->render('default/user.html.twig', array(
            'users'    => $users,
            'form_add' => $form->createView()
        ));
    }

    /**
     * @param User $user
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteUserAction(User $user, Request $request)
    {
        if ($user == $this->getUser() || !$this->isCsrfTokenValid('delete_user', $request->get('_csrf_token'))) {
            return $this->redirectToRoute('showuser');
        }
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);

        return $this->redirectToRoute('showuser');
    }

}

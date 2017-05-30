<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProfileController
 *
 * @package AppBundle\Controller
 * Controller managing the user profile.
 */
class ProfileController extends BaseController
{
    /**
     * Ajax Edit Avatar
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function avatarEditAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser();
        $file = $request->files->get('file');

        if (!is_null($file)) {
            $upload_path = $this->getParameter('user_avatar_upload');
            $old_file_name = $user->getProfilePicture();

            if (!is_null($old_file_name)) {
                unlink($upload_path . '/' . $old_file_name);
            }
            $filename = uniqid() . "_" . $file->getClientOriginalName();
            $file->move(
                $upload_path,
                $filename
            );

            $user->setProfilePicture($filename);
        }
        $userManager->updateUser($user);

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $picture_path = $helper->asset($user, 'picture');

        return new JsonResponse($picture_path);
    }

}

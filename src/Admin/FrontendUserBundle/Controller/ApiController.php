<?php

/*
 * This file is part of the Admin package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\FrontendUserBundle\Controller;

use Admin\FrontendUserBundle\Document\FrontendUser;
use Admin\FrontendUserBundle\Manager\UserManager;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends FOSRestController
{

    /**
     * loginStatus .
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function loginStatusAction()
    {
        /** @var \Admin\FrontendUserBundle\Manager\UserManager $um */

        if ($this->isAuthenticated()) {

            return array('message' => 'You already logged in','status' => true);
        }
        else
        {
            return array('message' => 'You noy logged in','status' => false);
        }
    }


    /**
     * login .
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function loginAction(Request $request)
    {
        /** @var \Admin\FrontendUserBundle\Manager\UserManager $um */

        if (!$this->isAuthenticated()) {
            $username = $request->get('username');
            $password = $request->get('password');
            $um = $this->getUserManager();
            $user = $um->loadUserByUsername($username);

            if ((!$user instanceof FrontendUser) || (!$um->checkUserPassword($user, $password))) {
                return array('message' => 'Wrong username or password!',
                    'status' => false
                );
            }
            $this->loginUser($user);
            return array(
                'user' => $user,
                'status' => true,
                'message' => 'Successfully logged in'
            );

        }
        else
        {
            return array('message' => 'You already logged in. Try to refresh page');

        }

        return array('message' => 'Error in login action',
            'status' => false
        );
    }

    /**
     * Is User Authenticated
     *
     * @return boolean
     */
    private function isAuthenticated()
    {
        return $this->getUserManager()->isAuthenticated();
    }

    /**
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('frontend.user.manager');
    }

    /**
     * @param FrontendUser $user
     */
    protected function loginUser(FrontendUser $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }

    /**
     * Creates a new User from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     *
     * @return String
     */
    public function registerAction(Request $request)
    {
        $dm = $this->getDocumentManager();
        $groupe = $dm->getRepository('AdminFrontendUserBundle:Groupe')->find($request->get('groupe'));

        if ($this->isAuthenticated())
            return array('message' => 'You already logged in, please logout first');

        $params = array(
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'email' => $request->get('email'),
            'groupe' => $groupe,
            'enabled' => $request->get('enabled'),
        );

        if ($this->getUserManager()->findUser($params['username'], $params['email'])) {
            return array('message' => 'Username or e-mail already taken!');
        }

        $user = $this->getUserManager()->registerUser($params);

        if ($user) {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
        }

        return array(
            'user' => $user,
            'status' => true,
            'message' => 'Successfully registered'
        );

    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * Password Forget.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */

    public function passwordForgotAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            return array('message' => 'You already logged in, Please logout first');
        }
        $email = $request->get('email');

        if ($user = $this->getUserManager()->findUserByEmail($email)) {
            $response = $this->getUserManager()->resetPassword($user);

            if ($response != 1) {
                return array('message' => $response);
            }
        } else {
            return array('message' => 'User not found!');
        }

        return array('status' => true, 'message' => 'New password has been sent!');
    }

    /**
     * logout.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new FrontendUser());
        $this->get('security.context')->setToken($token);
        $this->get('session')->invalidate();

        return array('status' => true, 'message' => 'You have been successfully logged out!');
    }

    /**
     * informationAction
     *
     * @return FrontendUser|false
     */
    public function informationAction()
    {
        if ($this->isAuthenticated()) {
            $user = $this->get('security.context')->getToken()->getUser();

            return $user;
        }

        return false;
    }

    /**
     * Update User.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     *
     * @return String
     */

    public function editAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            $json = utf8_decode($request->get('userdata'));
            $userData = json_decode($json, true);
            $message = $this->getUserManager()->updateDetailsCurrentUser($userData);

            return array('status' => true, 'message' => $message);
        }
        return false;
    }

}

<?php

namespace Admin\FrontendUserBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityListener
{
    protected $router;
    protected $securityContext;

    public function __construct(EngineInterface $templating, RouterInterface $router, SecurityContextInterface $securityContext)
    {
        $this->templating = $templating;
        $this->router = $router;
        $this->securityContext = $securityContext;
    }

    public function onKernelRequest(GetResponseEvent $event = null)
    {
        $request = $event->getRequest();
        $path = explode("/", $request->getPathInfo());
        if (isset($path[1]) && $path[1] == "api2") {
            if ($this->securityContext->getToken() != null) {
                $token = $this->securityContext->getToken();
                $user = $token->getUser();
                if ($user == 'anon.') {
                    $response = new Response();
                    $response->setContent(
                    // create you custom template AcmeFooBundle:Exception:exception.html.twig
                        401
                    );
                    $event->setResponse($response);
                    return false;
                    exit;
                } else {
                    $roles = $user->getGroupe()->getRole();
                    $valid = true;
                    $route = $event->getRequest()->attributes->get('_route');
                    foreach ($roles as $role) {
                        if (!in_array($route, $roles)) {
                            $valid = false;
                        }
                        if (!$valid) {
                            $response = new Response();
                            $response->setContent(
                            // create you custom template AcmeFooBundle:Exception:exception.html.twig
//                                $this->templating->render('BackOfficeUserBundle:Exception:403.html.twig', array('code' => 403))
                                403
                            );
                            $event->setResponse($response);
                        }
                    }
                }
            }
        }
    }
}

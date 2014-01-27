<?php

namespace Expo\ApiBundle\EventListener;

use Expo\ApiBundle\Controller\ApiTokenControllerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class SimpleApiTokenListener
 * @package Expo\ApiBundle\EventListener
 */
class SimpleApiTokenListener
{
    /**
     * @var An array of tokens
     */
    protected $tokens;

    /**
     * @param $tokens
     */
    public function __construct($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        // check controller content
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiTokenControllerInterface) {
            // get current user token
            $token = $event->getRequest()->query->get('token');

            // does token valid?
            if (!in_array($token, $this->tokens)) {
                throw new AccessDeniedHttpException(sprintf('You are not authorized to use this action'));
            }

            // token is valid
            $event->getRequest()->attributes->set('expo-token', $token);
        }
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$token = $event->getRequest()->attributes->get('expo-token')) {
            return;
        }

        $response = $event->getResponse();

        // create a hash and set it as a response header
        $hash = sha1($response->getContent().$token);
        $response->headers->set('X-CONTENT-HASH', $hash);
    }
} 
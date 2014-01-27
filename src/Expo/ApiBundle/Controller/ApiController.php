<?php

namespace Expo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ApiController
 * @package Expo\ApiBundle\Controller
 * @Route("/api")
 */
class ApiController extends Controller implements ApiTokenControllerInterface
{
    /**
     * @Route("/photos", name="api_photos")
     * @Method({"GET", "POST"})
     */
    public function photosAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig', array());
    }

    /**
     * @Route("/photos/{id}", requirements={"id" = "\d+"}, defaults={"id" = 1}, name="api_photos_id")
     * @Method({"GET", "PUT"})
     */
    public function photosById($id)
    {
	    return '';
    }
}

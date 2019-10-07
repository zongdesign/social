<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Track;
use App\Event\ApiRequestEvent;
use App\Event\ApiRequestEvents;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrackerController.
 */
class TrackerController extends AbstractController
{
    /**
     * @Route("/api/tracker/{slug}", name="app_tracker")
     *
     * @param Request $request
     * @param string $slug
     * @param EventDispatcherInterface $dispatcher
     *
     * @return JsonResponse
     */
    public function tracker(Request $request, string $slug, EventDispatcherInterface $dispatcher)
    {
        $userUUID = $this->getUser() !== null
            ? $this->getUser()->getId()
            : $this->getUserUUID($request->headers);
        ;

        $track = new Track((string) $userUUID, $slug, new \DateTime());
        $dispatcher->dispatch(new ApiRequestEvent($track), ApiRequestEvents::API_REQUEST_EVENT);
        return $this->json(
            sprintf('Hello, %s. Your action %s.', $userUUID, $slug),
            200
        );
    }

    /**
     * @param HeaderBag $headers
     *
     * @return string
     */
    public function getUserUUID(HeaderBag $headers)
    {
        return md5(
            sprintf(
                '%s%s%s',
                $headers->get('cookie'),
                $headers->get('user-agent'),
                $headers->get('host')
            )
        );
    }
}

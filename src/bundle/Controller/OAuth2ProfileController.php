<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

final class OAuth2ProfileController extends AbstractController
{
    public function viewAction(Security $security): Response
    {
        $user = $security->getUser();
        if ($user === null) {
            throw $this->createAccessDeniedException();
        }

        return new JsonResponse([
            'username' => $user ? $user->getUsername() : null,
        ]);
    }
}

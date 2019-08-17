<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOAuth2Bundle\Controller;

use AdamWojs\EzPlatformOAuth2Bundle\Form\Data\ClientData;
use AdamWojs\EzPlatformOAuth2Bundle\Form\Data\ClientSelectionData;
use AdamWojs\EzPlatformOAuth2Bundle\Form\Type\ClientBulkActionType;
use AdamWojs\EzPlatformOAuth2Bundle\Form\Type\ClientType;
use EzSystems\EzPlatformAdminUi\Form\SubmitHandler;
use EzSystems\EzPlatformAdminUiBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;

final class OAuth2ClientController extends Controller
{
    /** @var \Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface */
    private $clientManager;

    /** @var \EzSystems\EzPlatformAdminUi\Form\SubmitHandler */
    private $submitHandler;

    public function __construct(ClientManagerInterface $clientManager, SubmitHandler $submitHandler)
    {
        $this->clientManager = $clientManager;
        $this->submitHandler = $submitHandler;
    }

    public function indexAction(Request $request): Response
    {
        $clients = $this->clientManager->list(null);

        $actionForm = $this->createBulkActionForm($clients);

        return $this->render('@ezdesign/oauth2/client/index.html.twig', [
            'clients' => $clients,
            'bulk_action_form' => $actionForm->createView(),
        ]);
    }

    public function createAction(Request $request): Response
    {
        $form = $this->createCreateForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $response = $this->submitHandler->handle($form, function (ClientData $data) {
                $this->clientManager->save($data->toModel());

                return $this->redirectToRoute('ezplatform.oauth2.client.list');
            });

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        return $this->render('@ezdesign/oauth2/client/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function updateAction(Request $request, string $identifier): Response
    {
        $client = $this->getClientOrThrowNotFoundException($identifier);

        $form = $this->createUpdateForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $response = $this->submitHandler->handle($form, function (ClientData $data) {
                $this->clientManager->save($data->toModel());

                return $this->redirectToRoute('ezplatform.oauth2.client.list');
            });

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        return $this->render('@ezdesign/oauth2/client/update.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    public function deleteAction(Request $request): Response
    {
        $form = $this->createBulkActionForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $response = $this->submitHandler->handle($form, function (ClientSelectionData $data) {
                foreach ($data->getSelection() as $client) {
                    $this->clientManager->remove($client);
                }

                return $this->redirectToRoute('ezplatform.oauth2.client.list');
            });

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        throw new BadRequestHttpException();
    }

    private function getClientOrThrowNotFoundException(string $identifier): Client
    {
        $client = $this->clientManager->find($identifier);

        if ($client === null) {
            throw $this->createNotFoundException();
        }

        return $client;
    }

    private function createBulkActionForm(array $selection = []): FormInterface
    {
        $data = new ClientSelectionData($selection);

        return $this->createForm(ClientBulkActionType::class, $data, [
            'method' => Request::METHOD_POST,
        ]);
    }

    private function createCreateForm(): FormInterface
    {
        return $this->createForm(ClientType::class, null, [
            'method' => Request::METHOD_POST,
            'action' => $this->generateUrl('ezplatform.oauth2.client.create'),
        ]);
    }

    private function createUpdateForm(Client $client): FormInterface
    {
        $data = ClientData::createFromModel($client);

        return $this->createForm(ClientType::class, $data, [
            'method' => Request::METHOD_POST,
            'action' => $this->generateUrl('ezplatform.oauth2.client.update', [
                'identifier' => $client->getIdentifier(),
            ]),
            'update' => true,
        ]);
    }
}

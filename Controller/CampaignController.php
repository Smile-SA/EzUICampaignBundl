<?php

namespace Smile\EzUICampaignBundle\Controller;

use eZ\Publish\API\Repository\Values\ValueObject;
use EzSystems\RepositoryForms\Form\ActionDispatcher\ActionDispatcherInterface;
use Smile\EzUICampaignBundle\Data\Mapper\CampaignFolderMapper;
use Smile\EzUICampaignBundle\Data\Mapper\CampaignMapper;
use Smile\EzUICampaignBundle\Form\ActionDispatcher\CampaignActionDispatcher;
use Smile\EzUICampaignBundle\Form\ActionDispatcher\CampaignFolderActionDispatcher;
use Smile\EzUICampaignBundle\Form\Type\CampaignDeleteType;
use Smile\EzUICampaignBundle\Form\Type\CampaignFolderType;
use Smile\EzUICampaignBundle\Form\Type\CampaignListDeleteType;
use Smile\EzUICampaignBundle\Form\Type\CampaignType;
use Smile\EzUICampaignBundle\Service\CampaignFolderService;
use Smile\EzUICampaignBundle\Service\CampaignFoldersService;
use Smile\EzUICampaignBundle\Service\CampaignService;
use Smile\EzUICampaignBundle\Service\CampaignsService;
use Smile\EzUICampaignBundle\Service\ListService;
use Smile\EzUICampaignBundle\Service\ListsService;
use Smile\EzUICampaignBundle\Values\Core\Campaign;
use Smile\EzUICampaignBundle\Values\Core\CampaignFolder;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Welp\MailchimpBundle\Exception\MailchimpException;
use JMS\TranslationBundle\Annotation\Ignore;

/**
 * Class CampaignController
 *
 * @package Smile\EzUICampaignBundle\Controller
 */
class CampaignController extends AbstractCampaignController
{
    /** @var string[] tab item names */
    protected $tabItems;

    /** @var CampaignsService $campaignsService Campaigns service */
    protected $campaignsService;

    /** @var CampaignService $campaignService Campaign service */
    protected $campaignService;

    /** @var ListsService $listsService Lists service */
    protected $listsService;

    /** @var ListService $listService */
    protected $listService;

    /** @var CampaignFolderService $campaignFolderService Campaign Folder service */
    protected $campaignFolderService;

    /** @var CampaignFoldersService $campaignFoldersService Campaign Folders service */
    protected $campaignFoldersService;

    /** @var CampaignActionDispatcher $campaignActionDispatcher */
    protected $campaignActionDispatcher;

    /** @var CampaignFolderActionDispatcher $campaignFolderActionDispatcher */
    protected $campaignFolderActionDispatcher;

    /**
     * CampaignController constructor.
     *
     * @param string[] $tabItems tab item names
     */
    public function __construct(
        $tabItems,
        CampaignsService $campaignsService,
        CampaignService $campaignService,
        ListsService $listsService,
        ListService $listService,
        CampaignFolderService $campaignFolderService,
        CampaignFoldersService $campaignFoldersService,
        CampaignActionDispatcher $campaignActionDispatcher,
        CampaignFolderActionDispatcher $campaignFolderActionDispatcher
    )
    {
        $this->tabItems = $tabItems;
        $this->campaignsService = $campaignsService;
        $this->campaignService = $campaignService;
        $this->listsService = $listsService;
        $this->listService = $listService;
        $this->campaignFolderService = $campaignFolderService;
        $this->campaignFoldersService = $campaignFoldersService;
        $this->campaignActionDispatcher = $campaignActionDispatcher;
        $this->campaignFolderActionDispatcher = $campaignFolderActionDispatcher;
    }

    /**
     * Render tab item content
     *
     * @param string $tabItem tab item name
     * @return Response
     */
    public function campaignAction($tabItem)
    {
        $this->performAccessChecks();
        return $this->render('SmileEzUICampaignBundle:campaign:index.html.twig', [
            'tab_items' => $this->tabItems,
            'tab_item_selected' => $tabItem,
            'params' => array(),
            'hasErrors' => false
        ]);
    }

    /**
     * Manage Campaigns Platform UI tabs
     *
     * @param string $tabItem
     * @param array $paramsTwig
     * @param bool  $hasErrors
     * @return Response
     */
    public function tabAction($tabItem, $paramsTwig = array(), $hasErrors = false)
    {
        $this->performAccessChecks();
        $tabItemMethod = 'tabItem' . ucfirst($tabItem);
        $params = $this->{$tabItemMethod}($paramsTwig);
        return $this->render('SmileEzUICampaignBundle:campaign:tab/' . $tabItem . '.html.twig', [
            'tab_items' => $this->tabItems,
            'tab_item' => $tabItem,
            'params' => $params
        ]);
    }

    /**
     * Display Platform UI Campaigns tab
     *
     * @param $paramsTwig
     * @return array
     */
    protected function tabItemCampaigns($paramsTwig)
    {
        $params['delete_forms_by_id'] = array();
        $params['campaigns'] = $this->campaignsService->get(0);

        foreach ($params['campaigns']['campaigns'] as $campaign) {
            $campaignID = $campaign['id'];
            $params['delete_forms_by_id'][$campaignID] = $this->createForm(
                CampaignDeleteType::class,
                ['campaignID' => $campaignID]
            )->createView();
        }

        return $params;
    }

    /**
     * Display Platform UI Lists tab
     *
     * @param $paramsTwig
     * @return array
     */
    protected function tabItemLists($paramsTwig)
    {
        $params['delete_forms_by_id'] = array();
        $params['lists'] = $this->listsService->get(0);

        foreach ($params['lists']['lists'] as $list) {
            $listID = $list['id'];
            $params['delete_forms_by_id'][$listID] = $this->createForm(
                CampaignListDeleteType::class,
                ['listID' => $listID]
            )->createView();
        }

        return $params;
    }

    /**
     * Display Campaign informations
     *
     * @param string $campaignID Campaign ID
     * @param bool $mode return json data if mode == 'ajax'
     * @return JsonResponse|Response
     */
    public function viewAction($campaignID, $mode = false)
    {
        if ($mode == 'ajax') {
            $response = new JsonResponse();
            $response->setData($this->campaignService->get($campaignID, array('settings.title')));
            return $response;
        } else {
            return $this->render('SmileEzUICampaignBundle:campaign:campaign/view.html.twig', [
                'campaign' => $this->campaignService->get($campaignID)
            ]);
        }
    }

    /**
     * Perform Campaign edit view
     *
     * @param Request $request
     * @param string|null $campaignID Campaign ID
     * @return \EzSystems\PlatformUIBundle\Http\FormProcessingDoneResponse|null|Response
     */
    public function editAction(Request $request, $campaignID = null)
    {
        if ($campaignID) {
            $campaign = $this->campaignService->get($campaignID);
            $folder = $this->campaignFolderService->get($campaign['settings']['folder_id']);
            $list = $this->listService->get($campaign['recipients']['list_id']);

            $campaign = new Campaign([
                'id' => $campaign['id'],
                'list_id' => $list['name'] . ' (id: ' . $list['id'] . ')',
                'subject_line' => $campaign['settings']['subject_line'],
                'title' => $campaign['settings']['title'],
                'from_name' => $campaign['settings']['from_name'],
                'reply_to' => $campaign['settings']['reply_to'],
                'folder_id' => $folder['title'] . ' (id: ' . $folder['id'] . ')'
            ]);
        } else {
            $campaign = new Campaign(['title' => '_new_']);
        }

        $data = (new CampaignMapper())->mapToFormData($campaign);
        $actionUrl = $this->generateUrl('smileezcampaign_campaign_edit', ['campaignID' => $campaignID]);
        $redirectUrl = $this->generateUrl('smileezcampaign_campaign', ['tabItem' => 'campaigns']);
        $form = $this->createForm(CampaignType::class, $data);
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $expr = "`^[^.]+ \(id: ([a-z0-9]*)\)$`";
                preg_match($expr, $data->list_id, $matches);
                $listID = ($matches && isset($matches[1])) ? $matches[1] : false;
                preg_match($expr, $data->folder_id, $matches);
                $folderID = ($matches && isset($matches[1])) ? $matches[1] : false;

                if ($campaignID) {
                    $this->campaignService->patch(
                        $campaignID, $listID, $data->subject_line, $data->title,
                        $data->from_name, $data->reply_to, $folderID
                    );
                    $this->notify('campaign.campaign.edited');
                } else {
                    $this->campaignService->post(
                        $listID, $data->subject_line, $data->title,
                        $data->from_name, $data->reply_to, $folderID
                    );
                    $this->notify('campaign.campaign.created');
                }
            } catch (MailchimpException $e) {
                /** @Ignore */
                $this->notifyError(
                    $e->getMessage(),
                    [],
                    'campaign'
                );

                return $this->render('SmileEzUICampaignBundle:campaign:campaign/edit.html.twig', [
                    'form' => $form->createView(),
                    'campaign' => $data,
                    'actionUrl' => $actionUrl,
                ]);
            }

            $this->campaignActionDispatcher->dispatchFormAction(
                $form,
                $data,
                $form->getClickedButton() ? $form->getClickedButton()->getName() : null
            );
            if ($response = $this->campaignActionDispatcher->getResponse()) {
                return $response;
            }

            return $this->redirectAfterFormPost($redirectUrl);
        }

        return $this->render('SmileEzUICampaignBundle:campaign:campaign/edit.html.twig', [
            'form' => $form->createView(),
            'campaign' => $data,
            'actionUrl' => $actionUrl,
        ]);
    }

    public function deleteAction(Request $request, $campaignID)
    {
        $redirectUrl = $this->generateUrl('smileezcampaign_campaign', ['tabItem' => 'campaigns']);

        $campaign = null;
        try {
            $campaign = $this->campaignService->get($campaignID);
        } catch (MailchimpException $e) {
            /** @Ignore */
            $this->notifyError(
                $e->getMessage(),
                [],
                'campaign'
            );
            return $this->redirectToRouteAfterFormPost($redirectUrl);
        }

        $deleteForm = $this->createForm(CampaignDeleteType::class, ['campaignID' => $campaignID]);
        $deleteForm->handleRequest($request);
        if ($deleteForm->isValid()) {
            try {
                $this->campaignService->delete($campaign['id']);
                $this->notify('campaign.campaign.deleted');
            } catch (MailchimpException $e) {
                /** @Ignore */
                $this->notifyError(
                    $e->getMessage(),
                    [],
                    'campaign'
                );
            }

            return $this->redirectAfterFormPost($redirectUrl);
        }

        // Form validation failed. Send errors as notifications.
        foreach ($deleteForm->getErrors(true) as $error) {
            $this->notifyErrorPlural(
                $error->getMessageTemplate(),
                $error->getMessagePluralization(),
                $error->getMessageParameters(),
                'campaign'
            );
        }

        return $this->redirectAfterFormPost($redirectUrl);
    }

    public function subscribeAction($campaignID, Request $request)
    {
        $response = new JsonResponse();

        try {
            $email = $request->request->get('email');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response->setStatusCode(400);

                $response->setData(array(
                    'message' => 'not a valid email'
                ));
            } else {
                $this->campaignService->subscribe($campaignID, $email);
            }
        } catch (MailchimpException $exception) {
            $response->setStatusCode(400);

            $response->setData(array(
                'message' => $exception->getTitle()
            ));
        }

        return $response;
    }

    public function editFolderAction(Request $request, $campaignFolderID = null)
    {
        if ($campaignFolderID) {
            $campaignFolder = $this->campaignFolderService->get($campaignFolderID);
        } else {
            $campaignFolder = new CampaignFolder(['name' => '_new_']);
        }

        $data = (new CampaignFolderMapper())->mapToFormData($campaignFolder);
        $actionUrl = $this->generateUrl('smileezcampaign_folder_edit', ['id' => $campaignFolderID]);
        $redirectUrl = $this->generateUrl('smileezcampaign_campaign');
        $form = $this->createForm(CampaignFolderType::class, $data);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->dispatchFormAction($this->campaignFolderActionDispatcher, $form, $data, array(
                'name' => $data->name
            ));

            try {
                $this->campaignFolderService->post($data->name);
                $this->notify('campaign.folder.created');
            } catch (MailchimpException $e) {
                $this->notifyError(
                    'campaign.folder.cannot_create'
                );
            }

            if ($response = $this->campaignFolderActionDispatcher->getResponse()) {
                return $response;
            }

            return $this->redirectAfterFormPost($redirectUrl);
        }

        return $this->render('SmileEzUICampaignBundle:campaign:campaignFolders/edit.html.twig', [
            'form' => $form->createView(),
            'campaignFolder' => $data,
            'actionUrl' => $actionUrl,
        ]);
    }

    public function allFoldersAction($query)
    {
        $response = new JsonResponse();
        $folders = array();
        $offset = 0;
        $limit = 10;

        $campaignFolders = $this->campaignFoldersService->get($offset, $limit);
        while (count($campaignFolders['folders']) != 0) {
            foreach ($campaignFolders['folders'] as $folder) {
                if (strpos($folder['name'], $query) !== false) {
                    $folders[] = $folder['name'] . ' (id: ' . $folder['id'] . ')';
                }
            }

            $offset += 10;
            $campaignFolders = $this->campaignFoldersService->get($offset, $limit);
        }

        $response->setData($folders);

        return $response;
    }

    protected function dispatchFormAction(
        ActionDispatcherInterface $actionDispatcher,
        Form $form,
        ValueObject $data,
        array $options
    ) {
        $actionDispatcher->dispatchFormAction(
            $form,
            $data,
            $form->getClickedButton() ? $form->getClickedButton()->getName() : null,
            $options
        );
    }
}

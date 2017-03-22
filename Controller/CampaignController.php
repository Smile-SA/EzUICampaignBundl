<?php

namespace Smile\EzUICampaignBundle\Controller;

use EzSystems\RepositoryForms\Form\ActionDispatcher\ActionDispatcherInterface;
use Smile\EzUICampaignBundle\Data\Mapper\CampaignMapper;
use Smile\EzUICampaignBundle\Form\Type\CampaignType;
use Smile\EzUICampaignBundle\Service\CampaignService;
use Smile\EzUICampaignBundle\Service\CampaignsService;
use Smile\EzUICampaignBundle\Service\ListsService;
use Smile\EzUICampaignBundle\Values\Campaign;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Welp\MailchimpBundle\Exception\MailchimpException;

class CampaignController extends AbstractCampaignController
{
    /** @var string[] tab item names */
    protected $tabItems;

    /** @var CampaignsService $campaignsService */
    protected $campaignsService;

    /** @var CampaignService $campaignService */
    protected $campaignService;

    /** @var ListsService $listsService */
    protected $listsService;

    /** @var ActionDispatcherInterface $campaignActionDispatcher */
    protected $campaignActionDispatcher;

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
        ActionDispatcherInterface $campaignActionDispatcher
    )
    {
        $this->tabItems = $tabItems;
        $this->campaignsService = $campaignsService;
        $this->campaignService = $campaignService;
        $this->listsService = $listsService;
        $this->campaignActionDispatcher = $campaignActionDispatcher;
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
     * @param $paramsTwig
     * @return array
     */
    protected function tabItemCampaigns($paramsTwig)
    {
        $params['campaigns'] = $this->campaignsService->get(0);

        return $params;
    }

    /**
     * @param $paramsTwig
     * @return array
     */
    protected function tabItemLists($paramsTwig)
    {
        $params['lists'] = $this->listsService->get(0);

        return $params;
    }

    public function viewAction($id, $mode = false)
    {
        if ($mode == 'ajax') {
            $response = new JsonResponse();
            $response->setData($this->campaignService->get($id, array('settings.title')));
            return $response;
        } else {
            return $this->render('SmileEzUICampaignBundle:campaign:campaign/view.html.twig', [
                'campaign' => $this->campaignService->get($id)
            ]);
        }
    }

    public function editAction(Request $request, $campaignID = null)
    {
        if ($campaignID) {
            $campaign = $this->campaignService->get($campaignID);
        } else {
            $campaign = new Campaign(['settings' => ['title' => '_new_'], 'recipients' => ['list_id' => '_new_']]);
        }

        $data = (new CampaignMapper())->mapToFormData($campaign);
        $actionUrl = $this->generateUrl('admin_contenttypeGroupEdit', ['campaignID' => $campaignID]);
        $form = $this->createForm(CampaignType::class, $data);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->campaignActionDispatcher->dispatchFormAction(
                $form,
                $data,
                $form->getClickedButton() ? $form->getClickedButton()->getName() : null
            );
            if ($response = $this->campaignActionDispatcher->getResponse()) {
                return $response;
            }

            return $this->redirectAfterFormPost($actionUrl);
        }

        return $this->render('SmileEzUICampaignBundle::content_fields.html.twig', [
            'form' => $form->createView(),
            'campaign' => $data,
            'actionUrl' => $actionUrl,
        ]);
    }

    public function subscribeAction($id, Request $request)
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
                $this->campaignService->subscribe($id, $email);
            }
        } catch (MailchimpException $exception) {
            $response->setStatusCode(400);

            $response->setData(array(
                'message' => $exception->getTitle()
            ));
        }

        return $response;
    }
}

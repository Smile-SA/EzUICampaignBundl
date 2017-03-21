<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\CampaignService;
use Smile\EzUICampaignBundle\Service\CampaignsService;
use Smile\EzUICampaignBundle\Service\ListsService;
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

    protected $campaignService;

    /** @var ListsService $listsService */
    protected $listsService;

    /**
     * CampaignController constructor.
     *
     * @param string[] $tabItems tab item names
     */
    public function __construct(
        $tabItems,
        CampaignsService $campaignsService,
        CampaignService $campaignService,
        ListsService $listsService
    )
    {
        $this->tabItems = $tabItems;
        $this->campaignsService = $campaignsService;
        $this->campaignService = $campaignService;
        $this->listsService = $listsService;
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

    public function viewAction($id)
    {
        return $this->render('SmileEzUICampaignBundle:campaign:campaign/view.html.twig', [
            'campaign' => $this->campaignService->get($id)
        ]);
    }

    public function editAction($id)
    {
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

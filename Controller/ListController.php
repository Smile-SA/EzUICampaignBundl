<?php

namespace Smile\EzUICampaignBundle\Controller;

use EzSystems\RepositoryForms\Form\ActionDispatcher\ActionDispatcherInterface;
use Smile\EzUICampaignBundle\Data\Mapper\CampaignListMapper;
use Smile\EzUICampaignBundle\Form\Type\CampaignListType;
use Smile\EzUICampaignBundle\Service\ListService;
use Smile\EzUICampaignBundle\Values\CampaignList;
use Symfony\Component\HttpFoundation\Request;

class ListController extends AbstractCampaignController
{
    /** @var ListService $listService */
    protected $listService;

    /** @var ActionDispatcherInterface $campaignListActionDispatcher */
    protected $campaignListActionDispatcher;

    public function __construct(
        ListService $listService,
        ActionDispatcherInterface $campaignListActionDispatcher
    )
    {
        $this->listService = $listService;
        $this->campaignListActionDispatcher = $campaignListActionDispatcher;
    }

    public function viewAction($id)
    {
        return $this->render('SmileEzUICampaignBundle:campaign:list/view.html.twig', [
            'list' => $this->listService->get($id)
        ]);
    }

    public function editAction(Request $request, $campaignListID = null)
    {
        if ($campaignListID) {
            $campaignList = $this->listService->get($campaignListID);
        } else {
            $campaignList = new CampaignList(['name' => '_new_']);
        }

        $data = (new CampaignListMapper())->mapToFormData($campaignList);
        $actionUrl = $this->generateUrl('smileezcampaign_list_edit', ['id' => $campaignListID]);
        $form = $this->createForm(CampaignListType::class, $data);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->campaignListActionDispatcher->dispatchFormAction(
                $form,
                $data,
                $form->getClickedButton() ? $form->getClickedButton()->getName() : null
            );
            if ($response = $this->campaignListActionDispatcher->getResponse()) {
                return $response;
            }

            return $this->redirectAfterFormPost($actionUrl);
        }

        return $this->render('SmileEzUICampaignBundle:campaign:list/edit.html.twig', [
            'form' => $form->createView(),
            'campaignList' => $data,
            'actionUrl' => $actionUrl,
        ]);
    }
}

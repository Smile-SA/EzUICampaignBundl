<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Data\Mapper\CampaignListMapper;
use Smile\EzUICampaignBundle\Form\ActionDispatcher\CampaignListActionDispatcher;
use Smile\EzUICampaignBundle\Form\Type\CampaignListDeleteType;
use Smile\EzUICampaignBundle\Form\Type\CampaignListType;
use Smile\EzUICampaignBundle\Service\ListService;
use Smile\EzUICampaignBundle\Values\Core\CampaignList;
use Symfony\Component\HttpFoundation\Request;
use Welp\MailchimpBundle\Exception\MailchimpException;
use JMS\TranslationBundle\Annotation\Ignore;

class ListController extends AbstractCampaignController
{
    /** @var ListService $listService */
    protected $listService;

    /** @var CampaignListActionDispatcher $campaignListActionDispatcher */
    protected $campaignListActionDispatcher;

    public function __construct(
        ListService $listService,
        CampaignListActionDispatcher $campaignListActionDispatcher
    )
    {
        $this->listService = $listService;
        $this->campaignListActionDispatcher = $campaignListActionDispatcher;
    }

    public function viewAction($campaignListID)
    {
        return $this->render('SmileEzUICampaignBundle:campaign:list/view.html.twig', [
            'list' => $this->listService->get($campaignListID)
        ]);
    }

    public function editAction(Request $request, $campaignListID = null)
    {
        if ($campaignListID) {
            $campaignList = $this->listService->get($campaignListID);
            $campaignList = new CampaignList([
                'id' => $campaignList['id'],
                'name' => $campaignList['name'],
                'company' => $campaignList['contact']['company'],
                'address' => $campaignList['contact']['address1'],
                'city' => $campaignList['contact']['city'],
                'state' => $campaignList['contact']['state'],
                'zip' => $campaignList['contact']['zip'],
                'country' => $campaignList['contact']['country'],
                'permission_reminder' => $campaignList['permission_reminder'],
                'from_name' => $campaignList['campaign_defaults']['from_name'],
                'from_email' => $campaignList['campaign_defaults']['from_email'],
                'subject' => $campaignList['campaign_defaults']['subject'],
                'language' => $campaignList['campaign_defaults']['language']
            ]);
        } else {
            $campaignList = new CampaignList(['name' => '_new_']);
        }

        $data = (new CampaignListMapper())->mapToFormData($campaignList);
        $actionUrl = $this->generateUrl('smileezcampaign_list_edit', ['campaignListID' => $campaignListID]);
        $redirectUrl = $this->generateUrl('smileezcampaign_campaign', ['tabItem' => 'lists']);
        $form = $this->createForm(CampaignListType::class, $data);
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                if ($campaignListID) {
                    $this->listService->patch(
                        $campaignListID, $data->name, $data->company, $data->address,
                        $data->city, $data->state, $data->zip, $data->country, $data->permission_reminder,
                        $data->from_name, $data->from_email, $data->subject, $data->language
                    );
                    $this->notify('campaign.list.edited');
                } else {
                    $this->listService->post(
                        $data->name, $data->company, $data->address,
                        $data->city, $data->state, $data->zip, $data->country, $data->permission_reminder,
                        $data->from_name, $data->from_email, $data->subject, $data->language
                    );
                    $this->notify('campaign.list.created');
                }
            } catch (MailchimpException $e) {
                /** @Ignore */
                $this->notifyError(
                    $e->getMessage(),
                    [],
                    'campaign_list'
                );

                return $this->render('SmileEzUICampaignBundle:campaign:list/edit.html.twig', [
                    'form' => $form->createView(),
                    'campaignList' => $data,
                    'actionUrl' => $actionUrl,
                ]);
            }

            $this->campaignListActionDispatcher->dispatchFormAction(
                $form,
                $data,
                $form->getClickedButton() ? $form->getClickedButton()->getName() : null
            );
            if ($response = $this->campaignListActionDispatcher->getResponse()) {
                return $response;
            }

            return $this->redirectAfterFormPost($redirectUrl);
        }

        return $this->render('SmileEzUICampaignBundle:campaign:list/edit.html.twig', [
            'form' => $form->createView(),
            'campaignList' => $data,
            'actionUrl' => $actionUrl,
        ]);
    }

    public function deleteAction(Request $request, $campaignListID)
    {
        $redirectUrl = $this->generateUrl('smileezcampaign_campaign', ['tabItem' => 'lists']);

        $list = null;
        try {
            $list = $this->listService->get($campaignListID);
        } catch (MailchimpException $e) {
            /** @Ignore */
            $this->notifyError(
                $e->getMessage(),
                [],
                'campaign_list'
            );
            return $this->redirectToRouteAfterFormPost($redirectUrl);
        }

        $deleteForm = $this->createForm(CampaignListDeleteType::class, ['campaignListID' => $campaignListID]);
        $deleteForm->handleRequest($request);
        if ($deleteForm->isValid()) {
            try {
                $this->listService->delete($list['id']);
                $this->notify('campaign.list.deleted');
            } catch (MailchimpException $e) {
                /** @Ignore */
                $this->notifyError(
                    $e->getMessage(),
                    [],
                    'campaign_list'
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
                'campaign_list'
            );
        }

        return $this->redirectAfterFormPost($redirectUrl);
    }
}

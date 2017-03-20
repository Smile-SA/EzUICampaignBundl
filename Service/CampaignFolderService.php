<?php

namespace Smile\EzUICampaignBundle\Service;

use DrewM\MailChimp\MailChimp;

class CampaignFolderService
{
    /** @var MailChimp $mailChimp */
    protected $mailChimp;

    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

    public function get($campaignFolderID)
    {
        $campaignFolder = $this->mailChimp->get('/campaign-folders/' . $campaignFolderID, array());

        if (!$this->mailChimp->success() || !$campaignFolder
            || (isset($campaignFolder['status']) && is_int($campaignFolder['status']))) {
            $campaignFolder = false;
        }

        return $campaignFolder;
    }

    public function post($name)
    {
        $return = $this->mailChimp->post('/campaign-folders', array(
            'name' => $name
        ));

        if (!$this->mailChimp->success() || !$return
            || (isset($return['status']) && is_int($return['status']))) {
            $return = false;
        }

        return $return;
    }

    public function patch($campaignFolderID, $name)
    {
        $return = $this->mailChimp->patch('/campaign-folders/' . $campaignFolderID, array(
            'name' => $name,
        ));

        if (!$this->mailChimp->success() || !$return
            || (isset($return['status']) && is_int($return['status']))) {
            $return = false;
        }

        return $return;
    }
}

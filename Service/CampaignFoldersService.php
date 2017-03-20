<?php

namespace Smile\EzUICampaignBundle\Service;

use DrewM\MailChimp\MailChimp;

class CampaignFoldersService
{
    /** @var MailChimp $mailChimp */
    protected $mailChimp;

    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

    public function get($offset = 0, $count = 10)
    {
        $campaignFolders = $this->mailChimp->get('/campaign-folders', array(
            'offset' => $offset,
            'count' => $count
        ));

        if (!$this->mailChimp->success() || !$campaignFolders
            || (isset($campaignFolders['status']) && is_int($campaignFolders['status']))) {
            $campaignFolders = array(
                'folders' => array(),
                'total_items' => 0
            );
        }

        return $campaignFolders;
    }
}

<?php

namespace Smile\EzUICampaignBundle\Service;

class CampaignFoldersService extends BaseService
{
    public function get($offset = 0, $count = 10)
    {
        $campaignFolders = $this->mailChimp->get('/campaign-folders', array(
            'offset' => $offset,
            'count' => $count
        ));

        if (!$this->mailChimp->success()) {
            $campaignFolders = array(
                'folders' => array(),
                'total_items' => 0
            );
        }

        return $campaignFolders;
    }
}

<?php

namespace Smile\EzUICampaignBundle\Service;

class CampaignsService extends BaseService
{
    public function get($offset = 0, $count = 10)
    {
        $campaigns = $this->mailChimp->get('/campaigns', array(
            'offset' => $offset,
            'count' => $count
        ));

        if (!$this->mailChimp->success()) {
            $campaigns = array(
                'campaigns' => array(),
                'total_items' => 0
            );
        }

        return $campaigns;
    }
}

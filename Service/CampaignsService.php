<?php

namespace Smile\EzUICampaignBundle\Service;

use DrewM\MailChimp\MailChimp;

class CampaignsService
{
    /** @var MailChimp $mailChimp */
    protected $mailChimp;

    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

    public function get($offset = 0, $count = 10)
    {
        $campaigns = $this->mailChimp->get('/campaigns', array(
            'offset' => $offset,
            'count' => $count
        ));

        if (!$this->mailChimp->success() || !$campaigns) {
            $campaigns = array(
                'campaigns' => array(),
                'total_items' => 0
            );
        }

        return $campaigns;
    }
}

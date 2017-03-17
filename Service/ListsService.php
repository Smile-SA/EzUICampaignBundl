<?php

namespace Smile\EzUICampaignBundle\Service;

use DrewM\MailChimp\MailChimp;

class ListsService
{
    /** @var MailChimp $mailChimp */
    protected $mailChimp;

    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

    public function get($offset = 0, $count = 10)
    {
        $lists = $this->mailChimp->get('/lists', array(
            'offset' => $offset,
            'count' => $count
        ));

        if (!$this->mailChimp->success() || !$lists) {
            $lists = array(
                'lists' => array(),
                'total_items' => 0
            );
        }

        return $lists;
    }
}

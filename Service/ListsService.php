<?php

namespace Smile\EzUICampaignBundle\Service;

class ListsService extends BaseService
{
    public function get($offset = 0, $count = 10)
    {
        $lists = $this->mailChimp->get('/lists', array(
            'offset' => $offset,
            'count' => $count
        ));

        if (!$this->mailChimp->success()) {
            $lists = array(
                'lists' => array(),
                'total_items' => 0
            );
        }

        return $lists;
    }
}

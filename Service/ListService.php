<?php

namespace Smile\EzUICampaignBundle\Service;

use DrewM\MailChimp\MailChimp;

class ListService
{
    /** @var MailChimp $mailChimp */
    protected $mailChimp;

    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }
}
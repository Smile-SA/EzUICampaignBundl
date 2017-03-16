<?php

namespace Smile\EzUICampaignBundle\Controller;

use DrewM\MailChimp\MailChimp;

class CampaignsController extends AbstractCampaignController
{
    /** @var MailChimp $mailChimpService mailchimp service */
    protected $mailChimpService;

    public function __construct(MailChimp $mailChimpService)
    {
        $this->mailChimpService = $mailChimpService;
    }
}

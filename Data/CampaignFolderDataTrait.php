<?php

namespace Smile\EzUICampaignBundle\Data;

use Smile\EzUICampaignBundle\Values\API\CampaignFolder;

trait CampaignFolderDataTrait
{
    /**
     * @var CampaignFolder $campaignFolder
     */
    protected $campaignFolder;

    public function setCampaignFolder(CampaignFolder $campaignFolder)
    {
        $this->campaignFolder = $campaignFolder;
    }

    public function getId()
    {
        return $this->campaignFolder ? $this->campaignFolder->id : null;
    }
}

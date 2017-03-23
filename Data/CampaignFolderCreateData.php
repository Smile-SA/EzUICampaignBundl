<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessCheckable;
use Smile\EzUICampaignBundle\Values\API\CampaignFolder;
use Smile\EzUICampaignBundle\Values\CampaignFolderCreateStruct;

/**
 * @property-read CampaignFolder $campaignFolder
 */
class CampaignFolderCreateData extends CampaignFolderCreateStruct implements NewnessCheckable
{
    use CampaignFolderDataTrait;

    public function isNew()
    {
        return true;
    }
}

<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessCheckable;
use Smile\EzUICampaignBundle\Values\CampaignFolderCreateStruct;

class CampaignFolderCreateData extends CampaignFolderCreateStruct implements NewnessCheckable
{
    use CampaignFolderDataTrait;

    public function isNew()
    {
        return true;
    }
}

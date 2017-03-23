<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessChecker;
use Smile\EzUICampaignBundle\Values\CampaignFolderUpdateStruct;

class CampaignFolderUpdateData extends CampaignFolderUpdateStruct
{
    use CampaignFolderDataTrait, NewnessChecker;

    protected function getIdValue()
    {
        return $this->campaignFolder->id;
    }

    protected function getIdentifierValue()
    {
        return null;
    }
}

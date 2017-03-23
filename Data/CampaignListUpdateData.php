<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessChecker;
use Smile\EzUICampaignBundle\Values\CampaignListUpdateStruct;

class CampaignListUpdateData extends CampaignListUpdateStruct
{
    use CampaignListDataTrait, NewnessChecker;

    protected function getIdValue()
    {
        return $this->campaignList->id;
    }

    protected function getIdentifierValue()
    {
        return null;
    }
}

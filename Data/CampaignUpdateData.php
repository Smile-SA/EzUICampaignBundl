<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessChecker;
use Smile\EzUICampaignBundle\Values\CampaignUpdateStruct;

class CampaignUpdateData extends CampaignUpdateStruct
{
    use CampaignDataTrait, NewnessChecker;

    protected function getIdValue()
    {
        return $this->campaign->id;
    }

    protected function getIdentifierValue()
    {
        return null;
    }
}

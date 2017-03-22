<?php

namespace Smile\EzUICampaignBundle\Data\Mapper;

use eZ\Publish\API\Repository\Values\ValueObject;
use EzSystems\RepositoryForms\Data\Mapper\FormDataMapperInterface;
use Smile\EzUICampaignBundle\Data\CampaignCreateData;
use Smile\EzUICampaignBundle\Data\CampaignUpdateData;
use Smile\EzUICampaignBundle\Values\AbstractCampaign;
use Smile\EzUICampaignBundle\Values\CampaignCreateStruct;

class CampaignMapper implements FormDataMapperInterface
{
    /**
     * Maps a ValueObject from eZ content repository to a data usable as underlying form data (e.g. create/update struct).
     *
     * @param ValueObject|AbstractCampaign $campaign
     * @param array $params
     *
     * @return CampaignCreateData|CampaignUpdateData
     */
    public function mapToFormData(ValueObject $campaign, array $params = [])
    {
        if (!$this->isCampaignNew($campaign)) {
            $data = new CampaignUpdateData(['campaign' => $campaign]);
        } else {
            $data = new CampaignCreateStruct(['campaign' => $campaign]);
        }

        return $data;
    }

    private function isCampaignNew(AbstractCampaign $campaign)
    {
        return $campaign->id === null;
    }
}

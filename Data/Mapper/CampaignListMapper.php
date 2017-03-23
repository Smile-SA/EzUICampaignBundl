<?php

namespace Smile\EzUICampaignBundle\Data\Mapper;

use eZ\Publish\API\Repository\Values\ValueObject;
use EzSystems\RepositoryForms\Data\Mapper\FormDataMapperInterface;
use Smile\EzUICampaignBundle\Data\CampaignListCreateData;
use Smile\EzUICampaignBundle\Data\CampaignListUpdateData;
use Smile\EzUICampaignBundle\Values\API\CampaignList;

class CampaignListMapper  implements FormDataMapperInterface
{
    /**
     * Maps a ValueObject from eZ content repository to a data usable as underlying form data (e.g. create/update struct).
     *
     * @param ValueObject|CampaignList $campaignList
     * @param array $params
     *
     * @return CampaignListCreateData|CampaignListUpdateData
     */
    public function mapToFormData(ValueObject $campaignList, array $params = [])
    {
        if (!$this->isCampaignListNew($campaignList)) {
            $data = new CampaignListUpdateData(['campaignList' => $campaignList]);
        } else {
            $data = new CampaignListCreateData(['campaignList' => $campaignList]);
        }

        return $data;
    }

    private function isCampaignListNew(CampaignList $campaignList)
    {
        return $campaignList->id === null;
    }
}

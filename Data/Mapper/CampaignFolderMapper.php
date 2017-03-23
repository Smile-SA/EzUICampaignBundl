<?php

namespace Smile\EzUICampaignBundle\Data\Mapper;

use eZ\Publish\API\Repository\Values\ValueObject;
use EzSystems\RepositoryForms\Data\Mapper\FormDataMapperInterface;
use Smile\EzUICampaignBundle\Data\CampaignFolderCreateData;
use Smile\EzUICampaignBundle\Data\CampaignFolderUpdateData;
use Smile\EzUICampaignBundle\Values\AbstractCampaignFolder;
use Smile\EzUICampaignBundle\Values\CampaignFolder;

class CampaignFolderMapper implements FormDataMapperInterface
{
    /**
     * Maps a ValueObject from eZ content repository to a data usable as underlying form data (e.g. create/update struct).
     *
     * @param ValueObject|CampaignFolder $campaignFolder
     * @param array $params
     *
     * @return CampaignFolderCreateData|CampaignFolderUpdateData
     */
    public function mapToFormData(ValueObject $campaignFolder, array $params = [])
    {
        if (!$this->isCampaignFolderNew($campaignFolder)) {
            $data = new CampaignFolderUpdateData(['campaignFolder' => $campaignFolder]);
        } else {
            $data = new CampaignFolderCreateData(['campaignFolder' => $campaignFolder]);
        }

        return $data;
    }

    private function isCampaignFolderNew(CampaignFolder $campaignFolder)
    {
        return $campaignFolder->id === null;
    }
}

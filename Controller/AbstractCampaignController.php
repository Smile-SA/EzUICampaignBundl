<?php

namespace Smile\EzUICampaignBundle\Controller;

use eZ\Publish\Core\MVC\Symfony\Security\Authorization\Attribute as AuthorizationAttribute;
use eZ\Publish\Core\MVC\Symfony\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AbstractCampaignController extends Controller
{
    /**
     * Perform access check for campaigns policy
     */
    protected function performCampaignsAccessChecks()
    {
        if (!$this->isGranted(new AuthorizationAttribute('uicampaign', 'campaigns'))) {
            throw new AccessDeniedException();
        }
    }

    /**
     * Perform access check for lists policy
     */
    protected function performListsAccessChecks()
    {
        if (!$this->isGranted(new AuthorizationAttribute('uicampaign', 'lists'))) {
            throw new AccessDeniedException();
        }
    }

    protected function performAccessChecks()
    {
        return $this->performCampaignsAccessChecks() || $this->performListsAccessChecks();
    }
}

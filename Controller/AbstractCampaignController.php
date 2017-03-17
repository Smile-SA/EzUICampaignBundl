<?php

namespace Smile\EzUICampaignBundle\Controller;

use eZ\Publish\Core\MVC\Symfony\Security\Authorization\Attribute as AuthorizationAttribute;
use EzSystems\PlatformUIBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AbstractCampaignController extends Controller
{
    /**
     * Perform access check for campaigns policy
     */
    public function performCampaignsAccessChecks()
    {
        if (!$this->isGranted(new AuthorizationAttribute('uicampaign', 'campaigns'))) {
            throw new AccessDeniedException();
        }
    }

    /**
     * Perform access check for lists policy
     */
    public function performListsAccessChecks()
    {
        if (!$this->isGranted(new AuthorizationAttribute('uicampaign', 'lists'))) {
            throw new AccessDeniedException();
        }
    }

    public function performAccessChecks()
    {
        return $this->performCampaignsAccessChecks() || $this->performListsAccessChecks();
    }
}

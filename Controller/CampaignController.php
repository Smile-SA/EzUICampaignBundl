<?php

namespace Smile\EzUICampaignBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class CampaignController extends AbstractCampaignController
{
    /** @var string[] tab item names */
    protected $tabItems;

    /**
     * CampaignController constructor.
     *
     * @param string[] $tabItems tab item names
     */
    public function __construct($tabItems)
    {
        $this->tabItems = $tabItems;
    }

    /**
     * Render tab item content
     *
     * @param string $tabItem tab item name
     * @return Response
     */
    public function campaignAction($tabItem)
    {
        $this->performAccessChecks();
        return $this->render('SmileEzUICampaignBundle:campaign:index.html.twig', [
            'tab_items' => $this->tabItems,
            'tab_item_selected' => $tabItem,
            'params' => array(),
            'hasErrors' => false
        ]);
    }

    /**
     * @param string $tabItem
     * @param array $paramsTwig
     * @param bool  $hasErrors
     * @return Response
     */
    public function tabAction($tabItem, $paramsTwig = array(), $hasErrors = false)
    {
        $this->performAccessChecks();
        $tabItemMethod = 'tabItem' . ucfirst($tabItem);
        $params = $this->{$tabItemMethod}($paramsTwig);
        return $this->render('SmileEzUICampaignBundle:campaign:tab/' . $tabItem . '.html.twig', [
            'tab_items' => $this->tabItems,
            'tab_item' => $tabItem,
            'params' => $params
        ]);
    }

    /**
     * @param $paramsTwig
     * @return array
     */
    protected function tabItemCampaigns($paramsTwig)
    {
        return array();
    }

    /**
     * @param $paramsTwig
     * @return array
     */
    protected function tabItemLists($paramsTwig)
    {
        return array();
    }
}

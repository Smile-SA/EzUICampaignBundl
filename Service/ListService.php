<?php

namespace Smile\EzUICampaignBundle\Service;

class ListService extends BaseService
{
    public function get($listID)
    {
        $list = $this->mailChimp->get('/lists/' . $listID, array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $list;
    }

    public function post($name, $company, $address, $city, $state, $zip, $country)
    {
        $return = $this->mailChimp->post('/lists', array(
            'name' => $name,
            'contact' => array(
                'company' => $company,
                'address1' => $address,
                'city' => $city,
                'state' => $state,
                'zip' => $zip,
                'country' => $country
            )
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function patch($listID, $name, $company, $address, $city, $state, $zip, $country)
    {
        $return = $this->mailChimp->patch('/lists/' . $listID, array(
            'name' => $name,
            'contact' => array(
                'company' => $company,
                'address1' => $address,
                'city' => $city,
                'state' => $state,
                'zip' => $zip,
                'country' => $country
            )
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function delete($listID)
    {
        $return = $this->mailChimp->delete('/lists/' . $listID, array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function subscribe($listID, $email)
    {
        $return = $this->mailChimp->post('/lists/' . $listID, array(
            'members' => array(
                array(
                    'email_address' => $email,
                    'status' => 'subscribed'
                )
            ),
            'update_existing' => true
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function unsubscribe($listID, $email)
    {
        $return = $this->mailChimp->post('/lists/' . $listID, array(
            'members' => array(
                array(
                    'email_address' => $email,
                    'status' => 'unsubscribed'
                )
            ),
            'update_existing' => true
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }
}

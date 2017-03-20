<?php

namespace Smile\EzUICampaignBundle\Service;

class CampaignService extends BaseService
{
    public function get($campaignID)
    {
        $campaign = $this->mailChimp->get('/campaigns/' . $campaignID, array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $campaign;
    }

    public function post($listID, $subjectLine, $title, $fromName, $replyTo, $folderID)
    {
        $return = $this->mailChimp->post('/campaigns', array(
            'type' => 'regular',
            'recipients' => array(
                'list_id' => $listID
            ),
            'settings' => array(
                'subject_line' => $subjectLine,
                'title' => $title,
                'fromName' => $fromName,
                'reply_to' => $replyTo,
                'folder_id' => $folderID
            )
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function patch($campaignID, $listID, $subjectLine, $title, $fromName, $replyTo, $folderID)
    {
        $return = $this->mailChimp->patch('/campaigns/' . $campaignID, array(
            'recipients' => array(
                'list_id' => $listID
            ),
            'settings' => array(
                'subject_line' => $subjectLine,
                'title' => $title,
                'fromName' => $fromName,
                'reply_to' => $replyTo,
                'folder_id' => $folderID
            )
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function delete($campaignID)
    {
        $return = $this->mailChimp->delete('/campaigns/' . $campaignID, array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function test($campaignID, $email)
    {
        $return = $this->mailChimp->post('/campaigns/' . $campaignID . '/actions/test', array(
            'test_emails' => array($email),
            'send_type' => 'html'
        ));

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function send($campaignID)
    {
        $return = $this->mailChimp->post('/campaigns/' . $campaignID . '/actions/send', array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function pause($campaignID)
    {
        $return = $this->mailChimp->post('/campaigns/' . $campaignID . '/actions/pause', array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function resume($campaignID)
    {
        $return = $this->mailChimp->post('/campaigns/' . $campaignID . '/actions/resume', array());

        if (!$this->mailChimp->success()) {
            $this->throwMailchimpError($this->mailChimp->getLastResponse());
        }

        return $return;
    }

    public function schedule($campaignID, $scheduleTime)
    {
        $return = $this->mailChimp->post('/campaigns/' . $campaignID . '/actions/schedule', array(
            'schedule_time' => $scheduleTime
        ));

        if (!$this->mailChimp->success() || !$return
            || (isset($return['status']) && is_int($return['status']))) {
            $return = false;
        }

        return $return;
    }

    public function unschedule($campaignID)
    {
        $return = $this->mailChimp->post('/campaigns/' . $campaignID . '/actions/unschedule', array());

        if (!$this->mailChimp->success() || !$return
            || (isset($return['status']) && is_int($return['status']))) {
            $return = false;
        }

        return $return;
    }
}

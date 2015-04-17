<?php

namespace serverdensity\Api;

class Devices extends AbstractApi
{


    /**
    * View device by ID
    * @link     https://apidocs.serverdensity.com/?shell#view-device-by-id
    * @param    string  $id the id of the device.
    * @return   an array that is the device.
    */
    public function view($id){
        return $this->get('inventory/devices/'.rawurlencode($id));
    }
}

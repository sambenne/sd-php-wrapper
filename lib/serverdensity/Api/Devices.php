<?php

namespace serverdensity\Api;

class Devices extends AbstractApi
{
    /**
    * Create a device
    * @link     https://apidocs.serverdensity.com/?shell#creating-a-device
    * @param    array  $id the id of the device.
    * @return   an array that is the device.
    */
    public function create($device){
        return $this->post('inventory/devices/', $device);
    }

    /**
    * Delete device by ID
    * @link     https://apidocs.serverdensity.com/?shell#deleting-a-device
    * @param    string  $id the id of the device.
    * @return   an array with the device id that got deleted.
    */
    public function destroy($id){
        return $this->delete('inventory/devices/'.rawurlencode($id));
    }

    /**
    * Delete device by ID
    * @link     https://apidocs.serverdensity.com/?shell#listing-all-devices
    * @return   an array of arrays with devices.
    */
    public function all(){
        return $this->get('inventory/devices/');
    }

    /**
    * Search for a device
    * @link     https://apidocs.serverdensity.com/?python#searching-for-a-device
    * @param    array   $filter     an array of fields to map to.
    * @param    array   $fields     an array of fields to keep in output.
    * @return   an array of arrays with devices.
    */
    public function search(array $filter, array $fields = array()){

        $param = array(
            'filter' => json_encode($filter),
            'fields' => json_encode($fields)
        );
        return $this->get('inventory/resources/', $param);
    }

    /**
    * Update device by ID
    * @link     https://apidocs.serverdensity.com/?python#updating-a-device
    * @param    string  $id     an id of the device
    * @return   an array of arrays with devices.
    */
    public function update($id){
        return $this->put('inventory/devices/'.rawurlencode($id));
    }

    /**
    * View device by Agentkey
    * @link     https://apidocs.serverdensity.com/?python#view-device-by-agent-key
    * @param    string  $agentKey    the agentKey of the device
    * @return   an array with the device.
    */
    public function viewByAgent($agentKey){
        return $this->get('inventory/devices/'.rawurlencode($agentKey).'/byagentkey/');
    }

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

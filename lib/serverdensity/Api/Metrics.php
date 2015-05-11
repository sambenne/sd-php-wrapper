<?php

namespace serverdensity\Api;

class Metrics extends AbstractApi
{
    /**
    * Get available metrics
    * @link     https://apidocs.serverdensity.com/?python#available-metrics
    * @param    string      $id     the subjectID to get available metrics
    * @param    timestamp   $start  the start of the period.
    * @param    timestamp   $end    the end of the period
    * @return   an array that is all available metrics.
    */
    public function available($id, $start, $end){
        $param = array(
            'start' => date("Y-m-d\TH:i:s\Z", $start),
            'end' => date("Y-m-d\TH:i:s\Z", $end)
        );

        return $this->get('metrics/definitions/'.urlencode($id), $param);
    }


    /**
    * Get actual metrics
    * @link     https://apidocs.serverdensity.com/?python#get-metrics
    * @param    string      $id     the subjectID to get available metrics
    * @param    array       $filter an array of what you want to filter
    * @param    timestamp   $start  the start of the period.
    * @param    timestamp   $end    the end of the period
    * @return   an array that is all available metrics.
    */
    public function metrics($id, $filter, $start, $end){
        $param = array(
            'start' => date("Y-m-d\TH:i:s\Z", $start),
            'end' => date("Y-m-d\TH:i:s\Z", $end),
            'filter' => $filter
        );

        $param = $this->makeJsonReady($param);

        return $this->get('metrics/graphs/'.urlencode($id), $param);
    }

}

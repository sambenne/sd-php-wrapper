<?php

namespace serverdensity\Api;

class Tags extends AbstractApi
{

    // do a mongoId check, if mongoId use find instead.

    /**
    * Find a tag by ID
    * @link     https://apidocs.serverdensity.com/#viewing-an-indvidual-tag
    * @param    string  $id the id of the tag.
    * @return   an array that is the tag.
    */
    public function view($id)
    {
        return $this->get('inventory/tags/'.rawurlencode($id));
    }

    /**
    * Get all tags
    * @link     https://apidocs.serverdensity.com/#view-all-tags
    * @return   an array of arrays that contains all the tags.
    */
    public function all()
    {
        return $this->get('inventory/tags/');
    }

    /**
    * Delete tag
    * @link     https://apidocs.serverdensity.com/#deleting-a-tag
    * @param    string $id the id of the tag
    * @return   an array with the id of the tag that got deleted
    */
    public function delete($id)
    {
        return $this->HTTPdelete('inventory/tags/'.rawurlencode($id));
    }

    /**
    * Find a tag by name
    * @param    string $name of the tag
    * @return   an array of the tag in question or an empty array if not found
    */
    public function find($name)
    {
        $tags = $this->all();

        $found = array();
        foreach ($tags as $array){
            if ($array['name'] === $name){
                $found = $array;
                break;
            }
        }
        return $found;
    }

    /**
    * Create a tag
    * @link     https://apidocs.serverdensity.com/?shell#creating-new-tags
    * @param    array $fields tag with all necessary fields
    * @return   an array with the fields of the tag that got created
    */
    public function create($fields)
    {
        return $this->post('inventory/tags/', $fields);
    }


    // do a mongoId check

    /**
    * Update a tag
    * @link     https://apidocs.serverdensity.com/?shell#updating-a-tag
    * @param    string $id
    * @param    array $fields
    * @return   an array with the fields that got updated plus when it got updated
    */
    public function update($id, $fields)
    {
        return $this->put('inventory/tags/'.rawurlencode($id), $fields);
    }

}


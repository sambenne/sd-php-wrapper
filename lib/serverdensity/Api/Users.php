<?php

namespace serverdensity\Api;

class Users extends AbstractApi
{
    /**
    * View user by ID
    * @link     https://apidocs.serverdensity.com/#viewing-a-user
    * @param    string  $id the id of the user.
    * @return   an array that is the user.
    */
    public function view($id){
        return $this->get('users/users/'.rawurlencode($id));
    }

    /**
    * Get all users
    * @link     https://apidocs.serverdensity.com/#listing-all-users
    * @return   an array of arrays that contains the users.
    */
    public function all(){
        return $this->get('users/users/');
    }

    /**
    * Delete user
    * @link     https://apidocs.serverdensity.com/#deleting-a-user
    * @param    string $id the id of the user
    * @return   an array with the user that got deleted
    */
    public function destroy($id)
    {
        return $this->delete('users/users/'.rawurlencode($id));
    }

    /**
    * Create a user
    * @link     https://apidocs.serverdensity.com/#creating-a-user
    * @param    array $user
    * @return   an array with the user that got created
    */
    public function create(array $user)
    {
        $user = $this->makeJsonReady($user);
        return $this->post('users/users/', $user);
    }

    /**
    * Update a user
    * @link     https://apidocs.serverdensity.com/#updating-a-user
    * @param    string $id
    * @param    array $fields
    * @return   an array with the fields that got updated plus when it got updated
    */
    public function update($id, $fields)
    {
        $fields = $this->makeJsonReady($fields);
        return $this->put('users/users/'.rawurlencode($id), $fields);
    }
}

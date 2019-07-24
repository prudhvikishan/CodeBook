<?php

class Address_model extends CI_Model {

	public $address_id, $address1, $address2, $city, $state, $country;

	/**
	 * Create a new address.
	 **/
    function __construct($address_id = null, $address1 = null, $address2 = null,  $city = null, $state = null, $country = null)
    {
        parent::__construct();
        $this->address_id      = $address_id;
        $this->address1        = $address1;
        $this->address2        = $address2;
        $this->city    = $city;
        $this->state    = $state;
        $this->country    = $country;
    }

    /**
     * Save the current address.
     **/
    public function save()
    {
    	if($this->address_id == null)
    	{
    		$this->db->insert("Addresses", array(
				"address1" => $this->address1,
				"address2" => $this->address2,
				"city" => $this->city,
    			"state" => $this->state,
    			"country" => $this->country
    		));
    		$this->address_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"address1" => $this->address1,
				"address2" => $this->address2,
				"city" => $this->city,
    			"state" => $this->state,
    			"country" => $this->country
       		);
    		$this->db->where("address_id", $this->address_id);
    		$this->db->update($update_data);
    	}
    }

    /**
     * Load a address by id.
     **/
    public static function LoadById($address_id)
    {
    	$result = &get_instance()->db->get_where("Addresses", array("address_id" => $address_id));
    	$result = $result->result();
    	return count($result) != 0 ? Address_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Address_model(
   			$row->address_id,
   			$row->address1,
   			$row->address2,
   			$row->city,
   			$row->state,
   			$row->country
   		);
   	}
   	
}
?>

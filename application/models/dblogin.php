<?php

class Dblogin extends CI_Model {

    var $table = 'user';

    function Dblogin() {
	// Call the Model constructor
	parent::__construct();
    }

    function select($query) {
	$sql = "select * from $this->table " . $query;
	$query = $this->db->query($sql);
	return $query->result_array();
    }
    
    function insert($data) {
	if ($this->db->insert($this->table, $data)) {
	    return true;
	} else {
	    return false;
	}
    }

    function update($user_id, $data) {
	$this->db->where($this->primary_key, $user_id);
	if ($this->db->update($this->table, $data)) {
	    return true;
	} else {
	    return false;
	}
    }

    function update_user($user_id,$code, $data) {
	$this->db->where('user_id', $user_id);
	$this->db->where('unique_code', $code);
	if ($this->db->update($this->table, $data)) {
	    return true;
	} else {
	    return false;
	}
    }
    function delete($id) {
	$this->db->delete($this->table, array($this->primary_key => $id));
	return true;
    }

    function isExist($query) {
	$sql = "select * from $this->table " . $query . " limit 0,1";
	$query = $this->db->query($sql);
	return $query->row();
    }
    function getLastInserted() {
	return $this->db->insert_id();
    }
    
}

?>
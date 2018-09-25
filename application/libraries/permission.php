<?php

class permission {

    public function permission() {
        
        $this->ci = & get_instance();

        log_message('debug', 'DX Auth Initialized');
        
// Load required library
        $this->ci->load->library('Session');
        $this->ci->load->database();
    }

    function is_super_admin() {
		if($this->ci->session->userdata('user')!='')
		{
			$user = $this->ci->session->userdata('user');			
			return (strtolower($user->user_role) == 'superadmin');
		}
    }

    // Get user id
    function get_user_id() {
		if($this->ci->session->userdata('user')!='')
		{
			$user = $this->ci->session->userdata('user');
			return $user->user_id;
		}
    }

    public function getUserPermissions($userId) {
        $this->ci->load->model('dbcommon');
        
        $where = " where user_id='" . $userId . "'";
        return $this->ci->dbcommon->readpermission('user_permission', $where);

    }

    function has_permission($permissionName) {
	
        if ($this->is_super_admin())
            return true;
        else {
            $userId = $this->get_user_id();
            $userPermission = $this->getUserPermissions($userId);
			
            if (!empty($userPermission)) {
                $permission_array=  explode(",", $userPermission[0]['permission']);                
                if (in_array($permissionName, $permission_array) !== false)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
    }

}
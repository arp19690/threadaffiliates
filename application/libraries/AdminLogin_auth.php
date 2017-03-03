<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AdminLogin_auth
{

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->model('Common_model');
        $this->checkIfLoggedIn();
    }

    public function login($admin_username, $admin_password, $success_redirect_to = NULL, $error_redirect_to = NULL)
    {
        $model = $this->ci->Common_model;
        $whereCondArr = array("admin_username" => $admin_username, "admin_password" => $admin_password, 'admin_status' => '1');
        $record = $model->fetchSelectedData("admin_id, admin_username, admin_fullname", TABLE_ADMIN, $whereCondArr, 'admin_id', 'DESC', "0,1");
        if (!empty($record))
        {
            //login successful
            $record = $record[0];

            $data_array = array(
                "al_admin_id" => $record["admin_id"],
                "al_login_timestamp" => date('Y-m-d H:i:s'),
                "al_useragent" => $this->ci->session->userdata["admin_agent"],
                "al_ipaddress" => $this->ci->session->userdata["ip_address"]
            );
            $model->insertData(TABLE_ADMIN_LOG, $data_array);

            $admin_array = array(
                "admin_id" => $record["admin_id"],
                "admin_username" => $record["admin_username"],
                "admin_fullname" => stripslashes($record["admin_fullname"]),
                "admin_session_expire_time" => time() + ADMIN_TIMEOUT_TIME,
            );

            foreach ($admin_array as $key => $value)
            {
                $this->ci->session->set_userdata($key, $value);
            }

            if ($success_redirect_to == NULL)
            {
                $success_redirect_to = base_url("admin");
            }

            redirect($success_redirect_to);
        }
        else
        {
            if ($error_redirect_to == NULL)
            {
                $error_redirect_to = base_url("admin");
            }

            $this->ci->session->set_flashdata('error', "<strong>Error!</strong> Invalid login details.");
            redirect($error_redirect_to);
        }
    }

    public function checkIfLoggedIn($admin_id = NULL)
    {
        if (isset($this->ci->session->userdata["admin_id"]))
        {
            //logged in
            if ($admin_id == NULL)
            {
                $admin_id = $this->ci->session->userdata["admin_id"];
            }

            $admin_session_expire_time = $this->ci->session->userdata["admin_session_expire_time"];

            if ($admin_session_expire_time >= time())
            {
                //Update User session time
                @$this->ci->session->set_userdata("admin_session_expire_time", time() + ADMIN_TIMEOUT_TIME);
            }
            else
            {
                //Session expired, logout
                $this->logout($admin_id, base_url("admin"), "<strong>Sorry!</strong> Your session expired.");
            }
        }
        else
        {
            $path = $this->ci->router->class . "/" . $this->ci->router->method;
            if ($path != "admin/index" && $this->ci->router->module == "admin")
            {
                redirect(base_url('admin'));
            }
        }
    }

    public function logout($admin_id = NULL, $redirect_to = NULL, $logout_message = NULL)
    {
        if ($admin_id == NULL)
        {
            $admin_id = $this->ci->session->userdata["admin_id"];
        }

        if ($redirect_to == NULL)
        {
            $redirect_to = base_url("admin");
        }

        $model = $this->ci->Common_model;

        $record = $model->fetchSelectedData("al_id", TABLE_ADMIN_LOG, array("al_admin_id" => $admin_id, "al_logout_timestamp" => NULL), "al_id", "DESC", "0, 1");
        $al_id = $record[0]["al_id"];

        $update_data_array = array('al_logout_timestamp' => date('Y-m-d H:i:s'));

        $whereCondArr = array(
            'al_id' => $al_id,
            'al_admin_id' => $admin_id
        );

        $model->updateData(TABLE_ADMIN_LOG, $update_data_array, $whereCondArr);
        $this->ci->session->unset_userdata();
        $this->ci->session->sess_destroy();
        if ($logout_message != NULL)
        {
            $this->ci->session->set_flashdata('error', $logout_message);
        }
        redirect($redirect_to);
    }

}

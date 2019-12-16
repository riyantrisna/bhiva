<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
 
if (! function_exists('MultiLang')) {
    function MultiLang($code = '')
    {
        $ci=& get_instance();
        $ci->load->database();
        $user_lang = $ci->session->userdata('user_lang');
        if(empty($user_lang)){
            $user_lang = 'id';
        }
    
        $sql = "
            SELECT
                b.`keytext_text` AS 'text'
            FROM
                `core_key` a
                LEFT JOIN `core_key_text` b ON b.`keytext_key_id` = a.`key_id`
            WHERE
                a.`key_code` = '$code'
                AND  b.`keytext_lang_code` = '$user_lang'
        "; 
        $query = $ci->db->query($sql);
        $row = $query->row();
        
        if(!empty($row)){
            return $row->text;
        }else{
            return '['.$code.']';
        }
        
    }

}
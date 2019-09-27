<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->default = $this->load->database('default', TRUE);
        $this->user_lang = $this->session->userdata('user_lang');
    }

    public function getUserByUsername($username){
        $query = "
            SELECT 
                `user_id` AS id,
                `user_real_name` AS real_name,
                `user_password` AS password,
                `user_email` AS email,
                `user_phone` AS phone,
                `user_gender` AS gender,
                `user_birthday` AS birthday,
                `user_address` AS address,
                `user_is_admin` AS is_admin,
                `user_lang` AS lang,
                `user_last_login` AS last_login,
                `user_status` AS status,
                `user_photo` AS photo
            FROM
                `core_user`
            WHERE
                user_email = '$username'
                AND user_is_admin = 1
                AND `user_status` = 1
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function updateDataUser($data, $user_id){
        $this->default->where('user_id', $user_id);
        $query = $this->default->update('core_user',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getDatetimeIndo($datetime){
			
        if(!empty($datetime)){
            //2019-01-05 14:31:45
            $day = substr($datetime, 8, 2);
            $month = substr($datetime, 5, 2);
            $year = substr($datetime, 0, 4);
            $time = substr($datetime, 11, 8);

            if($month == '01'){
                $month = 'Januari';
            }elseif($month == '02'){
                $month = 'Februari';
            }elseif($month == '03'){
                $month = 'Maret';
            }elseif($month == '04'){
                $month = 'April';
            }elseif($month == '05'){
                $month = 'Mei';
            }elseif($month == '06'){
                $month = 'Juni';
            }elseif($month == '07'){
                $month = 'Juli';
            }elseif($month == '08'){
                $month = 'Agustus';
            }elseif($month == '09'){
                $month = 'September';
            }elseif($month == '10'){
                $month = 'Oktober';
            }elseif($month == '11'){
                $month = 'November';
            }else{
                $month = 'Desember';
            }

            $dates = $day.' '.$month.' '.$year.' '.$time;
        }else{
            $dates = '-';
        }

        return $dates;
    }

    public function getDatetimeIndoNumeric($datetime){
        
        if(!empty($datetime)){
            //2019-01-05 14:31:45
            $day = substr($datetime, 8, 2);
            $month = substr($datetime, 5, 2);
            $year = substr($datetime, 0, 4);
            $time = substr($datetime, 11, 8);

            $dates = $day.'/'.$month.'/'.$year.' '.$time;
        }else{
            $dates = '-';
        }

        return $dates;
    }

    public function getDateIndo($date){
        
        if(!empty($date)){
            //2019-01-05
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $year = substr($date, 0, 4);

            if($month == '01'){
                $month = 'Januari';
            }elseif($month == '02'){
                $month = 'Februari';
            }elseif($month == '03'){
                $month = 'Maret';
            }elseif($month == '04'){
                $month = 'April';
            }elseif($month == '05'){
                $month = 'Mei';
            }elseif($month == '06'){
                $month = 'Juni';
            }elseif($month == '07'){
                $month = 'Juli';
            }elseif($month == '08'){
                $month = 'Agustus';
            }elseif($month == '09'){
                $month = 'September';
            }elseif($month == '10'){
                $month = 'Oktober';
            }elseif($month == '11'){
                $month = 'November';
            }else{
                $month = 'Desember';
            }

            $dates = $day.' '.$month.' '.$year;
        }else{
            $dates = '-';
        }

        return $dates;
    }

    public function getDateIndoNumeric($date){
        
        if(!empty($date)){
            //2019-01-05
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $year = substr($date, 0, 4);

            $dates = $day.'/'.$month.'/'.$year;
        }else{
            $dates = '-';
        }

        return $dates;
    }

    public function getBase64ImageSize($base64Image){ //return memory size in B, KB, MB
        try{
            $size_in_bytes = (int) (strlen(rtrim($base64Image, '=')) * 3 / 4);
            $size_in_kb    = $size_in_bytes / 1024;
            // $size_in_mb    = $size_in_kb / 1024;
    
            return $size_in_kb;
        }
        catch(Exception $e){
            return $e;
        }
    }

    public function uploadBase64($image, $path, $max_size, $type_allow){

        $file_size = $this->getBase64ImageSize($image);

        if($file_size <= $max_size){

            $image_name = md5(uniqid(rand(), true).date('YmdHis'));
            $ext = explode(';', $image);
            $ext = explode('/', $ext[0]);
            $ext = end($ext);
            $filename = $image_name.'.'.$ext;
            $image = explode(',', $image);   
            $file = $path.$filename;

            if(in_array($ext, explode('|', $type_allow))){
                $status = file_put_contents($file, base64_decode($image[1]));
                if($status !== false){
                    chmod($file,0777);
                    $result['status'] = true;
                    $result['file'] = $filename;
                    $result['message'] = MultiLang('success_upload');
                }else{
                    $result['status'] = false;
                    $result['file'] = '';
                    $result['message'] = MultiLang('failed_upload');
                }
            }else{
                $result['status'] = false;
                $result['file'] = '';
                $result['message'] = MultiLang('allowed_file_is').' ('.(str_replace('|', ', ', $type_allow)).')';
            }

        }else{
            $result['status'] = false;
            $result['file'] = '';
            $result['message'] = MultiLang('max_file_is').' '.$max_size.'KB';
        }

        return $result;

    }   

    // language
    public function getAllLanguage($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( LOWER(a.`lang_code`) LIKE LOWER('%$keyword%') OR LOWER(a.`lang_name`) LIKE LOWER('%$keyword%') ) ";
        }

        $query = "
            SELECT
                a.`lang_code` AS code,
                a.`lang_name` AS name,
                a.`lang_icon` AS icon
            FROM
                `core_lang` a
            WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllLanguage($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( LOWER(a.`lang_code`) LIKE LOWER('%$keyword%') OR LOWER(a.`lang_name`) LIKE LOWER('%$keyword%') ) ";
        }

        $query = "
            SELECT
                COUNT(DISTINCT a.`lang_code`) AS total
            FROM
                `core_lang` a
            WHERE 1 = 1
        ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addLanguage($data){
        $query = $this->default->insert('core_lang',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updateLanguage($data, $id){
        $this->default->where('lang_code', $id);
        $query = $this->default->update('core_lang',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getDetailLanguage($id){

        $query = "
            SELECT
                a.`lang_code` AS code,
                a.`lang_name` AS language,
                a.`lang_icon` AS icon,
                c.user_real_name AS insert_user,
                a.insert_datetime,
                d.user_real_name AS update_user,
                a.update_datetime
            FROM
                `core_lang` a
                LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                LEFT JOIN core_user d ON d.user_id = a.update_user_id
            WHERE 1 = 1
            AND a.`lang_code` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getExistCode($id){

        $query = "
            SELECT
                a.`lang_code` AS code
            FROM
                `core_lang` a
            WHERE 1 = 1
            AND a.`lang_code` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function deleteLanguage($id){
        $this->default->where('lang_code', $id);
        $query = $this->default->delete('core_lang');
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    // translation
    public function getAllTranslation($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( LOWER(a.`key_code`) LIKE LOWER('%$keyword%') ";
            $str .= " OR key_id IN (
                        SELECT DISTINCT 
                            keytext_key_id AS id 
                        FROM
                            core_key_text 
                        WHERE 
                            LOWER(keytext_text) LIKE LOWER('%$keyword%')
                        )
                    )";
        }

        $query = "
            SELECT
                a.`key_id` AS id,
                a.`key_code` AS 'code'
            FROM
                `core_key` a
            WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllTranslation($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( LOWER(a.`key_code`) LIKE LOWER('%$keyword%') ";
            $str .= " OR key_id IN (
                        SELECT DISTINCT 
                            keytext_key_id AS id 
                        FROM
                            core_key_text 
                        WHERE 
                            LOWER(keytext_text) LIKE LOWER('%$keyword%')
                        )
                    )";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`key_id`) AS total
                FROM 
                    core_key a 
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getTranslationLanguage(){
        $query = "
            SELECT
                a.`keytext_key_id` AS `key_id`,
                a.`keytext_lang_code` AS `code`,
                a.`keytext_text` AS `text`,
                b.`lang_icon` AS `icon`
            FROM
                `core_key_text` a
                LEFT JOIN `core_lang` b ON b.`lang_code` = a.`keytext_lang_code`
        ";
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getLang(){
        $query = "
            SELECT
                a.`lang_code` AS `code`,
                a.`lang_name` AS `name`,
                a.`lang_icon` AS `icon`
            FROM
                `core_lang` a
        ";
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getExistCodeTranslation($id){

        $query = "
            SELECT
                a.`key_code` AS code
            FROM
                `core_key` a
            WHERE 1 = 1
            AND a.`key_code` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addTransalation($data, $translation, $user_id, $date){
        $this->default->trans_begin();
        $this->default->insert('core_key',$data);
        $key_id = $this->default->insert_id();

        if(!empty($translation)){
            foreach ($translation as $key => $value) {
                $data = array(
                    'keytext_key_id' => $key_id,
                    'keytext_lang_code' => $key,
                    'keytext_text' => $value,
                    'insert_user_id' => $user_id,
                    'insert_datetime' => $date
                );
                $this->default->insert('core_key_text',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateTransalation($data, $id, $translation, $user_id, $date){
        $this->default->trans_begin();
        $this->default->where('key_id', $id);
        $this->default->update('core_key',$data);

        if(!empty($translation)){
            foreach ($translation as $key => $value) {
                $data = array(
                    'keytext_text' => $value,
                    'update_user_id' => $user_id,
                    'update_datetime' => $date
                );
                $this->default->where('keytext_key_id', $id);
                $this->default->where('keytext_lang_code', $key);
                $this->default->update('core_key_text',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteTranslation($id){
        $this->default->trans_begin();
        
        $this->default->where('keytext_key_id', $id);
        $this->default->delete('core_key_text');

        $this->default->where('key_id', $id);
        $this->default->delete('core_key');
        
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function getDetailTranslation($id){

        $query = "
            SELECT
                `key_id` AS `id`,
                `key_code` AS `code`,
                c.user_real_name AS insert_user,
                a.insert_datetime,
                d.user_real_name AS update_user,
                a.update_datetime
            FROM
                `core_key` a
                LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                LEFT JOIN core_user d ON d.user_id = a.update_user_id
            WHERE
                `key_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTranslationText($id){

        $query = "
            SELECT
                `keytext_lang_code` AS `lang_code`,
                `keytext_text` AS `text`
            FROM
                `core_key_text`
            WHERE
                `keytext_key_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    // user
    public function getAllUser($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(a.`user_real_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`user_email`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`user_phone`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
            SELECT 
                a.`user_id` AS `id`,
                a.`user_real_name` AS `real_name`,
                a.`user_password` AS `password`,
                a.`user_email` AS `email`,
                a.`user_phone` AS `phone`,
                a.`user_gender` AS `gender`,
                a.`user_birthday` AS `birthday`,
                a.`user_address` AS `address`,
                a.`user_is_admin` AS `is_admin`,
                a.`user_lang` AS `lang`,
                a.`user_last_login` AS `last_login`,
                a.`user_status` AS `status`,
                a.`user_photo` AS `photo`,
                a.`user_desc` AS `desc`
            FROM
                `core_user` a
            WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllUser($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(a.`user_real_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`user_email`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`user_phone`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`user_id`) AS total
                FROM 
                    core_user a 
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailUser($id){

        $query = "
            SELECT 
                a.`user_id` AS `id`,
                a.`user_real_name` AS `real_name`,
                a.`user_password` AS `password`,
                a.`user_email` AS `email`,
                a.`user_phone` AS `phone`,
                a.`user_gender` AS `gender`,
                a.`user_birthday` AS `birthday`,
                a.`user_address` AS `address`,
                a.`user_is_admin` AS `is_admin`,
                a.`user_lang` AS `lang`,
                b.lang_name AS lang_name,
                a.`user_last_login` AS `last_login`,
                a.`user_status` AS `status`,
                a.`user_photo` AS `photo`,
                a.`user_desc` AS `desc`,
                c.user_real_name AS insert_user,
                a.insert_datetime,
                d.user_real_name AS update_user,
                a.update_datetime
            FROM
                `core_user` a
                LEFT JOIN core_lang b ON b.lang_code = a.`user_lang`
                LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                LEFT JOIN core_user d ON d.user_id = a.update_user_id
            WHERE 1 = 1
            AND a.`user_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getExistEmail($id){

        $query = "
            SELECT
                a.`user_email` AS email
            FROM
                `core_user` a
            WHERE 1 = 1
            AND a.`user_email` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addUser($data){
        $query = $this->default->insert('core_user',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updateUser($data, $id){
        $this->default->where('user_id', $id);
        $query = $this->default->update('core_user',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function deleteUser($id){
        $this->default->where('user_id', $id);
        $query = $this->default->delete('core_user');
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    // slider
    public function getAllSlider($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`slidertext_title`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`slidertext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`slidertext_title_link`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_link`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`slider_id` AS `id`,
                    a.`slider_img` AS `img`,
                    a.`slider_link` AS `link`,
                    a.`slider_order` AS `order`,
                    a.`slider_status` AS `status`,
                    b.`slidertext_title_link` AS `title_link`,
                    b.`slidertext_title` AS `title`,
                    b.`slidertext_text` AS `content`
                FROM
                    `cms_slider` a
                    LEFT JOIN `cms_slider_text` b ON b.`slidertext_slider_id` = a.`slider_id` AND b.`slidertext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllSlider($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`slidertext_title`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`slidertext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`slidertext_title_link`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_link`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`slider_id`) AS total
                FROM 
                    `cms_slider` a
                    LEFT JOIN `cms_slider_text` b ON b.`slidertext_slider_id` = a.`slider_id` AND b.`slidertext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailSlider($id){

        $query = "
                SELECT
                    a.`slider_id` AS `id`,
                    a.`slider_img` AS `img`,
                    a.`slider_link` AS `link`,
                    a.`slider_order` AS `order`,
                    a.`slider_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_slider` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`slider_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailSliderText($id){

        $query = "
                SELECT
                    a.`slidertext_slider_id` AS `slider_id`,
                    a.`slidertext_lang` AS `lang`,
                    a.`slidertext_title_link` AS `title_link`,
                    a.`slidertext_title` AS `title`,
                    a.`slidertext_text` AS `content`
                FROM
                    `cms_slider_text` a
                WHERE 1 = 1
                AND a.`slidertext_slider_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addSlider($data, $title, $title_link, $content){
        $this->default->trans_begin();

        $this->default->insert('cms_slider',$data);
        $slider_id = $this->default->insert_id();

        if(!empty($title)){
            foreach ($title as $key => $value) {
                $data = array(
                    'slidertext_slider_id' => $slider_id,
                    'slidertext_lang' => $key,
                    'slidertext_title_link' => $title_link[$key],
                    'slidertext_title' => $value,
                    'slidertext_text' => $content[$key]
                );
                $this->default->insert('cms_slider_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateSlider($data, $id, $title, $title_link, $content){
        $this->default->trans_begin();

        $this->default->where('slider_id', $id);
        $this->default->update('cms_slider',$data);

        $this->default->where('slidertext_slider_id', $id);
        $this->default->delete('cms_slider_text');

        if(!empty($title)){
            foreach ($title as $key => $value) {
                $data = array(
                    'slidertext_slider_id' => $id,
                    'slidertext_lang' => $key,
                    'slidertext_title_link' => $title_link[$key],
                    'slidertext_title' => $value,
                    'slidertext_text' => $content[$key]
                );
                $this->default->insert('cms_slider_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteSlider($id){
        $this->default->trans_begin();
        $this->default->where('slidertext_slider_id', $id);
        $this->default->delete('cms_slider_text');
        $this->default->where('slider_id', $id);
        $this->default->delete('cms_slider');
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }


    // service
    public function getAllService($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`servicetext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`servicetext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`service_id` AS `id`,
                    a.`service_order` AS `order`,
                    a.`service_is_top` AS `is_top`,
                    a.`service_status` AS `status`,
                    a.`service_type` AS `type`,
                    b.`servicetext_name` AS `name`,
                    b.`servicetext_text` AS `text`
                FROM
                    `cms_service` a
                    LEFT JOIN `cms_service_text` b ON b.`servicetext_service_id` = a.`service_id` AND b.`servicetext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllService($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`servicetext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`servicetext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`service_id`) AS total
                FROM 
                `cms_service` a
                LEFT JOIN `cms_service_text` b ON b.`servicetext_service_id` = a.`service_id` AND b.`servicetext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function checkServiceTypeExist($type, $id = ''){
        $str = "";
        if(!empty($id)){
            $str.= "AND a.`service_id` NOT IN (".$id.")";
        }
        $query = "
                SELECT
                    a.`service_id` AS `id`
                FROM
                    `cms_service` a
                WHERE 1 = 1
                AND a.`service_type` = '".$type."'
                ".$str."
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailService($id){

        $query = "
                SELECT
                    a.`service_id` AS `id`,
                    a.`service_order` AS `order`,
                    a.`service_is_top` AS `is_top`,
                    a.`service_status` AS `status`,
                    a.`service_type` AS `type`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_service` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`service_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailServiceText($id){

        $query = "
                SELECT
                    a.`servicetext_service_id` AS `service_id`,
                    a.`servicetext_lang` AS `lang`,
                    a.`servicetext_name` AS `name`,
                    a.`servicetext_text` AS `text`
                FROM
                    `cms_service_text` a
                WHERE 1 = 1
                AND a.`servicetext_service_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailServiceImages($id){

        $query = "
                SELECT
                    a.`serviceimg_service_id` AS `service_id`,
                    a.`serviceimg_order` AS `order`,
                    a.`serviceimg_img` AS `img`
                FROM
                    `cms_service_img` a
                WHERE 1 = 1
                AND a.`serviceimg_service_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addService($data, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->insert('cms_service',$data);
        $service_id = $this->default->insert_id();

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'servicetext_service_id' => $service_id,
                    'servicetext_lang' => $key,
                    'servicetext_name' => $value,
                    'servicetext_text' => $content[$key]
                );
                $this->default->insert('cms_service_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'serviceimg_service_id' => $service_id,
                    'serviceimg_order' => $key,
                    'serviceimg_img' => $value
                );
                $this->default->insert('cms_service_img',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateService($data, $id, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->where('service_id', $id);
        $this->default->update('cms_service',$data);

        $this->default->where('servicetext_service_id', $id);
        $this->default->delete('cms_service_text');
        
        $this->default->where('serviceimg_service_id', $id);
        $this->default->delete('cms_service_img');

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'servicetext_service_id' => $id,
                    'servicetext_lang' => $key,
                    'servicetext_name' => $value,
                    'servicetext_text' => $content[$key]
                );
                $this->default->insert('cms_service_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'serviceimg_service_id' => $id,
                    'serviceimg_order' => $key,
                    'serviceimg_img' => $value
                );
                $this->default->insert('cms_service_img',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteService($id){
        $this->default->trans_begin();

        $this->default->where('servicetext_service_id', $id);
        $this->default->delete('cms_service_text');
        
        $this->default->where('serviceimg_service_id', $id);
        $this->default->delete('cms_service_img');

        $this->default->where('service_id', $id);
        $this->default->delete('cms_service');

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    //whoweare
    public function getDetailWhoweare($id){

        $query = "
                SELECT
                    a.`whoweare_id` AS `id`,
                    a.`whoweare_img` AS `img`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_whoweare` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`whoweare_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailWhoweareText($id){

        $query = "
                SELECT
                    a.`whowearetext_whoweare_id` AS `whoweare_id`,
                    a.`whowearetext_lang` AS `lang`,
                    a.`whowearetext_text` AS `text`
                FROM
                    `cms_whoweare_text` a
                WHERE 1 = 1
                AND a.`whowearetext_whoweare_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function updateWhoweare($data, $id, $content){
        $this->default->trans_begin();

        $this->default->where('whoweare_id', $id);
        $this->default->update('cms_whoweare',$data);

        $this->default->where('whowearetext_whoweare_id', $id);
        $this->default->delete('cms_whoweare_text');

        if(!empty($content)){
            foreach ($content as $key => $value) {
                $data = array(
                    'whowearetext_whoweare_id' => $id,
                    'whowearetext_lang' => $key,
                    'whowearetext_text' => $value
                );
                $this->default->insert('cms_whoweare_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    //contact
    public function getDetailContact($id){

        $query = "
                SELECT
                    a.`contact_id` AS `id`,
                    a.`contact_address` AS `address`,
                    a.`contact_email` AS `email`,
                    a.`contact_phone` AS `phone`,
                    a.`contact_wa` AS `wa`,
                    a.`contact_fb` AS `fb`,
                    a.`contact_ig` AS `ig`,
                    a.`contact_twitter` AS `twitter`,
                    a.`contact_img_maps` AS `img_maps`,
                    a.`contact_link_maps` AS `link_maps`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_contact` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`contact_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function updateContact($data, $id){
        $this->default->trans_begin();

        $this->default->where('contact_id', $id);
        $this->default->update('cms_contact',$data);

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    //privacypolicy
    public function getDetailPrivacypolicy($id){

        $query = "
                SELECT
                    a.`privacypolicy_id` AS `id`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_privacypolicy` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`privacypolicy_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailPrivacypolicyText($id){

        $query = "
                SELECT
                    a.`privacypolicytext_privacypolicy_id` AS `privacypolicy_id`,
                    a.`privacypolicytext_lang` AS `lang`,
                    a.`privacypolicytext_text` AS `text`
                FROM
                    `cms_privacypolicy_text` a
                WHERE 1 = 1
                AND a.`privacypolicytext_privacypolicy_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function updatePrivacypolicy($data, $id, $content){
        $this->default->trans_begin();

        $this->default->where('privacypolicy_id', $id);
        $this->default->update('cms_privacypolicy',$data);

        $this->default->where('privacypolicytext_privacypolicy_id', $id);
        $this->default->delete('cms_privacypolicy_text');

        if(!empty($content)){
            foreach ($content as $key => $value) {
                $data = array(
                    'privacypolicytext_privacypolicy_id' => $id,
                    'privacypolicytext_lang' => $key,
                    'privacypolicytext_text' => $value
                );
                $this->default->insert('cms_privacypolicy_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    //termcondition
    public function getDetailTermcondition($id){

        $query = "
                SELECT
                    a.`termcondition_id` AS `id`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_termcondition` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`termcondition_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTermconditionText($id){

        $query = "
                SELECT
                    a.`termconditiontext_termcondition_id` AS `termcondition_id`,
                    a.`termconditiontext_lang` AS `lang`,
                    a.`termconditiontext_text` AS `text`
                FROM
                    `cms_termcondition_text` a
                WHERE 1 = 1
                AND a.`termconditiontext_termcondition_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function updateTermcondition($data, $id, $content){
        $this->default->trans_begin();

        $this->default->where('termcondition_id', $id);
        $this->default->update('cms_termcondition',$data);

        $this->default->where('termconditiontext_termcondition_id', $id);
        $this->default->delete('cms_termcondition_text');

        if(!empty($content)){
            foreach ($content as $key => $value) {
                $data = array(
                    'termconditiontext_termcondition_id' => $id,
                    'termconditiontext_lang' => $key,
                    'termconditiontext_text' => $value
                );
                $this->default->insert('cms_termcondition_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }


    // gallery
    public function getAllGallery($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_order`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_status`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`gallery_id` AS `id`,
                    a.`gallery_img` AS `img`,
                    a.`gallery_order` AS `order`,
                    a.`gallery_status` AS `status`,
                    b.`gallerytext_title` AS `title`
                FROM
                    `cms_gallery` a
                    LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND  a.`gallery_type` = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllGallery($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_order`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_status`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`gallery_id`) AS total
                FROM 
                    `cms_gallery` a
                    LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND  a.`gallery_type` = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailGallery($id){

        $query = "
                SELECT
                    a.`gallery_id` AS `id`,
                    a.`gallery_img` AS `img`,
                    a.`gallery_order` AS `order`,
                    a.`gallery_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_gallery` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND  a.`gallery_type` = 1
                AND a.`gallery_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailGalleryText($id){

        $query = "
                SELECT
                    a.`gallerytext_gallery_id` AS `gallery_id`,
                    a.`gallerytext_lang` AS `lang`,
                    a.`gallerytext_title` AS `title`
                FROM
                    `cms_gallery_text` a
                WHERE 1 = 1
                AND a.`gallerytext_gallery_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addGallery($data, $title){
        $this->default->trans_begin();

        $this->default->insert('cms_gallery',$data);
        $gallery_id = $this->default->insert_id();

        if(!empty($title)){
            foreach ($title as $key => $value) {
                $data = array(
                    'gallerytext_gallery_id' => $gallery_id,
                    'gallerytext_lang' => $key,
                    'gallerytext_title' => $value
                );
                $this->default->insert('cms_gallery_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateGallery($data, $id, $title){
        $this->default->trans_begin();

        $this->default->where('gallery_id', $id);
        $this->default->update('cms_gallery',$data);

        $this->default->where('gallerytext_gallery_id', $id);
        $this->default->delete('cms_gallery_text');

        if(!empty($title)){
            foreach ($title as $key => $value) {
                $data = array(
                    'gallerytext_gallery_id' => $id,
                    'gallerytext_lang' => $key,
                    'gallerytext_title' => $value
                );
                $this->default->insert('cms_gallery_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteGallery($id){
        $this->default->trans_begin();
        $this->default->where('gallerytext_gallery_id', $id);
        $this->default->delete('cms_gallery_text');
        $this->default->where('gallery_id', $id);
        $this->default->delete('cms_gallery');
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    // gallery images
    public function getAllGalleryImages($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_order`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_status`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`gallery_id` AS `id`,
                    a.`gallery_img` AS `img`,
                    a.`gallery_order` AS `order`,
                    a.`gallery_status` AS `status`,
                    b.`gallerytext_title` AS `title`
                FROM
                    `cms_gallery` a
                    LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND  a.`gallery_type` = 2
                AND  a.`gallery_parent_id` = $id
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllGalleryImages($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_order`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`gallery_status`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`gallery_id`) AS total
                FROM 
                    `cms_gallery` a
                    LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND  a.`gallery_type` = 2
                AND  a.`gallery_parent_id` = $id
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailGalleryTitle($id){

        $query = "
                SELECT
                    a.`gallery_id` AS `id`,
                    a.`gallery_img` AS `img`,
                    a.`gallery_order` AS `order`,
                    a.`gallery_status` AS `status`,
                    b.`gallerytext_title` AS `title`
                FROM
                    `cms_gallery` a
                    LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND  a.`gallery_id` = $id
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailGalleryImages($id){

        $query = "
                SELECT
                    a.`gallery_id` AS `id`,
                    a.`gallery_img` AS `img`,
                    a.`gallery_order` AS `order`,
                    a.`gallery_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_gallery` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND  a.`gallery_type` = 2
                AND a.`gallery_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailGalleryImagesText($id){

        $query = "
                SELECT
                    a.`gallerytext_gallery_id` AS `gallery_id`,
                    a.`gallerytext_lang` AS `lang`,
                    a.`gallerytext_title` AS `title`
                FROM
                    `cms_gallery_text` a
                WHERE 1 = 1
                AND a.`gallerytext_gallery_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addGalleryImages($data, $title){
        $this->default->trans_begin();

        $this->default->insert('cms_gallery',$data);
        $gallery_id = $this->default->insert_id();

        if(!empty($title)){
            foreach ($title as $key => $value) {
                $data = array(
                    'gallerytext_gallery_id' => $gallery_id,
                    'gallerytext_lang' => $key,
                    'gallerytext_title' => $value
                );
                $this->default->insert('cms_gallery_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateGalleryImages($data, $id, $title){
        $this->default->trans_begin();

        $this->default->where('gallery_id', $id);
        $this->default->update('cms_gallery',$data);

        $this->default->where('gallerytext_gallery_id', $id);
        $this->default->delete('cms_gallery_text');

        if(!empty($title)){
            foreach ($title as $key => $value) {
                $data = array(
                    'gallerytext_gallery_id' => $id,
                    'gallerytext_lang' => $key,
                    'gallerytext_title' => $value
                );
                $this->default->insert('cms_gallery_text',$data);
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteGalleryImages($id){
        $this->default->trans_begin();
        $this->default->where('gallerytext_gallery_id', $id);
        $this->default->delete('cms_gallery_text');
        $this->default->where('gallery_id', $id);
        $this->default->delete('cms_gallery');
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    // destination
    public function getAllDestination($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`destinationtext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`destinationtext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`destination_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`destination_id` AS `id`,
                    a.`destination_status` AS `status`,
                    b.`destinationtext_name` AS `name`,
                    b.`destinationtext_text` AS `text`
                FROM
                    `mst_destination` a
                    LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllDestination($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`destinationtext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`destinationtext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`destination_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`destination_id`) AS total
                FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailDestination($id){

        $query = "
                SELECT
                    a.`destination_id` AS `id`,
                    a.`destination_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `mst_destination` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`destination_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailDestinationText($id){

        $query = "
                SELECT
                    a.`destinationtext_destination_id` AS `destination_id`,
                    a.`destinationtext_lang` AS `lang`,
                    a.`destinationtext_name` AS `name`,
                    a.`destinationtext_text` AS `text`
                FROM
                    `mst_destination_text` a
                WHERE 1 = 1
                AND a.`destinationtext_destination_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailDestinationImages($id){

        $query = "
                SELECT
                    a.`destinationimg_destination_id` AS `destination_id`,
                    a.`destinationimg_order` AS `order`,
                    a.`destinationimg_img` AS `img`
                FROM
                    `mst_destination_img` a
                WHERE 1 = 1
                AND a.`destinationimg_destination_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addDestination($data, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->insert('mst_destination',$data);
        $destination_id = $this->default->insert_id();

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'destinationtext_destination_id' => $destination_id,
                    'destinationtext_lang' => $key,
                    'destinationtext_name' => $value,
                    'destinationtext_text' => $content[$key]
                );
                $this->default->insert('mst_destination_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'destinationimg_destination_id' => $destination_id,
                    'destinationimg_order' => $key,
                    'destinationimg_img' => $value
                );
                $this->default->insert('mst_destination_img',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateDestination($data, $id, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->where('destination_id', $id);
        $this->default->update('mst_destination',$data);

        $this->default->where('destinationtext_destination_id', $id);
        $this->default->delete('mst_destination_text');
        
        $this->default->where('destinationimg_destination_id', $id);
        $this->default->delete('mst_destination_img');

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'destinationtext_destination_id' => $id,
                    'destinationtext_lang' => $key,
                    'destinationtext_name' => $value,
                    'destinationtext_text' => $content[$key]
                );
                $this->default->insert('mst_destination_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'destinationimg_destination_id' => $id,
                    'destinationimg_order' => $key,
                    'destinationimg_img' => $value
                );
                $this->default->insert('mst_destination_img',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteDestination($id){
        $this->default->trans_begin();

        $this->default->where('destinationtext_destination_id', $id);
        $this->default->delete('mst_destination_text');
        
        $this->default->where('destinationimg_destination_id', $id);
        $this->default->delete('mst_destination_img');

        $this->default->where('destination_id', $id);
        $this->default->delete('mst_destination');

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }


    // venue
    public function getAllVenue($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`venuetext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`venuetext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`venue_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`venue_id` AS `id`,
                    a.`venue_status` AS `status`,
                    b.`venuetext_name` AS `name`,
                    b.`venuetext_text` AS `text`
                FROM
                    `mst_venue` a
                    LEFT JOIN `mst_venue_text` b ON b.`venuetext_venue_id` = a.`venue_id` AND b.`venuetext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllVenue($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`venuetext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`venuetext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`venue_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`venue_id`) AS total
                FROM 
                `mst_venue` a
                LEFT JOIN `mst_venue_text` b ON b.`venuetext_venue_id` = a.`venue_id` AND b.`venuetext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailVenue($id){

        $query = "
                SELECT
                    a.`venue_id` AS `id`,
                    a.`venue_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `mst_venue` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`venue_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailVenueText($id){

        $query = "
                SELECT
                    a.`venuetext_venue_id` AS `venue_id`,
                    a.`venuetext_lang` AS `lang`,
                    a.`venuetext_name` AS `name`,
                    a.`venuetext_text` AS `text`
                FROM
                    `mst_venue_text` a
                WHERE 1 = 1
                AND a.`venuetext_venue_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailVenueImages($id){

        $query = "
                SELECT
                    a.`venueimg_venue_id` AS `venue_id`,
                    a.`venueimg_order` AS `order`,
                    a.`venueimg_img` AS `img`
                FROM
                    `mst_venue_img` a
                WHERE 1 = 1
                AND a.`venueimg_venue_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addVenue($data, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->insert('mst_venue',$data);
        $venue_id = $this->default->insert_id();

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'venuetext_venue_id' => $venue_id,
                    'venuetext_lang' => $key,
                    'venuetext_name' => $value,
                    'venuetext_text' => $content[$key]
                );
                $this->default->insert('mst_venue_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'venueimg_venue_id' => $venue_id,
                    'venueimg_order' => $key,
                    'venueimg_img' => $value
                );
                $this->default->insert('mst_venue_img',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateVenue($data, $id, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->where('venue_id', $id);
        $this->default->update('mst_venue',$data);

        $this->default->where('venuetext_venue_id', $id);
        $this->default->delete('mst_venue_text');
        
        $this->default->where('venueimg_venue_id', $id);
        $this->default->delete('mst_venue_img');

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'venuetext_venue_id' => $id,
                    'venuetext_lang' => $key,
                    'venuetext_name' => $value,
                    'venuetext_text' => $content[$key]
                );
                $this->default->insert('mst_venue_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'venueimg_venue_id' => $id,
                    'venueimg_order' => $key,
                    'venueimg_img' => $value
                );
                $this->default->insert('mst_venue_img',$data);
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteVenue($id){
        $this->default->trans_begin();

        $this->default->where('venuetext_venue_id', $id);
        $this->default->delete('mst_venue_text');
        
        $this->default->where('venueimg_venue_id', $id);
        $this->default->delete('mst_venue_img');

        $this->default->where('venue_id', $id);
        $this->default->delete('mst_venue');

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    // ticket
    public function getAllTicket($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`tickettext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`ticket_id` AS `id`,
                    a.`ticket_status` AS `status`,
                    b.`tickettext_name` AS `name`
                FROM
                    `mst_ticket` a
                    LEFT JOIN `mst_ticket_text` b ON b.`tickettext_ticket_id` = a.`ticket_id` AND b.`tickettext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllTicket($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " OR LOWER(b.`tickettext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`ticket_id`) AS total
                FROM 
                    `mst_ticket` a
                    LEFT JOIN `mst_ticket_text` b ON b.`tickettext_ticket_id` = a.`ticket_id` AND b.`tickettext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTicket($id){

        $query = "
                SELECT
                    a.`ticket_id` AS `id`,
                    a.`ticket_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `mst_ticket` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`ticket_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTicketText($id){

        $query = "
                SELECT
                    a.`tickettext_ticket_id` AS `ticket_id`,
                    a.`tickettext_lang` AS `lang`,
                    a.`tickettext_name` AS `name`
                FROM
                    `mst_ticket_text` a
                WHERE 1 = 1
                AND a.`tickettext_ticket_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailTicketPrice($id){

        $query = "
                SELECT
                    a.`ticketprice_ticket_id` AS `ticket_id`,
                    a.`ticketprice_visitortype_id` AS `visitortype_id`,
                    b.`visitortypetext_name` AS `visitortype_name`,
                    a.`ticketprice_start` AS `start`,
                    a.`ticketprice_end` AS `end`,
                    a.`ticketprice_price_local` AS `price_local`,
                    a.`ticketprice_price_foreign` AS `price_foreign`
                FROM
                    `mst_ticket_price` a
                    LEFT JOIN `ref_visitortype_text` b ON b.visitortypetext_visitortype_id = a.ticketprice_visitortype_id AND b.`visitortypetext_lang` = '".$this->user_lang."' 
                WHERE 1 = 1
                AND a.`ticketprice_ticket_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailTicketPricedefault($id){

        $query = "
                SELECT
                    a.`ticketpricedef_ticket_id` AS `ticket_id`,
                    a.`ticketpricedef_visitortype_id` AS `visitortype_id`,
                    b.`visitortypetext_name` AS `visitortype_name`,
                    a.`ticketpricedef_price_local` AS `price_local`,
                    a.`ticketpricedef_price_foreign` AS `price_foreign`
                FROM
                    `mst_ticket_pricedefault` a
                    LEFT JOIN `ref_visitortype_text` b ON b.visitortypetext_visitortype_id = a.ticketpricedef_visitortype_id AND b.`visitortypetext_lang` = '".$this->user_lang."' 
                WHERE 1 = 1
                AND a.`ticketpricedef_ticket_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addTicket($data, $name, $base_price_local, $base_price_foreign, $price){
        $this->default->trans_begin();

        $this->default->insert('mst_ticket',$data);
        $ticket_id = $this->default->insert_id();

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'tickettext_ticket_id' => $ticket_id,
                    'tickettext_lang' => $key,
                    'tickettext_name' => $value
                );
                $this->default->insert('mst_ticket_text',$data);
            }
        }
        
        if(!empty($base_price_local)){
            foreach ($base_price_local as $key => $value) {
                $data = array(
                    'ticketpricedef_ticket_id' => $ticket_id,
                    'ticketpricedef_visitortype_id' => $key,
                    'ticketpricedef_price_local' => str_replace('.','',$value),
                    'ticketpricedef_price_foreign' => str_replace('.','',$base_price_foreign[$key])
                );
                $this->default->insert('mst_ticket_pricedefault',$data);
            }
        }

        if(!empty($price['start'])){
            foreach ($price['start'] as $key => $value) {
                if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key])){
                    $data = array(
                        'ticketprice_ticket_id' => $ticket_id,
                        'ticketprice_visitortype_id' => $price['visitortype'][$key],
                        'ticketprice_start' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['end'][$key] : $price['start'][$key]),
                        'ticketprice_end' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['start'][$key] : $price['end'][$key]),
                        'ticketprice_price_local' => str_replace('.','',$price['price_local'][$key]),
                        'ticketprice_price_foreign' => str_replace('.','',$price['price_foreign'][$key])
                    );
                    $this->default->insert('mst_ticket_price',$data);
                }
            }
        }

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function updateTicket($data, $id, $name, $base_price_local, $base_price_foreign, $price){
        $this->default->trans_begin();

        $this->default->where('ticket_id', $id);
        $this->default->update('mst_ticket',$data);

        $this->default->where('tickettext_ticket_id', $id);
        $this->default->delete('mst_ticket_text');
        
        $this->default->where('ticketpricedef_ticket_id', $id);
        $this->default->delete('mst_ticket_pricedefault');
        
        $this->default->where('ticketprice_ticket_id', $id);
        $this->default->delete('mst_ticket_price');

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'tickettext_ticket_id' => $id,
                    'tickettext_lang' => $key,
                    'tickettext_name' => $value
                );
                $this->default->insert('mst_ticket_text',$data);
            }
        }

        if(!empty($base_price_local)){
            foreach ($base_price_local as $key => $value) {
                $data = array(
                    'ticketpricedef_ticket_id' => $id,
                    'ticketpricedef_visitortype_id' => $key,
                    'ticketpricedef_price_local' => str_replace('.','',$value),
                    'ticketpricedef_price_foreign' => str_replace('.','',$base_price_foreign[$key])
                );
                $this->default->insert('mst_ticket_pricedefault',$data);
            }
        }

        if(!empty($price['start'])){
            foreach ($price['start'] as $key => $value) {
                if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key])){
                    $data = array(
                        'ticketprice_ticket_id' => $id,
                        'ticketprice_visitortype_id' => $price['visitortype'][$key],
                        'ticketprice_start' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['end'][$key] : $price['start'][$key]),
                        'ticketprice_end' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['start'][$key] : $price['end'][$key]),
                        'ticketprice_price_local' => str_replace('.','',$price['price_local'][$key]),
                        'ticketprice_price_foreign' => str_replace('.','',$price['price_foreign'][$key])
                    );
                    $this->default->insert('mst_ticket_price',$data);
                }
            }
        }
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteTicket($id){
        $this->default->trans_begin();
        $this->default->where('tickettext_ticket_id', $id);
        $this->default->delete('mst_ticket_text');
        $this->default->where('ticketprice_ticket_id', $id);
        $this->default->delete('mst_ticket_price');
        $this->default->where('ticketpricedef_ticket_id', $id);
        $this->default->delete('mst_ticket_pricedefault');
        $this->default->where('ticket_id', $id);
        $this->default->delete('mst_ticket');
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function getPersontype(){

        $query = "
                SELECT
                    a.`visitortype_id` AS `id`,
                    b.`visitortypetext_name` AS `name`
                FROM
                    `ref_visitortype` a
                    LEFT JOIN `ref_visitortype_text` b ON b.visitortypetext_visitortype_id = a.visitortype_id AND b.`visitortypetext_lang` = '".$this->user_lang."' 
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
}

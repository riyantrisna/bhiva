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

    public function uploadBase64Content($image, $path, $id){


        $image_name = md5(uniqid(rand(), true).date('YmdHis')).'-'.$id;
        $ext = explode(';', $image);
        $ext = explode('/', $ext[0]);
        $ext = end($ext);
        $filename = $image_name.'.'.$ext;
        $image = explode(',', $image);   
        $file = $path.$filename;

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
            $str .= " LOWER(a.`user_real_name`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(a.`user_real_name`) LIKE LOWER('%$keyword%') ";
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

    public function getExistEmail($id, $is_admin){

        $query = "
            SELECT
                a.`user_email` AS email
            FROM
                `core_user` a
            WHERE 1 = 1
            AND a.`user_is_admin` = '".$is_admin."'
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
            $str .= " LOWER(b.`slidertext_title`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`slidertext_title`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`servicetext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`servicetext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`slider_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`service_id` AS `id`,
                    a.`service_order` AS `order`,
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
            $str .= " LOWER(b.`servicetext_name`) LIKE LOWER('%$keyword%') ";
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

    //greeting
    public function getDetailGreeting($id){

        $query = "
                SELECT
                    a.`greeting_id` AS `id`,
                    a.`greeting_img` AS `img`,
                    a.`greeting_link_img` AS `link_img`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_greeting` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`greeting_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailGreetingText($id){

        $query = "
                SELECT
                    a.`greetingtext_greeting_id` AS `greeting_id`,
                    a.`greetingtext_lang` AS `lang`,
                    a.`greetingtext_text` AS `text`
                FROM
                    `cms_greeting_text` a
                WHERE 1 = 1
                AND a.`greetingtext_greeting_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function updateGreeting($data, $id, $content){
        $this->default->trans_begin();

        $this->default->where('greeting_id', $id);
        $this->default->update('cms_greeting',$data);

        $this->default->where('greetingtext_greeting_id', $id);
        $this->default->delete('cms_greeting_text');

        if(!empty($content)){
            foreach ($content as $key => $value) {
                $data = array(
                    'greetingtext_greeting_id' => $id,
                    'greetingtext_lang' => $key,
                    'greetingtext_text' => $value
                );
                $this->default->insert('cms_greeting_text',$data);
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

    //aboutus
    public function getDetailAboutus($id){

        $query = "
                SELECT
                    a.`aboutus_id` AS `id`,
                    a.`aboutus_img` AS `img`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_aboutus` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`aboutus_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailAboutusText($id){

        $query = "
                SELECT
                    a.`aboutustext_aboutus_id` AS `aboutus_id`,
                    a.`aboutustext_lang` AS `lang`,
                    a.`aboutustext_text` AS `text`
                FROM
                    `cms_aboutus_text` a
                WHERE 1 = 1
                AND a.`aboutustext_aboutus_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function updateAboutus($data, $id, $content){
        $this->default->trans_begin();

        $this->default->where('aboutus_id', $id);
        $this->default->update('cms_aboutus',$data);

        $this->default->where('aboutustext_aboutus_id', $id);
        $this->default->delete('cms_aboutus_text');

        if(!empty($content)){
            foreach ($content as $key => $value) {
                $data = array(
                    'aboutustext_aboutus_id' => $id,
                    'aboutustext_lang' => $key,
                    'aboutustext_text' => $value
                );
                $this->default->insert('cms_aboutus_text',$data);
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
            $str .= " LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`gallerytext_title`) LIKE LOWER('%$keyword%') ";
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
                    a.`gallery_link` AS `link`,
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
                    a.`gallery_link` AS `link`,
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
            $str .= " LOWER(b.`destinationtext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`destinationtext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(c.`desloc_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`destination_id` AS `id`,
                    a.`destination_desloc_id` AS `desloc_id`,
                    c.`desloc_name` AS `desloc_name`,
                    a.`destination_status` AS `status`,
                    b.`destinationtext_name` AS `name`,
                    b.`destinationtext_text` AS `text`
                FROM
                    `mst_destination` a
                    LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                    LEFT JOIN `ref_destination_location` c ON c.desloc_id = a.`destination_desloc_id`
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
            $str .= " LOWER(b.`destinationtext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`destinationtext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(c.`desloc_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`destination_id`) AS total
                FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                LEFT JOIN `ref_destination_location` c ON c.desloc_id = a.`destination_desloc_id`
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
                    a.`destination_desloc_id` AS `desloc_id`,
                    e.`desloc_name` AS `desloc_name`,
                    a.`destination_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `mst_destination` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                    LEFT JOIN `ref_destination_location` e ON e.desloc_id = a.`destination_desloc_id`
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

    public function getComboLocationDestination(){

        $query = "
                SELECT
                    a.`desloc_id` AS `id`,
                    a.`desloc_name` AS `name`
                FROM
                    `ref_destination_location` a
                ORDER BY a.desloc_order ASC
        ";
        $result = $this->default->query($query);
        return $result->result();
    }


    // venue
    public function getAllVenue($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(b.`venuetext_name`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`venuetext_name`) LIKE LOWER('%$keyword%') ";
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
            $str .= " LOWER(b.`tickettext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`ticket_id` AS `id`,
                    a.`ticket_is_type_visitor` AS `is_type_visitor`,
                    a.`ticket_min_order` AS `min_order`,
                    a.`ticket_max_order` AS `max_order`,
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
            $str .= " LOWER(b.`tickettext_name`) LIKE LOWER('%$keyword%') ";
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
                    a.`ticket_is_type_visitor` AS `is_type_visitor`,
                    a.`ticket_min_order` AS `min_order`,
                    a.`ticket_max_order` AS `max_order`,
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

    public function addTicket($data, $name, $base_price_local, $base_price_foreign, $price, $is_type_visitor, $base_price_local2, $base_price_foreign2){
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
        
        if(isset($is_type_visitor)){
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
                    if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key]) AND !empty($price['visitortype'][$key])){
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
        }else{
            $data = array(
                'ticketpricedef_ticket_id' => $ticket_id,
                'ticketpricedef_visitortype_id' => NULL,
                'ticketpricedef_price_local' => str_replace('.','',$base_price_local2),
                'ticketpricedef_price_foreign' => str_replace('.','',$base_price_foreign2)
            );
            $this->default->insert('mst_ticket_pricedefault',$data);

            if(!empty($price['start'])){
                foreach ($price['start'] as $key => $value) {
                    if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key])){
                        $data = array(
                            'ticketprice_ticket_id' => $ticket_id,
                            'ticketprice_visitortype_id' => NULL,
                            'ticketprice_start' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['end'][$key] : $price['start'][$key]),
                            'ticketprice_end' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['start'][$key] : $price['end'][$key]),
                            'ticketprice_price_local' => str_replace('.','',$price['price_local'][$key]),
                            'ticketprice_price_foreign' => str_replace('.','',$price['price_foreign'][$key])
                        );
                        $this->default->insert('mst_ticket_price',$data);
                    }
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

    public function updateTicket($data, $id, $name, $base_price_local, $base_price_foreign, $price, $is_type_visitor, $base_price_local2, $base_price_foreign2){
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

        if(isset($is_type_visitor)){
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
                    if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key]) AND !empty($price['visitortype'][$key] )){
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
        }else{
            $data = array(
                'ticketpricedef_ticket_id' => $id,
                'ticketpricedef_visitortype_id' => NULL,
                'ticketpricedef_price_local' => str_replace('.','',$base_price_local2),
                'ticketpricedef_price_foreign' => str_replace('.','',$base_price_foreign2)
            );
            $this->default->insert('mst_ticket_pricedefault',$data);

            if(!empty($price['start'])){
                foreach ($price['start'] as $key => $value) {
                    if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key])){
                        $data = array(
                            'ticketprice_ticket_id' => $id,
                            'ticketprice_visitortype_id' => NULL,
                            'ticketprice_start' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['end'][$key] : $price['start'][$key]),
                            'ticketprice_end' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['start'][$key] : $price['end'][$key]),
                            'ticketprice_price_local' => str_replace('.','',$price['price_local'][$key]),
                            'ticketprice_price_foreign' => str_replace('.','',$price['price_foreign'][$key])
                        );
                        $this->default->insert('mst_ticket_price',$data);
                    }
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


    // visitortype
    public function getAllVisitortype($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( LOWER(b.`visitortypetext_name`) LIKE LOWER('%$keyword%') ";
        }

        $query = "
            SELECT
                a.`visitortype_id` AS `id`,
                b.`visitortypetext_name` AS `name`
            FROM
                `ref_visitortype` a
                LEFT JOIN `ref_visitortype_text` b ON b.visitortypetext_visitortype_id = a.visitortype_id AND b.`visitortypetext_lang` = '".$this->user_lang."' 
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

    public function getTotalAllVisitortype($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( LOWER(b.`visitortypetext_name`) LIKE LOWER('%$keyword%') ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`visitortype_id`) AS total
                FROM 
                    `ref_visitortype` a
                    LEFT JOIN `ref_visitortype_text` b ON b.visitortypetext_visitortype_id = a.visitortype_id AND b.`visitortypetext_lang` = '".$this->user_lang."' 
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addVisitortype($data, $visitortype, $user_id, $date){
        $this->default->trans_begin();
        $this->default->insert('ref_visitortype',$data);
        $visitortype_id = $this->default->insert_id();

        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
                $data = array(
                    'visitortypetext_visitortype_id' => $visitortype_id,
                    'visitortypetext_lang' => $key,
                    'visitortypetext_name' => $value
                );
                $this->default->insert('ref_visitortype_text',$data);
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

    public function updateVisitortype($data, $id, $visitortype, $user_id, $date){
        $this->default->trans_begin();
        $this->default->where('visitortype_id', $id);
        $this->default->update('ref_visitortype',$data);

        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
                $data = array(
                    'visitortypetext_name' => $value
                );
                $this->default->where('visitortypetext_visitortype_id', $id);
                $this->default->where('visitortypetext_lang', $key);
                $this->default->update('ref_visitortype_text',$data);
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

    public function deleteVisitortype($id){
        $this->default->trans_begin();
        
        $this->default->where('visitortypetext_visitortype_id', $id);
        $this->default->delete('ref_visitortype_text');

        $this->default->where('visitortype_id', $id);
        $this->default->delete('ref_visitortype');
        
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function getDetailVisitortype($id){

        $query = "
            SELECT
                a.`visitortype_id` AS `id`,
                c.user_real_name AS insert_user,
                a.insert_datetime,
                d.user_real_name AS update_user,
                a.update_datetime
            FROM
                `ref_visitortype` a
                LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                LEFT JOIN core_user d ON d.user_id = a.update_user_id
            WHERE
                a.`visitortype_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailVisitortypeText($id){

        $query = "
            SELECT
                `visitortypetext_lang` AS `lang`,
                `visitortypetext_name` AS `name`
            FROM
                `ref_visitortype_text`
            WHERE
                `visitortypetext_visitortype_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    // tourpackages
    public function getAllTourpackages($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(b.`tourpackagestext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`tourpackages_id` AS `id`,
                    a.`tourpackages_status` AS `status`,
                    b.`tourpackagestext_name` AS `name`
                FROM
                    `mst_tourpackages` a
                    LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
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

    public function getTotalAllTourpackages($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(b.`tourpackagestext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`tourpackages_id`) AS total
                FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTourpackages($id){

        $query = "
                SELECT
                    a.`tourpackages_id` AS `id`,
                    a.`tourpackages_total_day` AS `total_day`,
                    a.`tourpackages_total_night` AS `total_night`,
                    a.`tourpackages_base_price_local` AS `base_price_local`,
                    a.`tourpackages_base_price_foreign` AS `base_price_foreign`,
                    a.`tourpackages_min_order` AS `min_order`,
                    a.`tourpackages_max_order` AS `max_order`,
                    a.`tourpackages_is_rating_manual` AS `is_rating_manual`,
                    a.`tourpackages_rating_manual` AS `rating_manual`,
                    a.`tourpackages_total_rater_manual` AS `total_rater_manual`,
                    a.`tourpackages_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `mst_tourpackages` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`tourpackages_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTourpackagesText($id){

        $query = "
                SELECT
                    a.`tourpackagestext_tourpackages_id` AS `tourpackages_id`,
                    a.`tourpackagestext_lang` AS `lang`,
                    a.`tourpackagestext_name` AS `name`,
                    a.`tourpackagestext_text` AS `text`
                FROM
                    `mst_tourpackages_text` a
                WHERE 1 = 1
                AND a.`tourpackagestext_tourpackages_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailTourpackagesImages($id){

        $query = "
                SELECT
                    a.`tourpackagesimg_tourpackages_id` AS `tourpackages_id`,
                    a.`tourpackagesimg_order` AS `order`,
                    a.`tourpackagesimg_img` AS `img`
                FROM
                    `mst_tourpackages_img` a
                WHERE 1 = 1
                AND a.`tourpackagesimg_tourpackages_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getDetailTourpackagesPrice($id){

        $query = "
                SELECT
                    a.`tourpackagesprice_tourpackages_id` AS `tourpackages_id`,
                    a.`tourpackagesprice_start` AS `start`,
                    a.`tourpackagesprice_end` AS `end`,
                    a.`tourpackagesprice_price_local` AS `price_local`,
                    a.`tourpackagesprice_price_foreign` AS `price_foreign`
                FROM
                    `mst_tourpackages_price` a
                WHERE 1 = 1
                AND a.`tourpackagesprice_tourpackages_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailTourpackagesDestination($id){

        $query = "
                SELECT
                    a.`tourpackagesdest_tourpackages_id` AS `tourpackages_id`,
                    a.`tourpackagesdest_destination_id` AS `destination_id`,
                    b.`destinationtext_name` AS `destination_name`,
                    a.`tourpackagesdest_day` AS `day`,
                    a.`tourpackagesdest_order` AS `order`
                FROM
                    `mst_tourpackages_destination` a
                    LEFT JOIN mst_destination_text b ON b.destinationtext_destination_id = a.`tourpackagesdest_destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND a.`tourpackagesdest_tourpackages_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addTourpackages($data, $name, $content, $images, $price, $destination){
        $this->default->trans_begin();

        $this->default->insert('mst_tourpackages',$data);
        $tourpackages_id = $this->default->insert_id();

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'tourpackagestext_tourpackages_id' => $tourpackages_id,
                    'tourpackagestext_lang' => $key,
                    'tourpackagestext_name' => $value,
                    'tourpackagestext_text' => $content[$key]
                );
                $this->default->insert('mst_tourpackages_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'tourpackagesimg_tourpackages_id' => $tourpackages_id,
                    'tourpackagesimg_order' => $key,
                    'tourpackagesimg_img' => $value
                );
                $this->default->insert('mst_tourpackages_img',$data);
            }
        }

        if(!empty($price['start'])){
            foreach ($price['start'] as $key => $value) {
                if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key])){
                    $data = array(
                        'tourpackagesprice_tourpackages_id' => $tourpackages_id,
                        'tourpackagesprice_start' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['end'][$key] : $price['start'][$key]),
                        'tourpackagesprice_end' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['start'][$key] : $price['end'][$key]),
                        'tourpackagesprice_price_local' => str_replace('.','',$price['price_local'][$key]),
                        'tourpackagesprice_price_foreign' => str_replace('.','',$price['price_foreign'][$key])
                    );
                    $this->default->insert('mst_tourpackages_price',$data);
                }
            }
        }

        if(!empty($destination['destination'])){
            foreach ($destination['destination'] as $key => $value) {
                if(!empty($destination['destination'][$key]) AND !empty($destination['day'][$key]) ANd !empty($destination['order'][$key])){
                    $data = array(
                        'tourpackagesdest_tourpackages_id' => $tourpackages_id,
                        'tourpackagesdest_destination_id' => $destination['destination'][$key],
                        'tourpackagesdest_day' => $destination['day'][$key],
                        'tourpackagesdest_order' => $destination['order'][$key]
                    );
                    $this->default->insert('mst_tourpackages_destination',$data);
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

    public function updateTourpackages($data, $id, $name, $content, $images, $price, $destination){
        $this->default->trans_begin();

        $this->default->where('tourpackages_id', $id);
        $this->default->update('mst_tourpackages',$data);

        $this->default->where('tourpackagestext_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_text');
        $this->default->where('tourpackagesimg_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_img');
        $this->default->where('tourpackagesprice_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_price');
        $this->default->where('tourpackagesdest_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_destination');

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'tourpackagestext_tourpackages_id' => $id,
                    'tourpackagestext_lang' => $key,
                    'tourpackagestext_name' => $value,
                    'tourpackagestext_text' => $content[$key]
                );
                $this->default->insert('mst_tourpackages_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'tourpackagesimg_tourpackages_id' => $id,
                    'tourpackagesimg_order' => $key,
                    'tourpackagesimg_img' => $value
                );
                $this->default->insert('mst_tourpackages_img',$data);
            }
        }

        if(!empty($price['start'])){
            foreach ($price['start'] as $key => $value) {
                if(!empty($price['start'][$key]) AND !empty($price['end'][$key]) ANd !empty($price['price_local'][$key]) AND !empty($price['price_foreign'][$key])){
                    $data = array(
                        'tourpackagesprice_tourpackages_id' => $id,
                        'tourpackagesprice_start' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['end'][$key] : $price['start'][$key]),
                        'tourpackagesprice_end' => ((strtotime($price['start'][$key]) > strtotime($price['end'][$key])) ? $price['start'][$key] : $price['end'][$key]),
                        'tourpackagesprice_price_local' => str_replace('.','',$price['price_local'][$key]),
                        'tourpackagesprice_price_foreign' => str_replace('.','',$price['price_foreign'][$key])
                    );
                    $this->default->insert('mst_tourpackages_price',$data);
                }
            }
        }

        if(!empty($destination['destination'])){
            foreach ($destination['destination'] as $key => $value) {
                if(!empty($destination['destination'][$key]) AND !empty($destination['day'][$key]) ANd !empty($destination['order'][$key])){
                    $data = array(
                        'tourpackagesdest_tourpackages_id' => $id,
                        'tourpackagesdest_destination_id' => $destination['destination'][$key],
                        'tourpackagesdest_day' => $destination['day'][$key],
                        'tourpackagesdest_order' => $destination['order'][$key]
                    );
                    $this->default->insert('mst_tourpackages_destination',$data);
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

    public function deleteTourpackages($id){
        $this->default->trans_begin();

        $this->default->where('tourpackagesprice_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_price');

        $this->default->where('tourpackagesdest_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_destination');

        $this->default->where('tourpackagestext_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_text');
        
        $this->default->where('tourpackagesimg_tourpackages_id', $id);
        $this->default->delete('mst_tourpackages_img');

        $this->default->where('tourpackages_id', $id);
        $this->default->delete('mst_tourpackages');

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function getDestination(){

        $query = "
                SELECT
                    a.`destinationtext_destination_id` AS `id`,
                    a.`destinationtext_name` AS `name`
                FROM
                    `mst_destination_text` a
                WHERE
                    a.`destinationtext_lang` = '".$this->user_lang."' 
                ORDER BY a.`destinationtext_name`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }


    // Tourpackages Testimony
    public function getAllTourpackagesTestimony($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(a.`tourpackagestesti_user_real_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`tourpackagestesti_testimony`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`tourpackagestesti_rating`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`tourpackagestesti_token` AS token,
                    a.`tourpackagestesti_tourpackages_id` AS tourpackages_id,
                    a.`tourpackagestesti_user_id` AS user_id,
                    a.`tourpackagestesti_user_real_name` AS user_real_name,
                    b.`user_photo` AS photo,
                    a.`tourpackagestesti_testimony` AS testimony,
                    a.`tourpackagestesti_date` AS `date`,
                    a.`tourpackagestesti_rating` AS rating,
                    a.`tourpackagestesti_is_process` AS is_process,
                    a.`tourpackagestesti_is_publish` AS is_publish,
                    a.`insert_datetime`
                FROM
                    `mst_tourpackages_testimony`  a
                    LEFT JOIN `core_user` b ON b.`user_id` = a.`tourpackagestesti_user_id`
                WHERE
                    a.`tourpackagestesti_tourpackages_id` =  $id
        ";
        $query.= $str;
        $query .= " ORDER BY $order $dir ";
        if (isset($start) AND $start != '') {
            $query .= " LIMIT $start, $length";
        }
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalAllTourpackagesTestimony($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(a.`tourpackagestesti_user_real_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`tourpackagestesti_testimony`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`tourpackagestesti_rating`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(*) AS total
                FROM 
                    `mst_tourpackages_testimony`  a
                    LEFT JOIN `core_user` b ON b.`user_id` = a.`tourpackagestesti_user_id`
                WHERE
                    a.`tourpackagestesti_tourpackages_id` =  $id
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTourpackagesTitle($id){

        $query = "
                SELECT
                    a.`tourpackagestext_tourpackages_id` AS `tourpackages_id`,
                    a.`tourpackagestext_lang` AS `lang`,
                    a.`tourpackagestext_name` AS `name`,
                    a.`tourpackagestext_text` AS `text`
                FROM
                    `mst_tourpackages_text` a 
                WHERE 1 = 1
                AND a.`tourpackagestext_lang` = '".$this->user_lang."'
                AND  a.`tourpackagestext_tourpackages_id` = $id
                
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTourpackagesTestimony($id){

        $query = "
                SELECT
                    a.`tourpackagestesti_token` AS token,
                    a.`tourpackagestesti_tourpackages_id` AS tourpackages_id,
                    f.`tourpackagestext_name` AS tourpackages_name,
                    a.`tourpackagestesti_user_id` AS user_id,
                    a.`tourpackagestesti_user_real_name` AS user_real_name,
                    e.`user_photo` AS photo,
                    a.`tourpackagestesti_date` AS `date`,
                    a.`tourpackagestesti_testimony` AS testimony,
                    a.`tourpackagestesti_rating` AS rating,
                    a.`tourpackagestesti_is_process` AS is_process,
                    a.`tourpackagestesti_is_publish` AS is_publish,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `mst_tourpackages_testimony` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                    LEFT JOIN core_user e ON e.user_id = a.`tourpackagestesti_user_id`
                    LEFT JOIN `mst_tourpackages_text` f ON f.tourpackagestext_tourpackages_id = a.tourpackagestesti_tourpackages_id AND f.`tourpackagestext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                AND a.`tourpackagestesti_token` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function updateTourpackagesTestimony($data, $id){
        $this->default->trans_begin();

        $this->default->where('tourpackagestesti_token', $id);
        $this->default->update('mst_tourpackages_testimony',$data);

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteTourpackagesTestimony($id){
        $this->default->trans_begin();
        $this->default->where('tourpackagestesti_token', $id);
        $this->default->delete('mst_tourpackages_testimony');
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }


    // destinationlocation
    public function getAllDestinationlocation($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(a.`desloc_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`desloc_order`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`desloc_is_show_home`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
            SELECT 
                a.`desloc_id` AS `id`,
                a.`desloc_name` AS `name`,
                a.`desloc_order` AS `order`,
                a.`desloc_is_show_home` AS `is_show_home`
            FROM
                `ref_destination_location` a
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

    public function getTotalAllDestinationlocation($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(a.`desloc_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`desloc_order`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`desloc_is_show_home`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`desloc_id`) AS total
                FROM 
                    ref_destination_location a 
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailDestinationlocation($id){

        $query = "
            SELECT 
                a.`desloc_id` AS `id`,
                a.`desloc_name` AS `name`,
                a.`desloc_order` AS `order`,
                a.`desloc_is_show_home` AS `is_show_home`,
                c.user_real_name AS insert_user,
                a.insert_datetime,
                d.user_real_name AS update_user,
                a.update_datetime
            FROM
                `ref_destination_location` a
                LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                LEFT JOIN core_user d ON d.user_id = a.update_user_id
            WHERE 1 = 1
            AND a.`desloc_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addDestinationlocation($data){
        $query = $this->default->insert('ref_destination_location',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updateDestinationlocation($data, $id){
        $this->default->where('desloc_id', $id);
        $query = $this->default->update('ref_destination_location',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function deleteDestinationlocation($id){
        $this->default->where('desloc_id', $id);
        $query = $this->default->delete('ref_destination_location');
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }


    // travelpost
    public function getAllTravelpost($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(b.`travelposttext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`travelposttext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`travelpost_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT
                    a.`travelpost_id` AS `id`,
                    a.`travelpost_status` AS `status`,
                    b.`travelposttext_name` AS `name`,
                    b.`travelposttext_text` AS `text`
                FROM
                    `cms_travelpost` a
                    LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
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

    public function getTotalAllTravelpost($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($keyword)){
            $str .= " AND ( ";
            $str .= " LOWER(b.`travelposttext_name`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(b.`travelposttext_text`) LIKE LOWER('%$keyword%') ";
            $str .= " OR LOWER(a.`travelpost_order`) LIKE LOWER('%$keyword%') ";
            $str .= " ) ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`travelpost_id`) AS total
                FROM 
                `cms_travelpost` a
                LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTravelpost($id){

        $query = "
                SELECT
                    a.`travelpost_id` AS `id`,
                    a.`travelpost_status` AS `status`,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `cms_travelpost` a
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`travelpost_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTravelpostText($id){

        $query = "
                SELECT
                    a.`travelposttext_travelpost_id` AS `travelpost_id`,
                    a.`travelposttext_lang` AS `lang`,
                    a.`travelposttext_name` AS `name`,
                    a.`travelposttext_text` AS `text`
                FROM
                    `cms_travelpost_text` a
                WHERE 1 = 1
                AND a.`travelposttext_travelpost_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDetailTravelpostImages($id){

        $query = "
                SELECT
                    a.`travelpostimg_travelpost_id` AS `travelpost_id`,
                    a.`travelpostimg_order` AS `order`,
                    a.`travelpostimg_img` AS `img`
                FROM
                    `cms_travelpost_img` a
                WHERE 1 = 1
                AND a.`travelpostimg_travelpost_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addTravelpost($data, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->insert('cms_travelpost',$data);
        $travelpost_id = $this->default->insert_id();

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'travelposttext_travelpost_id' => $travelpost_id,
                    'travelposttext_lang' => $key,
                    'travelposttext_name' => $value,
                    'travelposttext_text' => $content[$key]
                );
                $this->default->insert('cms_travelpost_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'travelpostimg_travelpost_id' => $travelpost_id,
                    'travelpostimg_order' => $key,
                    'travelpostimg_img' => $value
                );
                $this->default->insert('cms_travelpost_img',$data);
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

    public function updateTravelpost($data, $id, $name, $content, $images){
        $this->default->trans_begin();

        $this->default->where('travelpost_id', $id);
        $this->default->update('cms_travelpost',$data);

        $this->default->where('travelposttext_travelpost_id', $id);
        $this->default->delete('cms_travelpost_text');
        
        $this->default->where('travelpostimg_travelpost_id', $id);
        $this->default->delete('cms_travelpost_img');

        if(!empty($name)){
            foreach ($name as $key => $value) {
                $data = array(
                    'travelposttext_travelpost_id' => $id,
                    'travelposttext_lang' => $key,
                    'travelposttext_name' => $value,
                    'travelposttext_text' => $content[$key]
                );
                $this->default->insert('cms_travelpost_text',$data);
            }
        }

        if(!empty($images)){
            foreach ($images as $key => $value) {
                $data = array(
                    'travelpostimg_travelpost_id' => $id,
                    'travelpostimg_order' => $key,
                    'travelpostimg_img' => $value
                );
                $this->default->insert('cms_travelpost_img',$data);
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

    public function deleteTravelpost($id){
        $this->default->trans_begin();

        $this->default->where('travelposttext_travelpost_id', $id);
        $this->default->delete('cms_travelpost_text');
        
        $this->default->where('travelpostimg_travelpost_id', $id);
        $this->default->delete('cms_travelpost_img');

        $this->default->where('travelpost_id', $id);
        $this->default->delete('cms_travelpost');

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }


     // transaction
     public function getAllTransaction($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($number)){
            $str .= " AND LOWER(a.`transaction_code`) LIKE LOWER('%$number%') ";
        }

        if(!empty($type)){
            $str .= " AND a.`transaction_type` = '$type' ";
        }

        if(!empty($status)){
            $str .= " AND a.`transaction_status` ='$status' ";
        }

        $query = "
            SELECT
                a.`transaction_id` AS `id`,
                a.`transaction_code` AS `code`,
                a.`transaction_date` AS `date`,
                a.`transaction_type` AS `type`,
                a.`transaction_status` AS `status`,
                b.transactionticket_status AS status_ticket
            FROM
                `trx_transaction` a
                LEFT JOIN trx_transaction_ticket b ON b.transactionticket_transaction_id = a.transaction_id
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

    public function getTotalAllTransaction($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($number)){
            $str .= " AND LOWER(a.`transaction_code`) LIKE LOWER('%$number%') ";
        }

        if(!empty($type)){
            $str .= " AND a.`transaction_type` = '$type' ";
        }

        if(!empty($status)){
            $str .= " AND a.`transaction_status` ='$status' ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`transaction_id`) AS total
                FROM 
                    `trx_transaction` a
                    LEFT JOIN trx_transaction_ticket b ON b.transactionticket_transaction_id = a.transaction_id
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTransactionTypeById($id){

        $query = "
            SELECT
                a.`transaction_type` AS type
            FROM
                `trx_transaction` a
            WHERE
                1 = 1
                AND a.`transaction_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        $data = $result->row();
        if(!empty($data)){
            return $data->type;
        }else{
            return '';
        }
    }

    public function getDetailTransactionTourpackagesByUserId($id){

        $query = "
            SELECT
                a.`transaction_id` AS id,
                a.`transaction_code` AS code,
                a.`transaction_date` AS date,
                a.`transaction_type` AS type,
                a.`transaction_user_id` AS user_id,
                a.`transaction_user_real_name` AS user_real_name,
                a.`transaction_total` AS total,
                a.`transaction_status` AS status,
                a.`transaction_midtrans_snap_token` AS midtrans_snap_token,
                a.`transaction_midtrans_transaction_id` AS midtrans_transaction_id,
                a.`transaction_midtrans_response` AS midtrans_response,
                a.`transaction_payment_type` AS payment_type,

                b.`transactiontourpackages_contact_name` AS contact_name,
                b.`transactiontourpackages_contact_email` AS contact_email,
                b.`transactiontourpackages_contact_phone` AS contact_phone,
                b.`transactiontourpackages_tourpackages_id` AS tourpackages_id,
                CONCAT(c.`tourpackagestext_name`, ' <b>(', b.`transactiontourpackages_total_day`,' ".MultiLang('day')." ', b.`transactiontourpackages_total_night`,' ".MultiLang('night')."',')</b>') AS tourpackages_name,
                b.`transactiontourpackages_date_tour` AS date_tour,
                b.`transactiontourpackages_price_foreign_tourists` AS price_foreign_tourists,
                b.`transactiontourpackages_price_local_tourists` AS price_local_tourists,
                b.`transactiontourpackages_qty_foreign_tourists` AS qty_foreign_tourists,
                b.`transactiontourpackages_qty_local_tourists` AS qty_local_tourists,
                b.`transactiontourpackages_total_foreign_tourists` AS total_foreign_tourists,
                b.`transactiontourpackages_total_local_tourists` AS total_local_tourists
                
            FROM
                `trx_transaction` a 
            LEFT JOIN `trx_transaction_tourpackages` b ON b.`transactiontourpackages_transaction_id` = a.`transaction_id`
            LEFT JOIN `mst_tourpackages_text` c ON c.`tourpackagestext_tourpackages_id` = b.`transactiontourpackages_tourpackages_id` AND c.`tourpackagestext_lang` = '".$this->user_lang."'
            WHERE
                1 = 1
                AND a.`transaction_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailTransactionTouristById($id){
        $query = "
            SELECT
                a.`transactiontourtourist_transaction_id` AS `transaction_id`,
                a.`transactiontourtourist_name` AS `name`,
                a.`transactiontourtourist_id_number` AS `id_number`,
                a.`transactiontourtourist_type` AS `type`
            FROM
                `trx_transaction_tourist` a
            WHERE
                a.`transactiontourtourist_transaction_id` = '".$id."'
        ";
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getDetailTransactionTicketByUserId($id){

        $query = "
            SELECT
                a.`transaction_id` AS id,
                a.`transaction_code` AS code,
                a.`transaction_date` AS date,
                a.`transaction_type` AS type,
                a.`transaction_user_id` AS user_id,
                a.`transaction_user_real_name` AS user_real_name,
                a.`transaction_total` AS total,
                a.`transaction_status` AS status,
                a.`transaction_midtrans_snap_token` AS midtrans_snap_token,
                a.`transaction_midtrans_transaction_id` AS midtrans_transaction_id,
                a.`transaction_midtrans_response` AS midtrans_response,
                a.`transaction_payment_type` AS payment_type,

                b.`transactionticket_ticket_id` AS ticket_id,
                b.`transactionticket_visit_date` AS visit_date,
                b.`transactionticket_file` AS file,
                b.`transactionticket_status` AS status_ticket,
                c.tickettext_name AS ticket_name,

                d.user_real_name AS contact_name,
                d.user_email AS contact_email,
                d.user_phone AS contact_phone
                
            FROM
                `trx_transaction` a 
                LEFT JOIN `trx_transaction_ticket` b ON b.`transactionticket_transaction_id` = a.`transaction_id`
                LEFT JOIN `mst_ticket_text` c ON c.`tickettext_ticket_id` = b.`transactionticket_ticket_id` AND c.`tickettext_lang` = '".$this->user_lang."'
                LEFT JOIN core_user d ON d.user_id = a.`transaction_user_id`
            WHERE
                1 = 1
                AND a.`transaction_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getTransactionTicketDetail($transaction_id, $tourists_type){
        $query = "
            SELECT
                a.`transactionticketdet_ticket_id` AS ticket_id,
                a.`transactionticketdet_ticket_is_type` AS ticket_is_type,
                a.`transactionticketdet_visitortype_id` AS visitortype_id,
                a.`transactionticketdet_visitortype_name` AS visitortype_name,
                a.`transactionticketdet_tourists_type` AS tourists_type,
                a.`transactionticketdet_qty` AS qty,
                a.`transactionticketdet_price` AS price,
                a.`transactionticketdet_sub_total` AS sub_total
            FROM
                `trx_transaction_ticket_detail` a
            WHERE
                a.`transactionticketdet_transaction_id` = '".$transaction_id."'
                AND a.`transactionticketdet_tourists_type` = '".$tourists_type."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function updateTransactionTicket($data, $id){
        $this->default->trans_begin();
        $this->default->where('transactionticket_transaction_id', $id);
        $this->default->update('trx_transaction_ticket',$data);

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function getDetailTransactionTicketNumber($id){

        $query = "
            SELECT
                `transactionticketnum_transaction_id` AS `transaction_id`,
                `transactionticketnum_ticket_id` AS `ticket_id`,
                `transactionticketnum_ticket_number` AS `ticket_number`
            FROM
                `trx_transaction_ticket_number`
            WHERE
                `transactionticketnum_transaction_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function addTransactionTicketNumber($data){
        $this->default->trans_begin();
        $this->default->insert('trx_transaction_ticket_number',$data);

        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function deleteTransactionTicketNumber($number){
        $this->default->trans_begin();
        
        $this->default->where('transactionticketnum_ticket_number', $number);
        $this->default->delete('trx_transaction_ticket_number');
        
        $this->default->trans_complete();
        if ($this->default->trans_status() === FALSE){
            $this->default->trans_rollback();
            return FALSE;
        }else{
            $this->default->trans_commit();
            return TRUE;
        }
    }

    public function checkTransactionTicketNumber($number){

        $query = "
            SELECT
                a.`transactionticketnum_ticket_number` AS number
            FROM
                `trx_transaction_ticket_number` a
            WHERE
                1 = 1
                AND a.`transactionticketnum_ticket_number` = '".$number."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }


    // Venueschedule
    public function getAllVenueschedule($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($venue_id)){
            $str .= " AND a.`transactionvenue_venue_id` = '$venue_id' ";
        }

        if(!empty($schedule_date)){
            $str .= " AND '$schedule_date' BETWEEN a.`transactionvenue_date_start` AND a.`transactionvenue_date_end` ";
        }

        $query = "
            SELECT 
                a.`transactionvenue_id` AS `id`,
                a.`transactionvenue_venue_id` AS `venue_id`,
                b.venuetext_name AS venue_name,
                a.`transactionvenue_date_start` AS date_start,
                a.`transactionvenue_date_end` AS date_end
            FROM
                `trx_transaction_venue` a
                LEFT JOIN mst_venue_text b ON b.venuetext_venue_id = a.transactionvenue_venue_id AND b.venuetext_lang = '".$this->user_lang."'
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

    public function getTotalAllVenueschedule($filter){
        if (is_array($filter))
        extract($filter);
        $str = '';

        if(!empty($venue_id)){
            $str .= " AND a.`transactionvenue_venue_id` = '$venue_id' ";
        }

        if(!empty($schedule_date)){
            $str .= " AND '$schedule_date' BETWEEN a.`transactionvenue_date_start` AND a.`transactionvenue_date_end` ";
        }

        $query = "
                SELECT 
                    COUNT(DISTINCT a.`transactionvenue_id`) AS total
                FROM
                    `trx_transaction_venue` a
                    LEFT JOIN mst_venue_text b ON b.venuetext_venue_id = a.transactionvenue_venue_id AND b.venuetext_lang = '".$this->user_lang."'
                WHERE 1 = 1
                ";
        $query.= $str;
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDetailVenueschedule($id){

        $query = "
                SELECT 
                    a.`transactionvenue_id` AS `id`,
                    a.`transactionvenue_venue_id` AS `venue_id`,
                    b.venuetext_name AS venue_name,
                    a.`transactionvenue_date_start` AS date_start,
                    a.`transactionvenue_date_end` AS date_end,
                    c.user_real_name AS insert_user,
                    a.insert_datetime,
                    d.user_real_name AS update_user,
                    a.update_datetime
                FROM
                    `trx_transaction_venue` a
                    LEFT JOIN mst_venue_text b ON b.venuetext_venue_id = a.transactionvenue_venue_id AND b.venuetext_lang = '".$this->user_lang."'
                    LEFT JOIN core_user c ON c.user_id = a.insert_user_id
                    LEFT JOIN core_user d ON d.user_id = a.update_user_id
                WHERE 1 = 1
                AND a.`transactionvenue_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addVenueschedule($data){
        $query = $this->default->insert('trx_transaction_venue',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updateVenueschedule($data, $id){
        $this->default->where('transactionvenue_id', $id);
        $query = $this->default->update('trx_transaction_venue',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function deleteVenueschedule($id){
        $this->default->where('transactionvenue_id', $id);
        $query = $this->default->delete('trx_transaction_venue');
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getListVenue(){

        $query = "
            SELECT
                a.`venuetext_venue_id` AS `id`,
                a.venuetext_name AS name
            FROM
                mst_venue_text a 
            WHERE 1 = 1
            AND a.venuetext_lang = '".$this->user_lang."'
        ";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function checkVenueSchedule($start, $end, $venue_id, $id_edit=''){

        if(!empty($id_edit)){
            $str = " AND a.`transactionvenue_id` NOT IN ($id_edit) ";
        }else{
            $str = "";
        }
        $query = "
            SELECT
                a.`transactionvenue_id` AS id
            FROM 
                `trx_transaction_venue` a
            WHERE 
                a.`transactionvenue_venue_id` = '".$venue_id."'
                AND 
                (
                    '".$start."' BETWEEN a.`transactionvenue_date_start` AND a.`transactionvenue_date_end`
                    OR '".$end."' BETWEEN a.`transactionvenue_date_start` AND a.`transactionvenue_date_end`
                )
                ".$str."
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getSetting($key){
        $query = "
            SELECT
                a.`setting_value` AS value
            FROM 
                `core_setting` a
            WHERE 
                a.`setting_key` = '".$key."'
        ";
        $result = $this->default->query($query);
        $data = $result->row();
        if(!empty($data)){
            return $data->value;
        }else{
            return '';
        }
    }

    public function getTemplateEmail($key){
        $query = "
            SELECT
                a.`emailtemplate_from` AS from,
                a.`emailtemplate_from_name` AS from_name,
                b.`emailtemplate_subject` AS subject,
                b.`emailtemplate_content` AS content
            FROM 
                `cms_email_template` a
                LEFT JOIN cms_email_template_text b ON b.emailtemplatetext_emailtemplate_id = a.emailtemplate_id AND b.`venuetext_lang` = '".$this->user_lang."'
            WHERE 
                a.`emailtemplate_key` = '".$key."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function addEmail($data){
        $query = $this->default->insert('cms_email_log',$data);
        if ($this->default->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function addEmailSend($key_template, $to, $cc, $send_schedule, $data){
				
		$template_email = $this->getTemplateEmail($key_template);

		if(!empty($template_email)){
			$subject = $template_email->subject;
			$content = $template_email->content;
			
			if(!empty($data)){
				foreach ($data as $key_post => $val_post) {
					$subject = str_replace('[' . strtoupper($key_post) . ']', $val_post, $subject);
				}

				$data['title'] = $subject;
				foreach ($data as $key_post => $val_post) {
					$content = str_replace('[' . strtoupper($key_post) . ']', $val_post, $content);
				}
			}

			$data = array(
				'emaillog_to' => $to,
				'emaillog_cc' => $cc,
				'emaillog_subject' => $subject,
				'emaillog_from' => $template_email->from_name,
				'emaillog_content' => $content,
				'emaillog_send_schedule' => $send_schedule,
				'emaillog_status' => 0,
				'insert_user_id' => $this->session->userdata('user_id'),
				'insert_datetime' => date('Y-m-d H:i:s')
			);
			$results = $this->addEmailSend($data);
		}else{
			$results = FALSE;
		}

		return $results;
    }
    
    public function getDetailTransactionByCode($code){

        $query = "
            SELECT
                a.`transaction_id` AS id,
                a.`transaction_code` AS code,
                a.`transaction_date` AS date,
                a.`transaction_type` AS type,
                a.`transaction_user_id` AS user_id,
                a.`transaction_user_real_name` AS user_real_name,
                a.`transaction_total` AS total,
                a.`transaction_status` AS status,
                a.`transaction_midtrans_snap_token` AS midtrans_snap_token,
                a.`transaction_midtrans_transaction_id` AS midtrans_transaction_id,
                a.`transaction_midtrans_response` AS midtrans_response,
                a.`transaction_payment_type` AS payment_type,

                b.user_real_name AS contact_name,
                b.user_email AS contact_email,
                b.user_phone AS contact_phone
                
            FROM
                `trx_transaction` a
                LEFT JOIN core_user b ON b.user_id = a.`transaction_user_id`
            WHERE
                1 = 1
                AND a.`transaction_code` = '".$code."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }
    
}

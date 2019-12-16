<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->default = $this->load->database('default', TRUE);
        $this->user_lang = !empty($this->session->userdata('user_lang')) ? $this->session->userdata('user_lang') : 'id';
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

    public function getSlider(){
        $path_slider_upload = $this->config->item('path_slider_upload');
        $query = "
            SELECT
                a.`slider_id` AS `id`,
                a.`slider_link` AS link,
                a.`slider_order` AS 'order',
                CONCAT('".$path_slider_upload."',a.`slider_img`) AS img,
                b.`slidertext_title` AS title,
                b.`slidertext_title_link` AS title_link,
                b.`slidertext_text` AS 'text'
            FROM
                `cms_slider` a 
            LEFT JOIN `cms_slider_text` b ON b.`slidertext_slider_id` = a.`slider_id` AND b.`slidertext_lang` = '".$this->user_lang."'
            WHERE
                a.`slider_status` = 1
            ORDER BY 
                a.`slider_order`
            LIMIT 7
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getTourpackages(){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $query = "
            SELECT
                a.`tourpackages_id` AS id,
                a.`tourpackages_total_day` AS total_day,
                a.`tourpackages_total_night` AS total_night,
                IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) AS `price_local`,
                IFNULL(d.`tourpackagesprice_price_foreign`, a.`tourpackages_base_price_foreign`) AS `price_foreign`,
                b.`tourpackagestext_name` AS 'name',
                CONCAT('".$path_tourpackages_upload."',c.`tourpackagesimg_img`) AS 'img',
                IFNULL(
                CASE
                    WHEN a.tourpackages_is_rating_manual = 1 THEN
                        a.tourpackages_rating_manual
                    ELSE
                        (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                END, 0) AS rating
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
            ORDER BY 
            (
                CASE
                WHEN a.tourpackages_is_rating_manual = 1 THEN
                    a.tourpackages_rating_manual
                ELSE
                    (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                END
            ) DESC
            LIMIT 4
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getTotalTourpackagesBegin(){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $query = "
            SELECT
                a.`tourpackages_id` AS id
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
        ";
        $result = $this->default->query($query);
        return $result->num_rows();
    }
    
    public function getTourpackagesBegin(){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $query = "
            SELECT
                a.`tourpackages_id` AS id,
                a.`tourpackages_total_day` AS total_day,
                a.`tourpackages_total_night` AS total_night,
                IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) AS `price_local`,
                IFNULL(d.`tourpackagesprice_price_foreign`, a.`tourpackages_base_price_foreign`) AS `price_foreign`,
                b.`tourpackagestext_name` AS 'name',
                CONCAT('".$path_tourpackages_upload."',c.`tourpackagesimg_img`) AS 'img',
                IFNULL(
                CASE
                    WHEN a.tourpackages_is_rating_manual = 1 THEN
                        a.tourpackages_rating_manual
                    ELSE
                        (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                END, 0) AS rating
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
            ORDER BY 
                a.`tourpackages_id` DESC
            LIMIT 15
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getTotalTourpackagesFilter($filter){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $str = "";

        if(!empty($filter['orderby']) AND $filter['orderby']=='latest'){
            $order = " a.`tourpackages_id` DESC ";
        }elseif(!empty($filter['orderby']) AND $filter['orderby']=='most_popular'){
            $order = "
                (
                    CASE
                    WHEN a.tourpackages_is_rating_manual = 1 THEN
                        a.tourpackages_rating_manual
                    ELSE
                        (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                    END
                ) DESC
            ";
        }elseif(!empty($filter['orderby']) AND $filter['orderby']=='lowest_price'){
            $order = " IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) ASC ";
        }elseif(!empty($filter['orderby']) AND $filter['orderby']=='highest_price'){
            $order = " IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) DESC ";
        }else{
            $order = " a.`tourpackages_id` DESC ";
        }

        if(!empty($filter['destination'])){
            $i = 1;
            $str.= " AND (";
            foreach ($filter['destination'] as $key => $value) {
                if($i == 1){
                    $str.= $key." IN (SELECT mtd.tourpackagesdest_destination_id FROM mst_tourpackages_destination mtd WHERE mtd.tourpackagesdest_tourpackages_id = a.`tourpackages_id`) ";
                }else{
                    $str.= " OR ".$key." IN (SELECT mtd.tourpackagesdest_destination_id FROM mst_tourpackages_destination mtd WHERE mtd.tourpackagesdest_tourpackages_id = a.`tourpackages_id`) ";
                }
                $i++;
            }
            $str.= " ) ";
        }

        if(!empty($filter['price_min'])){
            $str.= " AND IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) >= ".$filter['price_min'];
        }

        if(!empty($filter['price_max'])){
            $str.= " AND IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) <= ".$filter['price_max'];
        }

        if(!empty($filter['time'])){
            $time = explode(',', $filter['time']);
            $str.=" AND (a.`tourpackages_total_day` = $time[0] AND a.`tourpackages_total_night` = $time[1])";
        }

        if(!empty($filter['rating'])){
            $i = 1;
            $str.= " AND (";
            foreach ($filter['rating'] as $key => $value) {
                if($i == 1){
                    $str.= "
                    (
                        CASE
                        WHEN a.tourpackages_is_rating_manual = 1 THEN
                            a.tourpackages_rating_manual
                        ELSE
                            (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                        END
                    ) BETWEEN ".($value-(0.9))." AND ".$value
                    ;
                }else{
                    $str.= " 
                    OR (
                        CASE
                        WHEN a.tourpackages_is_rating_manual = 1 THEN
                            a.tourpackages_rating_manual
                        ELSE
                            (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                        END
                    ) BETWEEN ".($value-(0.9))." AND ".$value
                    ;
                }
                $i++;
            }
            $str.= " ) ";
        }

        $query = "
            SELECT
                a.`tourpackages_id` AS id
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
                ".$str."
        ";
        $result = $this->default->query($query);
        return $result->num_rows();
    }
    
    public function getTourpackagesFilter($filter, $page, $limit){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $str = "";

        if(!empty($filter['orderby']) AND $filter['orderby']=='latest'){
            $order = " a.`tourpackages_id` DESC ";
        }elseif(!empty($filter['orderby']) AND $filter['orderby']=='most_popular'){
            $order = "
                (
                    CASE
                    WHEN a.tourpackages_is_rating_manual = 1 THEN
                        a.tourpackages_rating_manual
                    ELSE
                        (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                    END
                ) DESC
            ";
        }elseif(!empty($filter['orderby']) AND $filter['orderby']=='lowest_price'){
            $order = " IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) ASC ";
        }elseif(!empty($filter['orderby']) AND $filter['orderby']=='highest_price'){
            $order = " IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) DESC ";
        }else{
            $order = " a.`tourpackages_id` DESC ";
        }

        if(!empty($filter['destination'])){
            $i = 1;
            $str.= " AND (";
            foreach ($filter['destination'] as $key => $value) {
                if($i == 1){
                    $str.= $key." IN (SELECT mtd.tourpackagesdest_destination_id FROM mst_tourpackages_destination mtd WHERE mtd.tourpackagesdest_tourpackages_id = a.`tourpackages_id`) ";
                }else{
                    $str.= " OR ".$key." IN (SELECT mtd.tourpackagesdest_destination_id FROM mst_tourpackages_destination mtd WHERE mtd.tourpackagesdest_tourpackages_id = a.`tourpackages_id`) ";
                }
                $i++;
            }
            $str.= " ) ";
        }

        if(!empty($filter['price_min'])){
            $str.= " AND IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) >= ".$filter['price_min'];
        }

        if(!empty($filter['price_max'])){
            $str.= " AND IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) <= ".$filter['price_max'];
        }

        if(!empty($filter['time'])){
            $time = explode(',', $filter['time']);
            $str.=" AND (a.`tourpackages_total_day` = $time[0] AND a.`tourpackages_total_night` = $time[1])";
        }

        if(!empty($filter['rating'])){
            $i = 1;
            $str.= " AND (";
            foreach ($filter['rating'] as $key => $value) {
                if($i == 1){
                    $str.= "
                    (
                        CASE
                        WHEN a.tourpackages_is_rating_manual = 1 THEN
                            a.tourpackages_rating_manual
                        ELSE
                            (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                        END
                    ) BETWEEN ".($value-(0.9))." AND ".$value
                    ;
                }else{
                    $str.= " 
                    OR (
                        CASE
                        WHEN a.tourpackages_is_rating_manual = 1 THEN
                            a.tourpackages_rating_manual
                        ELSE
                            (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                        END
                    ) BETWEEN ".($value-(0.9))." AND ".$value
                    ;
                }
                $i++;
            }
            $str.= " ) ";
        }

        $query = "
            SELECT
                a.`tourpackages_id` AS id,
                a.`tourpackages_total_day` AS total_day,
                a.`tourpackages_total_night` AS total_night,
                IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) AS `price_local`,
                IFNULL(d.`tourpackagesprice_price_foreign`, a.`tourpackages_base_price_foreign`) AS `price_foreign`,
                b.`tourpackagestext_name` AS 'name',
                CONCAT('".$path_tourpackages_upload."',c.`tourpackagesimg_img`) AS 'img',
                IFNULL(
                CASE
                    WHEN a.tourpackages_is_rating_manual = 1 THEN
                        a.tourpackages_rating_manual
                    ELSE
                        (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                END, 0) AS rating
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
                ".$str."
            ORDER BY 
                ".$order."
            LIMIT ".$page." , ".$limit."
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getTourpackagesDetail($id){
        $query = "
            SELECT
                a.`tourpackages_id` AS id,
                a.`tourpackages_total_day` AS total_day,
                a.`tourpackages_total_night` AS total_night,
                IFNULL(d.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) AS `price_local`,
                IFNULL(d.`tourpackagesprice_price_foreign`, a.`tourpackages_base_price_foreign`) AS `price_foreign`,
                a.`tourpackages_min_order` AS min_order,
                a.`tourpackages_max_order` AS max_order,
                b.`tourpackagestext_name` AS 'name',
                b.`tourpackagestext_text` AS 'text',
                IFNULL(
                CASE
                    WHEN a.tourpackages_is_rating_manual = 1 THEN
                        a.tourpackages_rating_manual
                    ELSE
                        (SELECT SUM(tourpackagestesti_rating) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`) / (SELECT COUNT(*) FROM mst_tourpackages_testimony mtt WHERE mtt.tourpackagestesti_tourpackages_id = a.`tourpackages_id`)
                END, 0) AS rating
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
                AND a.`tourpackages_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getTourpackagesDetailImage($id){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $query = "
            SELECT
                CONCAT('".$path_tourpackages_upload."',a.`tourpackagesimg_img`) AS 'img'
            FROM
                `mst_tourpackages_img` a
            WHERE
                a.`tourpackagesimg_tourpackages_id` = '".$id."'
                AND a.`tourpackagesimg_img` IS NOT NULL
            ORDER BY 
                a.`tourpackagesimg_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getDetailTourpackagesPrice($filter){
        $query = "
            SELECT
                a.`tourpackages_id` AS id,
                IFNULL(b.`tourpackagesprice_price_local`, a.`tourpackages_base_price_local`) AS `price_local`,
                IFNULL(b.`tourpackagesprice_price_foreign`, a.`tourpackages_base_price_foreign`) AS `price_foreign`
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_price` b ON b.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND '".$filter['date_tour']."' BETWEEN b.`tourpackagesprice_start` AND b.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
                AND a.`tourpackages_id` = '".$filter['id']."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }
    
    public function getTourpackagesTestimony($id, $page, $limit){
        $path_user_upload = $this->config->item('path_user_upload');
        $query = "
            SELECT
                a.tourpackagestesti_user_real_name AS user_real_name,
                a.tourpackagestesti_date AS date,
                a.tourpackagestesti_testimony AS testimony,
                a.tourpackagestesti_rating AS rating,
                CONCAT('".$path_user_upload."',b.`user_photo`) AS 'user_photo'
            FROM
                `mst_tourpackages_testimony` a
                LEFT JOIN core_user b ON b.user_id = a.tourpackagestesti_user_id
            WHERE
                a.`tourpackagestesti_tourpackages_id` = '".$id."'
                AND a.tourpackagestesti_is_publish = 1
            ORDER BY 
                a.`tourpackagestesti_date` DESC
            LIMIT ".$page." , ".$limit."
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getTourpackagesTestimonyTotal($id){
        $query = "
            SELECT
                a.`tourpackagestesti_tourpackages_id`
            FROM
                `mst_tourpackages_testimony` a
                LEFT JOIN core_user b ON b.user_id = a.tourpackagestesti_user_id
            WHERE
                a.`tourpackagestesti_tourpackages_id` = '".$id."'
                AND a.tourpackagestesti_is_publish = 1
        ";
        $result = $this->default->query($query);
        return $result->num_rows();
    }

    public function getTourpackagesDestinationDays($id){
        $query = "
            SELECT
                MAX(a.tourpackagesdest_day) AS day
            FROM
                `mst_tourpackages_destination` a
                LEFT JOIN mst_destination_img b ON b.destinationimg_destination_id = a.tourpackagesdest_destination_id AND b.destinationimg_order = 1
            WHERE
                a.`tourpackagesdest_tourpackages_id` = '".$id."'
                AND b.`destinationimg_img` IS NOT NULL
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getTourpackagesDestination($id, $day){
        $path_destination_upload = $this->config->item('path_destination_upload');
        $query = "
            SELECT
                a.tourpackagesdest_destination_id AS destination_id,
                c.destinationtext_name AS destination_name,
                CONCAT('".$path_destination_upload."',b.`destinationimg_img`) AS 'img',
                a.tourpackagesdest_day AS day,
                a.tourpackagesdest_order AS 'order'
            FROM
                `mst_tourpackages_destination` a
                LEFT JOIN mst_destination_img b ON b.destinationimg_destination_id = a.tourpackagesdest_destination_id AND b.destinationimg_order = 1
                LEFT JOIN mst_destination_text c ON c.destinationtext_destination_id = a.tourpackagesdest_destination_id AND c.`destinationtext_lang` = '".$this->user_lang."'
            WHERE
                a.`tourpackagesdest_tourpackages_id` = '".$id."'
                AND a.tourpackagesdest_day = '".$day."'
                AND b.`destinationimg_img` IS NOT NULL
            ORDER BY 
                a.tourpackagesdest_order
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getTimeDayNight(){
        $query = "
            SELECT
                MAX(a.`tourpackages_total_day`) AS 'day',
                MAX(a.`tourpackages_total_night`) AS 'night'
            FROM
                `mst_tourpackages` a
            WHERE
                a.`tourpackages_status` = 1
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDestinationAll(){
        $query = "
            SELECT
                a.`destination_id` AS id,
                b.`destinationtext_name` AS 'name'
            FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
            WHERE 
                a.`destination_status` = 1
            ORDER BY 
                b.`destinationtext_name`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getDestinationLocation(){
        $query = "
            SELECT
                a.`desloc_id` AS `id`,
                a.`desloc_name` AS `name`
            FROM
                `ref_destination_location` a
            WHERE
            a.`desloc_id` IN (SELECT des.`destination_desloc_id` FROM `mst_destination` des WHERE des.`destination_status` = 1)
            ORDER BY
                a.`desloc_order` ASC
        ";
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getDestinationLocationHome(){
        $query = "
            SELECT
                a.`desloc_id` AS `id`,
                a.`desloc_name` AS `name`
            FROM
                `ref_destination_location` a
            WHERE
                a.`desloc_is_show_home` = 1
                AND a.`desloc_id` IN (SELECT des.`destination_desloc_id` FROM `mst_destination` des WHERE des.`destination_status` = 1)
            ORDER BY
                a.`desloc_order` ASC
        ";
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getTotalDestinationById($id){
        $query = "
            SELECT
                a.`destination_id` AS id
            FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_destination_img` c ON c.`destinationimg_destination_id` = a.`destination_id` AND c.`destinationimg_order` = 1
            WHERE 
                a.`destination_status` = 1
                AND a.`destination_desloc_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->num_rows();
    }

    public function getDestinationDetail($id){
        $path_destination_upload = $this->config->item('path_destination_upload');
        $query = "
            SELECT
                a.`destination_id` AS id,
                a.`destination_desloc_id` AS desloc_id,
                b.`destinationtext_name` AS 'name',
                b.`destinationtext_text` AS 'text'
            FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
            WHERE 
                a.`destination_status` = 1
                AND  a.`destination_id` = '".$id."'
            ORDER BY 
                b.`destinationtext_name` DESC
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getDestinationDetailImage($id){
        $path_destination_upload = $this->config->item('path_destination_upload');
        $query = "
            SELECT
                CONCAT('".$path_destination_upload."',a.`destinationimg_img`) AS 'img'
            FROM
                `mst_destination_img` a
            WHERE
                a.`destinationimg_destination_id` = '".$id."'
                AND a.`destinationimg_img` IS NOT NULL
            ORDER BY 
                a.`destinationimg_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getDestinationTourpackages($id){
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $query = "
            SELECT
                a.`tourpackages_id` AS id,
                a.`tourpackages_base_price_local` AS `base_price_local`,
                b.`tourpackagestext_name` AS 'name',
                CONCAT('".$path_tourpackages_upload."',c.`tourpackagesimg_img`) AS 'img'
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_destination` d ON d.tourpackagesdest_tourpackages_id = a.tourpackages_id
            WHERE 
                a.`tourpackages_status` = 1
                AND d.`tourpackagesdest_destination_id` = '".$id."'
            ORDER BY 
                (SELECT COUNT(trx.`transactiontourpackages_transaction_id`) FROM `trx_transaction_tourpackages` trx WHERE trx.transactiontourpackages_tourpackages_id = a.`tourpackages_id`) DESC
            LIMIT 5
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getAllDestinationLocation(){
        $query = "
            SELECT
                a.`desloc_id` AS `id`,
                a.`desloc_name` AS `name`
            FROM
                `ref_destination_location` a
            WHERE
                a.`desloc_id` IN (SELECT des.`destination_desloc_id` FROM `mst_destination` des WHERE des.`destination_status` = 1)
            ORDER BY
                a.`desloc_order` ASC
        ";
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getDestinationLocationById($id){
        $query = "
            SELECT
                a.`desloc_id` AS `id`,
                a.`desloc_name` AS `name`
            FROM
                `ref_destination_location` a
            WHERE
                a.`desloc_id` = '".$id."'
        ";
        
        $result = $this->db->query($query);
        return $result->row();
    }

    public function getDestinationPaging($page, $limit){
        $path_destination_upload = $this->config->item('path_destination_upload');
        $query = "
            SELECT
                a.`destination_id` AS id,
                a.`destination_desloc_id` AS desloc_id,
                b.`destinationtext_name` AS 'name',
                CONCAT('".$path_destination_upload."',c.`destinationimg_img`) AS 'img'
            FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_destination_img` c ON c.`destinationimg_destination_id` = a.`destination_id` AND c.`destinationimg_order` = 1
            WHERE 
                a.`destination_status` = 1
            ORDER BY 
                b.`destinationtext_name` DESC
            LIMIT $page, $limit
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getDestinationPagingById($id, $page, $limit){
        $path_destination_upload = $this->config->item('path_destination_upload');
        $query = "
            SELECT
                a.`destination_id` AS id,
                a.`destination_desloc_id` AS desloc_id,
                b.`destinationtext_name` AS 'name',
                CONCAT('".$path_destination_upload."',c.`destinationimg_img`) AS 'img'
            FROM 
                `mst_destination` a
                LEFT JOIN `mst_destination_text` b ON b.`destinationtext_destination_id` = a.`destination_id` AND b.`destinationtext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_destination_img` c ON c.`destinationimg_destination_id` = a.`destination_id` AND c.`destinationimg_order` = 1
            WHERE 
                a.`destination_status` = 1
                AND a.`destination_desloc_id` = '".$id."'
            ORDER BY 
                b.`destinationtext_name` DESC
            LIMIT $page, $limit
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getService(){
        $path_service_upload = $this->config->item('path_service_upload');
        $query = "
            SELECT
                a.`service_id` AS `id`,
                a.`service_order` AS 'order',
                a.`service_status` AS 'status',
                a.`service_type` AS 'type',
                CONCAT('".$path_service_upload."',c.`serviceimg_img`) AS img,
                b.`servicetext_name` AS 'name',
                b.`servicetext_text` AS 'text'
            FROM
                `cms_service` a 
            LEFT JOIN `cms_service_text` b ON b.`servicetext_service_id` = a.`service_id` AND b.`servicetext_lang` = '".$this->user_lang."'
            LEFT JOIN `cms_service_img` c ON c.`serviceimg_service_id` = a.`service_id` AND c.`serviceimg_order` = 1
            WHERE
                a.`service_status`= 1
            ORDER BY `service_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getServiceDetail($id){
        $path_service_upload = $this->config->item('path_service_upload');
        $query = "
            SELECT
                a.`service_id` AS `id`,
                a.`service_order` AS 'order',
                a.`service_status` AS 'status',
                a.`service_type` AS 'type',
                b.`servicetext_name` AS 'name',
                b.`servicetext_text` AS 'text'
            FROM
                `cms_service` a 
            LEFT JOIN `cms_service_text` b ON b.`servicetext_service_id` = a.`service_id` AND b.`servicetext_lang` = '".$this->user_lang."'
            WHERE
                a.`service_status`= 1
                AND a.`service_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getServiceDetailImage($id){
        $path_service_upload = $this->config->item('path_service_upload');
        $query = "
            SELECT
                CONCAT('".$path_service_upload."',a.`serviceimg_img`) AS img
            FROM
                `cms_service_img` a
            WHERE
                a.`serviceimg_service_id` = '".$id."'
                AND a.`serviceimg_img` IS NOT NULL
            ORDER BY 
                a.`serviceimg_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getServiceDetailBanner($key){
        $path_service_upload = $this->config->item('path_service_upload');
        $query = "
            SELECT
                a.`service_id` AS `id`,
                a.`service_order` AS 'order',
                a.`service_status` AS 'status',
                a.`service_type` AS 'type',
                b.`servicetext_name` AS 'name',
                b.`servicetext_text` AS 'text'
            FROM
                `cms_service` a 
            LEFT JOIN `cms_service_text` b ON b.`servicetext_service_id` = a.`service_id` AND b.`servicetext_lang` = '".$this->user_lang."'
            WHERE
                a.`service_status`= 1
                AND a.`service_type` = '".$key."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getServiceDetailImageBanner($key){
        $path_service_upload = $this->config->item('path_service_upload');
        $query = "
            SELECT
                CONCAT('".$path_service_upload."',a.`serviceimg_img`) AS img
            FROM
                `cms_service_img` a
                LEFT JOIN cms_service b ON b.service_id = a.`serviceimg_service_id`
            WHERE
                b.`service_type` = '".$key."'
                AND a.`serviceimg_img` IS NOT NULL
            ORDER BY 
                a.`serviceimg_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getTicket(){
        $query = "
            SELECT
                a.`ticket_id`  AS `id`,
                a.`ticket_status`AS 'status',
                b.`tickettext_name` AS 'name'
            FROM
                `mst_ticket` a 
            LEFT JOIN `mst_ticket_text` b ON b.`tickettext_ticket_id` = a.`ticket_id` AND b.`tickettext_lang` = '".$this->user_lang."'
            WHERE
                a.`ticket_status`= 1
            ORDER BY `ticket_id`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getContact(){
        $path_contact_upload = $this->config->item('path_contact_upload');
        $query = "
            SELECT 
                `contact_id` AS id,
                `contact_address` AS address,
                `contact_email` AS email,
                `contact_phone` AS phone,
                `contact_wa` As wa,
                `contact_fb` AS fb,
                `contact_ig` AS ig,
                `contact_twitter` AS twitter,
                CONCAT('".$path_contact_upload."', `contact_img_maps`) AS img_maps,
                `contact_link_maps` AS link_maps
            FROM
            `cms_contact` 
        ";
        $result = $this->default->query($query);
        return $result->row();
    }
    
    public function getGreeting(){
        $path_greeting_upload = $this->config->item('path_greeting_upload');
        $query = "
            SELECT
                a.`greeting_id`  AS `id`,
                CONCAT('".$path_greeting_upload."', a.`greeting_img`) AS img,
                a.`greeting_link_img`  AS `link_img`,
                b.`greetingtext_text` AS 'text'
            FROM
                `cms_greeting` a 
            LEFT JOIN `cms_greeting_text` b ON b.`greetingtext_greeting_id` = a.`greeting_id` AND b.`greetingtext_lang` = '".$this->user_lang."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getTravelPost(){
        $path_travelpost_upload = $this->config->item('path_travelpost_upload');
        $query = "
            SELECT
                a.`travelpost_id` AS `id`,
                a.`travelpost_status` AS 'status',
                CONCAT('".$path_travelpost_upload."',c.`travelpostimg_img`) AS img,
                b.`travelposttext_name` AS 'name',
                b.`travelposttext_text` AS 'text',
                d.`user_real_name` AS creator,
                IFNULL(a.`update_datetime`, a.`insert_datetime`) AS date
            FROM
                `cms_travelpost` a 
            LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
            LEFT JOIN `cms_travelpost_img` c ON c.`travelpostimg_travelpost_id` = a.`travelpost_id` AND c.`travelpostimg_order` = 1
            LEFT JOIN core_user d ON d.user_id = IFNULL(a.`update_user_id`, a.`insert_user_id`)
            WHERE
                a.`travelpost_status`= 1
            ORDER BY `travelpost_id` DESC
            LIMIT 3
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getTotalTravelPostList(){
        $path_travelpost_upload = $this->config->item('path_travelpost_upload');
        $query = "
            SELECT
                a.`travelpost_id` AS `id`
            FROM
                `cms_travelpost` a 
            LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
            LEFT JOIN `cms_travelpost_img` c ON c.`travelpostimg_travelpost_id` = a.`travelpost_id` AND c.`travelpostimg_order` = 1
            LEFT JOIN core_user d ON d.user_id = IFNULL(a.`update_user_id`, a.`insert_user_id`)
            WHERE
                a.`travelpost_status`= 1
        ";
        $result = $this->default->query($query);
        return $result->num_rows();
    }

    public function getTravelPostList($page, $limit){
        $path_travelpost_upload = $this->config->item('path_travelpost_upload');
        $query = "
            SELECT
                a.`travelpost_id` AS `id`,
                a.`travelpost_status` AS 'status',
                CONCAT('".$path_travelpost_upload."',c.`travelpostimg_img`) AS img,
                b.`travelposttext_name` AS 'name',
                b.`travelposttext_text` AS 'text',
                d.`user_real_name` AS creator,
                IFNULL(a.`update_datetime`, a.`insert_datetime`) AS date
            FROM
                `cms_travelpost` a 
            LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
            LEFT JOIN `cms_travelpost_img` c ON c.`travelpostimg_travelpost_id` = a.`travelpost_id` AND c.`travelpostimg_order` = 1
            LEFT JOIN core_user d ON d.user_id = IFNULL(a.`update_user_id`, a.`insert_user_id`)
            WHERE
                a.`travelpost_status`= 1
            ORDER BY `travelpost_id` DESC
            LIMIT ".$page." , ".$limit."
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getTravelPostDetail($id){
        $query = "
            SELECT
                a.`travelpost_id` AS `id`,
                a.`travelpost_status` AS 'status',
                b.`travelposttext_name` AS 'name',
                b.`travelposttext_text` AS 'text',
                d.`user_real_name` AS creator,
                IFNULL(a.`update_datetime`, a.`insert_datetime`) AS date
            FROM
                `cms_travelpost` a 
            LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
            LEFT JOIN core_user d ON d.user_id = IFNULL(a.`update_user_id`, a.`insert_user_id`)
            WHERE
                a.`travelpost_status`= 1
                AND a.`travelpost_id` = '".$id."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getTravelPostDetailImage($id){
        $path_travelpost_upload = $this->config->item('path_travelpost_upload');
        $query = "
            SELECT
                CONCAT('".$path_travelpost_upload."',a.`travelpostimg_img`) AS img
            FROM
                `cms_travelpost_img` a
            WHERE
                a.`travelpostimg_travelpost_id` = '".$id."'
                AND a.`travelpostimg_img` IS NOT NULL
            ORDER BY 
                a.`travelpostimg_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getTravelPostLatest($id){
        $path_travelpost_upload = $this->config->item('path_travelpost_upload');
        $query = "
            SELECT
                a.`travelpost_id` AS `id`,
                a.`travelpost_status` AS 'status',
                CONCAT('".$path_travelpost_upload."',c.`travelpostimg_img`) AS img,
                b.`travelposttext_name` AS 'name',
                b.`travelposttext_text` AS 'text',
                d.`user_real_name` AS creator,
                IFNULL(a.`update_datetime`, a.`insert_datetime`) AS date
            FROM
                `cms_travelpost` a 
            LEFT JOIN `cms_travelpost_text` b ON b.`travelposttext_travelpost_id` = a.`travelpost_id` AND b.`travelposttext_lang` = '".$this->user_lang."'
            LEFT JOIN `cms_travelpost_img` c ON c.`travelpostimg_travelpost_id` = a.`travelpost_id` AND c.`travelpostimg_order` = 1
            LEFT JOIN core_user d ON d.user_id = IFNULL(a.`update_user_id`, a.`insert_user_id`)
            WHERE
                a.`travelpost_status`= 1
                AND a.`travelpost_id` NOT IN ('".$id."')
            ORDER BY `travelpost_id` DESC
            LIMIT 5
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function getAboutus(){
        $path_aboutus_upload = $this->config->item('path_aboutus_upload');
        $query = "
            SELECT
                a.`aboutus_id`  AS `id`,
                CONCAT('".$path_aboutus_upload."', a.`aboutus_img`) AS img,
                b.`aboutustext_text` AS 'text'
            FROM
                `cms_aboutus` a 
            LEFT JOIN `cms_aboutus_text` b ON b.`aboutustext_aboutus_id` = a.`aboutus_id` AND b.`aboutustext_lang` = '".$this->user_lang."'
        
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getGallery(){
        $path_gallery_upload = $this->config->item('path_gallery_upload');
        $query = "
            SELECT
                a.`gallery_id` AS `id`,
                a.`gallery_parent_id` AS parent_id,
                a.`gallery_type` AS type,
                CONCAT('".$path_gallery_upload."',a.`gallery_img`) AS img,
                a.`gallery_link` AS link,
                b.`gallerytext_title` AS title
            FROM
                `cms_gallery` a 
            LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
            WHERE
                a.`gallery_status` = 1
                AND a.`gallery_type` = 1
            ORDER BY 
                a.`gallery_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }
    
    public function getGalleryPhoto($parent_id){
        $path_gallery_upload = $this->config->item('path_gallery_upload');
        $query = "
            SELECT
                a.`gallery_id` AS `id`,
                a.`gallery_parent_id` AS parent_id,
                a.`gallery_type` AS type,
                CONCAT('".$path_gallery_upload."',a.`gallery_img`) AS img,
                a.`gallery_link` AS link,
                b.`gallerytext_title` AS title
            FROM
                `cms_gallery` a 
            LEFT JOIN `cms_gallery_text` b ON b.`gallerytext_gallery_id` = a.`gallery_id` AND b.`gallerytext_lang` = '".$this->user_lang."'
            WHERE
                a.`gallery_status` = 1
                AND a.`gallery_type` = 2
                AND a.`gallery_parent_id` = '".$parent_id."'
            ORDER BY 
                a.`gallery_order`
        ";
        $result = $this->default->query($query);
        return $result->result();
    }

    public function Privacypolicy(){
        $query = "
            SELECT
                a.`privacypolicy_id`  AS `id`,
                b.`privacypolicytext_text` AS 'text'
            FROM
                `cms_privacypolicy` a 
            LEFT JOIN `cms_privacypolicy_text` b ON b.`privacypolicytext_privacypolicy_id` = a.`privacypolicy_id` AND b.`privacypolicytext_lang` = '".$this->user_lang."'
        ";
        $result = $this->default->query($query);
        return $result->row();
    }
    
    public function Termandcondition(){
        $query = "
            SELECT
                a.`termcondition_id`  AS `id`,
                b.`termconditiontext_text` AS 'text'
            FROM
                `cms_termcondition` a 
            LEFT JOIN `cms_termcondition_text` b ON b.`termconditiontext_termcondition_id` = a.`termcondition_id` AND b.`termconditiontext_lang` = '".$this->user_lang."'
        ";
        $result = $this->default->query($query);
        return $result->row();
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

    public function getLangDetail(){
        $query = "
            SELECT
                a.`lang_code` AS `code`,
                a.`lang_name` AS `name`,
                a.`lang_icon` AS `icon`
            FROM
                `core_lang` a
            WHERE a.`lang_code` = '".$this->user_lang."'
        ";
        
        $result = $this->db->query($query);
        return $result->row();
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

    public function getUserByUsernameLogin($username){
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
                AND user_is_admin = 0
                AND `user_status` = 1
        ";
        $result = $this->default->query($query);
        return $result->row();
    }

    public function getUserByUserId($user_id){
        $path_user_upload = $this->config->item('path_user_upload');
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
                CONCAT('".$path_user_upload."',`user_photo`) AS photo,
                `user_photo` AS photo_ori
            FROM
                `core_user`
            WHERE
                user_id = '$user_id'
        ";
        $result = $this->default->query($query);
        return $result->row();
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
    
}

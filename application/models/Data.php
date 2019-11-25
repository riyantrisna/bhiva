<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->default = $this->load->database('default', TRUE);
        $this->user_lang = !empty($this->session->userdata('user_lang')) ? $this->session->userdata('user_lang') : 'en';
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
                a.`tourpackages_base_price_local` AS `base_price_local`,
                b.`tourpackagestext_name` AS 'name',
                CONCAT('".$path_tourpackages_upload."',c.`tourpackagesimg_img`) AS 'img'
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
            WHERE 
                a.`tourpackages_status` = 1
            ORDER BY 
                (SELECT COUNT(trx.`transactiontourpackages_transaction_id`) FROM `trx_transaction_tourpackages` trx WHERE trx.transactiontourpackages_tourpackages_id = a.`tourpackages_id`) DESC
            LIMIT 4
        ";
        $result = $this->default->query($query);
        return $result->result();
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
                CONCAT('".$path_tourpackages_upload."',c.`tourpackagesimg_img`) AS 'img'
            FROM 
                `mst_tourpackages` a
                LEFT JOIN `mst_tourpackages_text` b ON b.`tourpackagestext_tourpackages_id` = a.`tourpackages_id` AND b.`tourpackagestext_lang` = '".$this->user_lang."'
                LEFT JOIN `mst_tourpackages_img` c ON c.`tourpackagesimg_tourpackages_id` = a.`tourpackages_id` AND c.`tourpackagesimg_order` = 1
                LEFT JOIN `mst_tourpackages_price` d ON d.tourpackagesprice_tourpackages_id = a.`tourpackages_id` AND CURDATE() BETWEEN d.`tourpackagesprice_start` AND d.`tourpackagesprice_end`
            WHERE 
                a.`tourpackages_status` = 1
            ORDER BY 
                (SELECT COUNT(trx.`transactiontourpackages_transaction_id`) FROM `trx_transaction_tourpackages` trx WHERE trx.transactiontourpackages_tourpackages_id = a.`tourpackages_id`) DESC
            LIMIT 15
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

    public function getWhoweare(){
        $path_whoweare_upload = $this->config->item('path_whoweare_upload');
        $query = "
            SELECT
                a.`whoweare_id`  AS `id`,
                CONCAT('".$path_whoweare_upload."', a.`whoweare_img`) AS img,
                b.`whowearetext_text` AS 'text'
            FROM
                `cms_whoweare` a 
            LEFT JOIN `cms_whoweare_text` b ON b.`whowearetext_whoweare_id` = a.`whoweare_id` AND b.`whowearetext_lang` = '".$this->user_lang."'
        
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

    
}

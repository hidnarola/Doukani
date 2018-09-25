<?php

class Dbcommon extends CI_Model {

    function Dbcommon() {
	    // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
    }

	//delete product images	
	public function glob_files($source_folder){		
		$FILES 		= glob($source_folder."/*.*");    				
		$i=0;
		$d	=	explode('/',APPPATH);
		
		foreach($FILES as $key => $file) {  
			$FILE_LIST[$key]['name']    = substr( $file, ( strrpos( $file, "\\" ) +1 ) );  
			$paths	=	'';
			$paths	=	explode("/",$FILE_LIST[$key]['name']);
			
			$file_date 	= 	strtotime(date('Y-m-d', filemtime($file)));			
			$prev_date  = date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));			
			$pre_date	=	strtotime($prev_date);				
			/*$vid		=	$this->db->query('select * from product where video_name is not null and video_name <>"" and video_name="'.$paths[8].'"')->num_rows();	*/
			//echo '<br>';
			$res		=	$this->db->query('select * from product where product_image is not null and product_image<>"" and product_image="'.$paths[8].'"')->num_rows();			
			$res1		=	$this->db->query('select * from products_images where product_image="'.$paths[8].'"')->num_rows();
			//echo $pre_date.'<'.$file_date.'=>'.$paths[8].'=>'.$i.'<br>';			
			//$i++;
			//if($file_date < $pre_date && $res==0 && $res1==0 && $vid==0) 
			if($file_date < $pre_date && $res==0 && $res1==0) 
			{							
				$d	=	explode('/',APPPATH);
				$path1	=	'';				
				$path1	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/product/original/'.$paths[8];				
				@unlink($path1);
				$path2	=	'';
				$path2	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/product/medium/'.$paths[8];
				@unlink($path2);
				$path3	=	'';
				$path3	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/product/small/'.$paths[8];
				@unlink($path3);								
			} 
		}			
	}
	
	//delete unused videos
	public function deletevideo_files($source_folder){		
		$FILES 		= glob($source_folder."/*.*");    				
		$i=0;
		$d	=	explode('/',APPPATH);
		
		foreach($FILES as $key => $file) { 
			
			$FILE_LIST[$key]['name']    = substr( $file, ( strrpos( $file, "\\" ) +1 ) );  
			$paths	=	'';
			$paths	=	explode("/",$FILE_LIST[$key]['name']);
			
			$file_date 	= 	strtotime(date('Y-m-d', filemtime($file)));			
			$prev_date  =   date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));			
			$pre_date	=	strtotime($prev_date);				
			$vid		=	$this->db->query('select * from product where video_name is not null and video_name <>"" and video_name="'.$paths[8].'"')->num_rows();						
				
			if($file_date < $pre_date && $vid==0) {					
				$d		=	explode('/',APPPATH);
				$path1	=	'';				
				$path1	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/product/video/'.$paths[8];
				@unlink($path1);			
			} 
		}		
	}
	
	//delete unused User images
	public function deleteuserimg_files($source_folder){		
		
		$FILES 		= glob($source_folder."/*.*");    				
		$i=0;
		$d	=	explode('/',APPPATH);
		
		foreach($FILES as $key => $file) { 			
			$FILE_LIST[$key]['name']    = substr( $file, ( strrpos( $file, "\\" ) +1 ) );  
			$paths	=	'';
			$paths	=	explode("/",$FILE_LIST[$key]['name']);
			
			$file_date 	= 	strtotime(date('Y-m-d', filemtime($file)));			
			$prev_date  =   date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));			
			$pre_date	=	strtotime($prev_date);										
				
			if($file_date < $pre_date) {					
				$d		=	explode('/',APPPATH);
				$path1	=	'';				
				$path1	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/profile/thumb/'.$paths[8];
				@unlink($path1);			
			} 			
		}		
	}
	
	//delete unused video thumbnails
	public function deletevideoimag_files($source_folder){		
		$FILES 		= glob($source_folder."/*.*");    				
		$i=0;
		$d	=	explode('/',APPPATH);
		
		foreach($FILES as $key => $file) { 
			
			$FILE_LIST[$key]['name']    = substr( $file, ( strrpos( $file, "\\" ) +1 ));  
			$paths	=	'';
			$paths	=	explode("/",$FILE_LIST[$key]['name']);
			
			$file_date 	= 	strtotime(date('Y-m-d', filemtime($file)));			
			$prev_date  =   date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));			
			$pre_date	=	strtotime($prev_date);				
			$vid		=	$this->db->query('select * from product where video_image_name is not null and video_image_name <>"" and video_image_name="'.$paths[8].'"')->num_rows();						
				
			if($file_date < $pre_date && $vid==0) {	
		
				$d		=	explode('/',APPPATH);
				$path1	=	'';				
				$path1	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/product/video_image/'.$paths[8];				
				@unlink($path1);			
			} 
		}		
	}
	
    function insert($table_name, $data) {
        if ($this->db->insert($table_name, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function select($table) {
        $sql = "select * from $table ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function select_orderby($table, $field, $order) {
        $this->db->select('*');
        $this->db->order_by($field, $order);
        $query = $this->db->get($table);
        $data = $query->result_array();
        return $data;
    }
    
    function getuserlist($table,$query,$offset = '0', $limit = '1') {
        $sql = "select * from $table where $query LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function select_store_product($id,$offset, $limit) {
        $sql = "SELECT s.store_name,c.catagory_name,p.store_product_price,p.store_product_name,p.store_product_in_stock,p.store_product_description,p.store_product_id,p.store_product_status FROM `store_product` as p,category as c , store as s where ".$id."and s.store_id=p.store_id and c.category_id=p.store_product_category_id limit ".$offset.' , '.$limit;
        $query = $this->db->query($sql);		
        return $query->result_array();
    }

    function filter($table_name, $query) {
        $sql = "select * from $table_name where $query";
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
    
	function get_images($prod_id)
	{
		$img_arr	=	array();
		$sel_img1	=	$this->db->query('select product_image from product where product_id='.(int)$prod_id.' limit 1')->row_array();
		$img_arr[0]	=	$sel_img1['product_image'];
		
		//print_r($img_arr[0]);
		$sel_img_other	=	$this->db->query('select product_image from products_images where product_id='.(int)$prod_id.' ');
		$res			=	$sel_img_other->result_array();
		$cnt			=	1;
		
		if($sel_img_other->num_rows()>0){
			foreach($res as $data) {
				$img_arr[$cnt]	=	$data['product_image'];
				$cnt++;
			}
		}
		return $img_arr;
		
	}
	
	function get_images_count($prod_id)
	{
		$cnt		=	0;		
		$sel_img1	=	$this->db->query('select product_image from product where product_id='.(int)$prod_id.' and product_image !="" limit 1')->num_rows();
		
		if($sel_img1>0)
			$cnt	=	1;		

		$sel_img_other	=	$this->db->query('select product_image from products_images where product_id='.(int)$prod_id.' ');
		$res			=	$sel_img_other->num_rows();		
		
		if($res>0)
			$cnt +=$res;
			
		return $cnt;
	}
	
	
    function get_distinct($query) {
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function insert_batch($table_name, $array) {
        $this->db->insert_batch($table_name, $array);
    }

    function update($table_name, $array, $data) {

        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
        if ($this->db->update($table_name, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function delete($table_name, $array) {
        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->delete($table_name);
        return true;
    }

    function checkpermission($table = '', $other_table = '', $id = '', $value = '0') {
        $sql = "select count(*) as cnt from $table where";
        foreach ($other_table as $tablename) {
            $sql.=" 0<(select count(*) as c from $tablename where $id='" . $value . "') or";
        }
        $sql = trim($sql, ' or');
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->cnt;
    }
    
    function readpermission($table_name,$query) {
        $sql = "select permission from $table_name " . $query ;
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    function getdetails($table_name, $query, $offset = '0', $limit = '1') {
        $sql = "select * from $table_name " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getrowdetails($table_name, $query, $offset = '0', $limit = '1') {
        $sql = "select * from $table_name " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function getdetails_($query, $offset = '0', $limit = '1') {
        $sql = "select " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getnumofdetails($table_name, $where) {
        $sql = "select count(*) as cnt from $table_name " . $where;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->cnt;
    }

    function getnumofdetails_($query) {
        $sql = "select " . $query . "";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	//without select
	function getnumofdetails_select($query) {
        $sql =  $query . "";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	
    function getdetailsinfo($table_name, $array) {
        $sql = "select * from $table_name where ";

        foreach ($array as $key => $value) {
            $sql.=" $key=$value and";
        }
        $sql = trim($sql, ' and');
        $query = $this->db->query($sql);
        return $query->row();
    }
	
	

    function getInfo($field_name = '', $table_name, $array = '', $return = "", $limit = '', $orderby = '') {
        if ($field_name == '') {
            $sql = 'select * ';
        } else {
            $str = '';
            foreach ($field_name as $row) {
                $str.=$row . ',';
            }
            $str = rtrim($str, ',');
            $sql = "select " . $str;
        }
        $sql.= ' from ' . $table_name . ' where 2>0 ';
        if ($array != '') {
            foreach ($array as $key => $value) {
                $sql.="and $key='$value' and";
            }
            $sql = trim($sql, ' and');
        }
        if ($orderby != '') {
            $sql.=" order by $orderby";
        }
        if ($limit != '') {
            $sql.=" limit $limit";
        }
        $query = $this->db->query($sql);
        if ($return == '') {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    function getInfo_($field_name, $table_name) {
        $sql = "select distinct $field_name from $table_name order by $field_name";
        $query = $this->db->query($sql);
        return $this->dbutil->csv_from_result($query);
    }

    function getcsvResult($query) {
        $query_ = $this->db->query($query);
        return $this->dbutil->csv_from_result($query_);
    }

    function getAllInfo_($query, $return = '') {
        $query = $this->db->query($query);
        if ($return == '') {
            return $query->row();
        } else {
            return $query->result();
        }
    }
    
    //sneha
     function get_countAll($tblname){
        return $this->db->count_all($tblname);
    }
    
    function get_products(){
       
        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_posted_by,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_likes,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,
        (
        CASE 
            WHEN product.product_is_sold=1 THEN "SOLD"
            WHEN DATE_FORMAT(featureads.dateFeatured,"%Y-%m-%d")<=CURDATE() && DATE_FORMAT(featureads.dateExpire,"%Y-%m-%d")>=CURDATE() THEN "Featured"
            ELSE ""
        END) AS mytag,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold
        ,user.facebook_id,user.twitter_id,user.google_id',FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id','left');
        $this->db->join('user', 'user.user_id = product.product_posted_by','left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id','left');
        $this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
		//$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');        
        $this->db->where('product.is_delete' ,0);
        $this->db->order_by("product.admin_modified_at", "desc");
		$this->db->group_by("product.product_id");
        $this->db->limit(12);
         
        $query=$this->db->get();
		
        $data = $query->result_array();
		//echo $this->db->last_query();
        return $data;
    }

    function get_products_by_city($id,$start){
       
        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_posted_by,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id,product.product_is_sold');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete' ,0);
		
        if($id != null){
            $this->db->where('product.state_id' ,$id);
        }
        $this->db->group_by("product.product_id");
        $this->db->order_by("product.admin_modified_at",'desc');
		$this->db->limit(12, $start);
        $query=$this->db->get();

        $data = $query->result_array();
        return $data;
    }
	
	function get_products_by_city_cnt($id){
       
        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_posted_by,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id,product.product_is_sold');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete' ,0);
		
        if($id != null){
            $this->db->where('product.state_id' ,$id);
        }
        $this->db->group_by("product.product_id");
        $query=$this->db->get();
        $cnt = $query->num_rows();
        return $cnt;
    }
	
    function get_products_count(){
       
        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete' ,0);
		$this->db->group_by("product.product_id");
        $this->db->order_by("product.product_posted_time", "desc");
        
         
        $query=$this->db->get();

        $data = $query->num_rows();
        return $data;

    }
    function get_product($product_id=null){
       
        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture,
        if( product.phone_no IS not NULL
		OR product.phone_no <> "", product.phone_no, user.phone ) AS phone, DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,
         user.facebook_id,user.twitter_id,user.google_id',FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');		

        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.product_id' ,$product_id);        
        $this->db->where('product.is_delete' ,0);
        $this->db->where('product.product_is_inappropriate' ,'Approve');
        $this->db->where('product.product_deactivate is null');
		         
        $query=$this->db->get();
		
        $data = $query->row();
        return $data;

    }
	function get_product_foredit($product_id=null){
       
        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture, user.phone, DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id',FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');		
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.product_id' ,$product_id);        
        $this->db->where('product.is_delete' ,0);
        //$this->db->where('product.product_is_inappropriate' ,'Approve');
        //$this->db->where('product.product_deactivate is null');
		
         
        $query=$this->db->get();

        $data = $query->row();
        return $data;

    }
	
	function get_product_admin($product_id=null){
       
        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture,DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id,if( product.phone_no IS not NULL
		OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no',FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');		
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.product_id' ,$product_id);        
        $this->db->where('product.is_delete' ,0);        
        $this->db->where('product.product_deactivate is null');
		
         
        $query=$this->db->get();

        $data = $query->row();
        return $data;

    }
    function get_most_viewed_products($start){
       
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_likes,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete' ,0);
        $this->db->order_by("product.admin_modified_at", "desc");
		$this->db->group_by("product.product_id");
        $this->db->limit(12, $start);
         
        $query=$this->db->get();
         //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;

    }
	
    function get_product_by_categories($cat=null, $subcat=null, $current_pro_id=null, $limit=null, $start=null,$rand=null){

        $this->db->select('product.product_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_likes,product.product_total_favorite,product.product_posted_by,product.state_id,state.state_name,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($cat!=null){
            $this->db->where('product.category_id =' ,$cat);
        }
        if($subcat!=null){
            $this->db->where('product.sub_category_id =' ,$subcat);
        }
        if($current_pro_id!=null){
            $this->db->where('product.product_id !=' ,$current_pro_id);
        }
       
		if($rand=='rand')			
			$this->db->order_by("RAND()");		
		else		
			$this->db->order_by("product.admin_modified_at", "desc");
		
		$this->db->group_by("product.product_id");
        if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
         
        $query=$this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    /*
     *Get Vehicle Products
     *@NV
     */
    function get_vehicle_products($cat=null, $subcat=null, $current_pro_id=null,$limit=null, $start = null){
        $this->db->select('product.product_id,product.product_description,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_name,product.product_image,product.product_posted_by,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,state.state_name,category.catagory_name,user.username, user.profile_picture, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,product.product_brand,brand.name bname,model.name mname,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,product.product_total_likes');
        $this->db->from('product');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');		
		$this->db->join('brand', 'brand.brand_id=product.product_brand','left');
        $this->db->join('model', 'model.brand_id=brand.brand_id','left');
		
        $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage','left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color','left');
		
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($cat!=null){
            $this->db->where('product.category_id =' ,$cat);
        }
        if($subcat!=null){
            $this->db->where('product.sub_category_id =' ,$subcat);
        }
        if($current_pro_id!=null){
            $this->db->where('product.product_id =' ,$current_pro_id);
        }
        
        $this->db->order_by("product.admin_modified_at", "desc");
        $this->db->group_by("product.product_id");
        
        if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
         
        $query=$this->db->get();
		//echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

	function get_vehicle_products_admin($cat=null, $subcat=null, $current_pro_id=null,$limit=null, $start = null){ 
        $this->db->select('product.product_id,product.product_description,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_name,product.product_image,product.product_posted_by,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,state.state_name,category.catagory_name,user.username, user.profile_picture, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color,product_vehicles_extras.id color_id, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,product.product_brand,user.facebook_id,user.twitter_id,user.google_id,if( product.phone_no IS not NULL OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no,product.*');
		
        $this->db->from('product');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
		//$this->db->where('product.product_is_inappropriate' ,'Approve');
		//$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($cat!=null){
            $this->db->where('product.category_id =' ,$cat);
        }
        if($subcat!=null){
            $this->db->where('product.sub_category_id =' ,$subcat);
        }
        if($current_pro_id!=null){
            $this->db->where('product.product_id =' ,$current_pro_id);
        }
        
        $this->db->order_by("product.product_total_views", "desc");
        $this->db->group_by("product.product_id");
        if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
         
        $query=$this->db->get();
       
        $data = $query->result_array();
        return $data;
    }
	
    function get_real_estate_products($cat=null, $subcat=null, $current_pro_id=null,$limit=null, $start = null){
        $this->db->select('product.product_id,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_posted_by,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_description,state.state_name,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.twitter_id,user.facebook_id,user.google_id,product.product_total_likes');
        $this->db->from('product');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id','left');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($cat!=null){
            $this->db->where('product.category_id =' ,$cat);
        }
        if($subcat!=null){
            $this->db->where('product.sub_category_id =' ,$subcat);
        }
        if($current_pro_id!=null){
            $this->db->where('product.product_id =' ,$current_pro_id);
        }
            
        $this->db->order_by("product.admin_modified_at", "desc");
		$this->db->group_by("product.product_id");
        if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
         
        $query=$this->db->get();
        // echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }   
	//to display at admin site
	function get_real_estate_products_admin($cat=null, $subcat=null, $current_pro_id=null,$limit=null, $start = null){
        $this->db->select('product.product_id,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_posted_by,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_description,state.state_name,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language,user.facebook_id,user.twitter_id,user.google_id,
		if( product.phone_no IS not NULL OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no ,product.*');
        $this->db->from('product');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id','left');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
		//$this->db->where('product.product_is_inappropriate' ,'Approve');
		//$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($cat!=null){
            $this->db->where('product.category_id =' ,$cat);
        }
        if($subcat!=null){
            $this->db->where('product.sub_category_id =' ,$subcat);
        }
        if($current_pro_id!=null){
            $this->db->where('product.product_id =' ,$current_pro_id);
        }
            
        $this->db->order_by("product.product_total_views", "desc");
		$this->db->group_by("product.product_id");
        if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
         
        $query=$this->db->get();
        // echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }	
	
    function get_products_by_cat_num($cat=null, $subcat=null){
       
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($cat!=null){
            $this->db->where('product.category_id' ,$cat);
        }
        if($subcat!=null){
            $this->db->where('product.sub_category_id' ,$subcat);
        }
        
        $query=$this->db->get('product');

        $data = $query->num_rows();
        return $data;

    }

    function get_products_common($where=null, $orderby=null, $limit=null, $start=null){
        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_posted_by,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
        $this->db->where('product.is_delete' ,0);
        if($where != null){
             foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if($orderby != null){
            $this->db->order_by($orderby['field'], $orderby['sort_type']);
        }
        if($limit != null && $start == null){
            $this->db->limit($limit);
        }
        if($limit != null && $start != null){
            $this->db->limit($limit, $start);
        }

        $query=$this->db->get();

        $data = $query->num_rows();
        return $data;
    }

    function get_product_images($product_id){
        $this->db->select('product_image');
        $this->db->from('products_images');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $data = $query->result_array();
        $img_arr = array();
        foreach ($data as $img) {
            $img_arr[] = $img['product_image'];
        }
        return $img_arr;
    }

    function get_my_listing($user_id,$start,$limit){
		
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.category_id,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id','left');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
		
		$this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage','left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color','left');
		
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		if(isset($_REQUEST['val']) && $_REQUEST['val']=='Unapprove')
			$this->db->where('product.product_is_inappropriate' ,'Unapprove');
		elseif(isset($_REQUEST['val']) &&  $_REQUEST['val']=='NeedReview')
			$this->db->where('product.product_is_inappropriate' ,'NeedReview');
		else		
			$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete',0);
        $this->db->where('product.product_posted_by',$user_id);
		$this->db->order_by("product.product_posted_time", "desc");
		
        
		$this->db->group_by("product.product_id");
		
		if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
		
        $query=$this->db->get();
		
        $data = $query->result_array();
        return $data;
    }
	
	function get_my_listing_count($user_id){
		
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.category_id,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id','left');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');		
		$this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage','left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color','left');
		
		if(isset($_REQUEST['val']) && $_REQUEST['val']=='Unapprove')
			$this->db->where('product.product_is_inappropriate' ,'Unapprove');
		elseif(isset($_REQUEST['val']) &&  $_REQUEST['val']=='NeedReview')
			$this->db->where('product.product_is_inappropriate' ,'NeedReview');
		else		
			$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete',0);
        $this->db->where('product.product_posted_by',$user_id);
        $this->db->order_by("product.product_posted_time", "desc");
        $this->db->group_by("product.product_id");
	
        $query=$this->db->get();		
        $data = $query->num_rows();		
		
        return $data;
    }
	
	function get_my_seller_listing($user_id,$start,$limit){
		
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.category_id,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,product.product_total_likes`,product.product_total_likes');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id','left');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');		
		$this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage','left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color','left');		
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete',0);
        $this->db->where('product.product_posted_by',$user_id);
        $this->db->order_by("product.admin_modified_at", "desc");		
        $this->db->group_by("product.product_id");
		if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
        $query=$this->db->get();
		//echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	function seller_listing_count($user_id)
	{	
			$product_count =	$this->db->query("SELECT `product`.`product_id`, `product`.`product_posted_by`, `product`.`product_posted_time`, `product`.`product_name`, `product`.`product_image`, `product`.`product_price`, `product`.`product_status`, `product`.`product_is_inappropriate`, `product`.`product_total_views`, `product`.`product_total_favorite`, `category`.`category_id`, `category`.`catagory_name`, `user`.`username`, `user`.`profile_picture`, `product_realestate_extras`.`Emirates`, `product_realestate_extras`.`PropertyType`, `product_realestate_extras`.`Bathrooms`, `product_realestate_extras`.`Bedrooms`, `product_realestate_extras`.`Area`, `product_realestate_extras`.`Amenities`, `product_realestate_extras`.`neighbourhood`, `product_realestate_extras`.`address`, `product_realestate_extras`.`furnished`, `product_realestate_extras`.`pets`, `product_realestate_extras`.`broker_fee`, `product_realestate_extras`.`free_status`, `product_realestate_extras`.`ad_language`, `product_vehicles_extras`.`model`, `product_vehicles_extras`.`millage`, `product_vehicles_extras`.`color`, `product_vehicles_extras`.`type_of_car`, `product_vehicles_extras`.`year`, `product_vehicles_extras`.`make`, `product_vehicles_extras`.`vehicle_condition`, if(user.nick_name!='', `user`.`nick_name`, user.username) as username1, `user`.`nick_name`, `product`.`product_is_sold`, `mileage`.`name` `mileagekm`, `color`.`name` `colorname`, `user`.`facebook_id`, `user`.`twitter_id`, `user`.`google_id` FROM `product` JOIN `category` ON `category`.`category_id` = `product`.`category_id` JOIN `user` ON `user`.`user_id` = `product`.`product_posted_by` LEFT JOIN `product_realestate_extras` ON `product_realestate_extras`.`product_id` = `product`.`product_id` LEFT JOIN `product_vehicles_extras` ON `product_vehicles_extras`.`product_id` = `product`.`product_id` LEFT JOIN `mileage` ON `mileage`.`mileage_id`=`product_vehicles_extras`.`millage` LEFT JOIN `color` ON `color`.`id`=`product_vehicles_extras`.`color` WHERE `product`.`product_is_inappropriate` = 'Approve' AND `product`.`product_deactivate` is null AND `product`.`is_delete` =0 AND `product`.`product_posted_by` = '".(int)$user_id."' GROUP BY `product`.`product_id`");
			
			return $product_count->num_rows();
	}
	
	function getBanner_array($type,$display,$option,$cat_id,$sub_cat_id){				
		
		$date_wh	=	'CURDATE() between expiry_start_date and expiry_end_date';	
		$dis_sql	=	' display_page in ('.$display.')';
		
		$this->db->select('*');
		$this->db->where('ban_type_name',$type);
		/*$this->db->where('impression_count <= total_impressions');
		$this->db->where('click_count <= total_click_count'); */
		$this->db->where('pause_banner','no');
		$this->db->where('(big_img_file_name IS NOT NULL or big_img_file_name<>"")');		
		$this->db->where($dis_sql);
		//$this->db->where($date_wh);
			
			//for binding options
			if(isset($option) && $option=='cpm') {
				$this->db->where('bidding_option','cpm');			
				$this->db->where('impression_count <= total_impressions');
			}
			elseif(isset($option) && $option=='cpc') {
				$this->db->where('bidding_option','cpc');			
				$this->db->where('click_count <= total_click_count');
			}
			elseif(isset($option) && $option=='duration') {				
				$this->db->where('bidding_option','duration');			
				$date_wh1	=	'CURDATE() between expiry_start_date and expiry_end_date';	
				$this->db->where($date_wh1);
				$this->db->where('bd.count < impression_day');
				$this->db->where('bd.date=CURDATE()');
			}
		$this->db->join('banner_cnt_duration bd','bd.banner_id=custom_banner.ban_id','left');	
		$this->db->where('status',1);
		$this->db->order_by("RAND()");		
		$this->db->limit('1');
		
		$query	=	$this->db->get('custom_banner');		
		
		$mydata	=	$query->result_array();
		
		return $mydata;
	}
	
	function check_duration($banner_id){
		
		$cnt	=	$this->getnumofdetails_(' * from banner_cnt_duration where banner_id='.$banner_id.' and date=CURDATE()'); 
		if($cnt==0)
			return 'insert';
		else
			return 'update';
	}
	//insert/update banner count duration
	function insert_update_banner($in_up_var,$banner_id) {
		if($in_up_var=='insert') {			
			$this->db->query('insert into banner_cnt_duration values (NULL,"'.$banner_id.'",1,"'.date('Y-m-d').'")');			
		}
		else {			
			$impcount	=	$this->db->query('select count from banner_cnt_duration where banner_id='.$banner_id.' and date=CURDATE() limit 1')->row_array();
			$sum	=	(int)$impcount['count']+1;
			$this->db->query('update banner_cnt_duration set count='.$sum.' where  banner_id='.$banner_id.' and date(`date`)="'.date('Y-m-d').'"');			
		}
	}
	
	function get_cat_subcat($banner_id) {
		$q1		=	$this->db->query('select * from category_banner where banner_id='.$banner_id);
		$res	=	$q1->result_array();
		echo '<pre>';
		$cat_sub_arr	=	array();
		foreach($res as $r) {						
			$cat_sub_arr[$r['category_id']]	=	$r['sub_category_id'];			
		}		
		 //print_r($cat_sub_arr);
		// echo '<br>';
		return $cat_sub_arr;
	}
	//for banners 3 type banners: HEader, Sidebar,Between
	function getBanner($type,$display,$cat_id,$sub_cat_id){
		
		$mydata	= $this->getBanner_array($type,$display,'here',$cat_id,$sub_cat_id);
		var_dump($sub_cat_id);
		if(sizeof($mydata)>0) {
			$option	=	$mydata[0]['bidding_option'];			
			
			//for category and subcategory
			if($cat_id!=null)		{	
				//to get category id and sub category for banner				
				$banner_cat	=	$this->get_cat_subcat($mydata[0]['ban_id']);				
				if(array_key_exists($cat_id, $banner_cat) && $cat_id!=0) {					
					if($cat_id>0 && ($sub_cat_id==null || (int)$banner_cat[$cat_id]==0))
						$this->db->where('cb.category_id',$cat_id);				
					
					if((int)$banner_cat[$cat_id]>0 && $sub_cat_id==(int)$banner_cat[$cat_id])
						$this->db->where('cb.sub_category_id',(int)$banner_cat[$cat_id]);				
				}
			}
			
			// $this->db->where("FIND_IN_SET(".$sub_cat_id.",sub_cat_id)!=",'');	
			
			if(isset($option) && $option=='cpm') {
				$this->db->where('bidding_option','cpm');			
				$this->db->where('impression_count < total_impressions');
			}
			elseif(isset($option) && $option=='cpc') {
				$this->db->where('bidding_option','cpc');			
				$this->db->where('click_count < total_click_count');
			}
			elseif(isset($option) && $option=='duration') {				
				$this->db->where('bidding_option','duration');			
				$date_wh1	=	'CURDATE() between expiry_start_date and expiry_end_date';	
				$this->db->where($date_wh1);
				$this->db->where('bd.count < impression_day');
				$this->db->where('bd.date=CURDATE()');
				//check data exist or not
				$check_in_up	=	$this->check_duration($mydata[0]['ban_id']);
				if($check_in_up!='')
					$this->insert_update_banner($check_in_up,$mydata[0]['ban_id']);				
			}
			$dis_sql	=	' display_page in ('.$display.')';
			$this->db->where($dis_sql);
			$this->db->where('ban_type_name',$type);
			$this->db->where('status',1);
			$this->db->join('banner_cnt_duration bd','bd.banner_id=custom_banner.ban_id','left');			
			$this->db->join('category_banner cb','cb.banner_id=custom_banner.ban_id','left');			
			$this->db->order_by("RAND()");		
			$this->db->limit('1');			
			
			$query1	=	$this->db->get('custom_banner');
			$res	=	$query1->result_array();			
			//if not get any banner from above conditions again find
			 if(sizeof($res)==0) {					
				$query1	= $this->getBanner_array($type,$display,$option,$cat_id,$sub_cat_id);	
				$data = $query1;  
			}	
			else
				$data = $query1->result_array();  	
			//echo $this->db->last_query();			
			return $data;
		}
    }

    public function get_row($tablename, $array){
        if(!empty($array)){
            foreach ($array as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get($tablename);
        $data =  $query->row();
        return $data;
    }

    public function get_followers($user_id){
        $this->db->select('*');
        $this->db->from('followed_seller fs');
        $this->db->join('user', 'user.user_id = fs.seller_id','left');
        $this->db->where('fs.seller_id' ,$user_id);
        
        $query=$this->db->get();

        $data = $query->result_array();
        return $data;
    }
	
	public function get_myfollowerslist($user_id,$start,$limit){
        $this->db->select('*');
        $this->db->from('followed_seller fs');
        $this->db->join('user', 'user.user_id = fs.user_id','left');
        $this->db->where('fs.seller_id' ,$user_id);
		
		if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
        
        $query=$this->db->get();

        $data = $query->result_array();
        return $data;
    }
	
	public function get_myfollowers_count($user_id){
        $this->db->select('*');
        $this->db->from('followed_seller fs');
        $this->db->join('user', 'user.user_id = fs.user_id','left');
        $this->db->where('fs.seller_id' ,$user_id);		
		
        $query=$this->db->get();
		
        $data = $query->num_rows();
        return $data;
    }
	
	public function get_myfollowers($seller_id,$user_id){
        $this->db->select('*');
        $this->db->from('followed_seller fs');
        $this->db->join('user', 'user.user_id = fs.seller_id','left');
        //$this->db->where('fs.user_id' ,$seller_id);
        $this->db->where('fs.seller_id' ,$seller_id);        
        $this->db->where('fs.user_id' ,$user_id);        
        
        $query=$this->db->get();
	
        $data = $query->num_rows();
		//echo $this->db->last_query();
        return $data;
    }
    
     function get_specific_colums($tblname,$fields,$where=null,$orderby_field, $order_type){
        $this->db->distinct();
        $this->db->select($fields);
        $this->db->from($tblname);
        if(!empty($where)){
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by($orderby_field, $order_type);
        $query=$this->db->get();
        $data = $query->result_array();
        return $data;
    }

    function join_on_pages(){
        $this->db->select('p1.page_id, p1.parent_page_id, p1.page_title, p2.page_title as `parent_title`');
        $this->db->from('pages_cms p1');
        $this->db->join('pages_cms p2', 'p1.parent_page_id = p2.page_id');
        $query=$this->db->get();

        $data = $query->result_array();
        // echo $this->db->last_query();
        return $data;
    }

    function get_my_favorites($user_id,$start,$limit){
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->join('favourite_product f', 'product.product_id = f.product_id');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete' ,0);
        $this->db->where('f.user_id', $user_id);
        $this->db->where('product.product_total_favorite >', 0);        
        $this->db->order_by("f.user_id", "desc");
		$this->db->order_by("product.product_id", "desc");
		$this->db->group_by("product.product_id");
        
		if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
		
        $query=$this->db->get();		
        $data = $query->result_array();
        return $data;
    }
	
	 function get_my_favorites_count($user_id){
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id');
        
		$this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->join('favourite_product f', 'product.product_id = f.product_id');
        
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete' ,0);
        $this->db->where('f.user_id', $user_id);
        $this->db->where('product.product_total_favorite >', 0);        
		$this->db->group_by("product.product_id");
        
        $query=$this->db->get();
		
        $data = $query->num_rows();
        return $data;
    }
    
    function get_count($tblname, $where){
        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }
        $query = $this->db->get($tblname);
        // echo $this->db->last_query();
        $data = $query->num_rows();
        return $data;
    }

    function getcolorlist()
    {
        $query  =   $this->db->query('select color.* from color 
        left join settings on FIND_IN_SET(color.background_color, settings.val)
        where settings.id=4
        ');
        $data = $query->result_array();
        return $data;
    }

    function get_featured_ads($start,$limit){  
        $this->db->select('featureads.product_id,featureads.User_Id,featureads.dateFeatured,featureads.dateExpire,featureads.cat_id,featureads.subcat_id,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_name,product.product_posted_by,product.product_total_likes,product.product_price, user.*, category.*,product.product_image,product.product_is_sold',FALSE);
        $this->db->from('featureads');
        $this->db->join('category', 'category.category_id = featureads.cat_id','left');        
        $this->db->join('product', 'product.product_id = featureads.product_id','left');
		$this->db->join('user', 'user.user_id = product.product_posted_by','left');
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('DATE_FORMAT(featureads.dateFeatured,"%Y-%m-%d") <= CURDATE()');
        $this->db->where('DATE_FORMAT(featureads.dateExpire,"%Y-%m-%d") >= CURDATE()');
        $this->db->where('product.is_delete' ,0);
        $this->db->where('product.is_featured' ,0);
        //$this->db->order_by("product.admin_modified_at", "desc");
        $this->db->order_by("featureads.id", "desc");
		$this->db->group_by("product.product_id");
		
        if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
		
        $query=$this->db->get();		
		
        $data = $query->result_array();
		
        return $data;
    }
	
	function get_featured_ads_count(){  
        $this->db->select('featureads.product_id,featureads.User_Id,featureads.dateFeatured,featureads.dateExpire,featureads.cat_id,featureads.subcat_id,if(user.nick_name!="",user.nick_name,user.username) as username1, product.*, user.*, category.*');
        $this->db->from('featureads');
        $this->db->join('category', 'category.category_id = featureads.cat_id','left');
		$this->db->join('product', 'product.product_id = featureads.product_id','left');
        $this->db->join('user', 'user.user_id = product.product_posted_by','left');
        
        //$this->db->where('product.product_is_inappropriate !=' ,'Inappropriate');
		$this->db->where('product.product_is_inappropriate' ,'Approve');
		$this->db->where('product.product_deactivate is null');
        $this->db->where('DATE_FORMAT(featureads.dateFeatured,"%Y-%m-%d") <= CURDATE()');
        $this->db->where('DATE_FORMAT(featureads.dateExpire,"%Y-%m-%d") >= CURDATE()');
        $this->db->where('product.is_delete' ,0);
        $this->db->where('product.is_featured' ,0);
        $this->db->order_by("product.admin_modified_at", "desc");
		$this->db->group_by("product.product_id");
		
        $query=$this->db->get();	
        $cnt = $query->num_rows();
		
        return $cnt;
    }
	
    function getbrandlist()
    {
        $query  =   $this->db->query('select brand.* from brand 
        left join settings on FIND_IN_SET(brand.brand_id, settings.val)
        where settings.id=5
        ');
        $data = $query->result_array();
        return $data;
        
    }
    
    function getmileagelist()
    {
        $query  =   $this->db->query('select mileage.* from mileage
        left join settings on FIND_IN_SET(mileage.mileage_id, settings.val)
        where settings.id=6
        ');
        $data = $query->result_array();
        return $data;
        
    }
	function get_my_deactivateads($user_id,$start,$limit){
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->where('product.is_delete' ,0);
        $this->db->where('product.product_deactivate' ,1);
        $this->db->where('user.user_id' ,$user_id);
		$this->db->where('product.product_is_inappropriate','NeedReview');
        $this->db->order_by("product.admin_modified_at", "desc");
		$this->db->group_by("product.product_id");
        
		if($limit!=null){
            if($start!=null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
		
        $query=$this->db->get();

        $data = $query->result_array();
        return $data;
    }
	
	function get_my_deactivateads_count($user_id){
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->where('product.is_delete' ,0);
        $this->db->where('product.product_deactivate' ,1);
        $this->db->where('user.user_id' ,$user_id);
        $this->db->where('product.product_is_inappropriate','NeedReview');
        $this->db->order_by("product.product_posted_time", "desc");
		$this->db->group_by("product.product_id");
        
        $query=$this->db->get();

        $data = $query->num_rows();
        return $data;
    }
	
	function product_vehicles_extras($product_id)
	{
		$this->db->select('product.product_id,brand.name bname,model.name mname,product_vehicles_extras.millage,product_vehicles_extras.color,product_vehicles_extras.type_of_car,product_vehicles_extras.year,product_vehicles_extras.make,product_vehicles_extras.vehicle_condition,mileage.name mileagekm,color.name colorname');
        $this->db->from('product');
        $this->db->join('brand', 'brand.brand_id=product.product_brand');
        $this->db->join('model', 'model.brand_id=brand.brand_id');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id=product.product_id');
		$this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage','left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color','left');
		
        $this->db->where('product.is_delete' ,0);
        $this->db->where('product.product_id' ,$product_id);
		
        $this->db->where('product.product_deactivate is null');        
        $this->db->order_by("product.product_posted_time", "desc");
		$this->db->group_by("product.product_id");
        
        $query=$this->db->get();
		return $query->row();
        
	}
	
	function count_product_cat($sub_cat)
	{
		$this->db->select('count(product_id) as cnt');
        $this->db->from('product');
		$this->db->where('sub_category_id' ,$sub_cat);
		$this->db->where('product_is_inappropriate' ,'Approve');
		$this->db->where('product_deactivate is null');
		$this->db->where('is_delete' ,0);
		$query=$this->db->get();
		$res=	$query->row();
		
		return $res->cnt;
	}
	
	function get_today_product($sub_cat)
	{
		$this->db->select('count(product_id) as cnt');
        $this->db->from('product');
		$this->db->where('sub_category_id' ,$sub_cat);
		$this->db->where('date(admin_modified_at)' ,date('Y-m-d'));
		//$this->db->where('date(admin_modified_at)' ,date('2015-10-26'));
		$query=$this->db->get();
		$res=	$query->row();		
		
		return $res->cnt;
	}
	
	public function pagination($url,$where) {
	
		$config = array();
        $config["base_url"] 	= $url;
        $config["total_rows"] 	= $this->dbcommon->getnumofdetails_($where);						
        $config["per_page"] 	= $this->per_page;		
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] 	= TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] 	= TRUE;
		
		$this->pagination->initialize($config);
		
		return $this->pagination->create_links();	
	}
	
	public function deactivate_ads() {
		
		$cnt	=	$this->db->query('select * from settings where id=1 and `key`="adv_availability" limit 1');
		$res	=	$cnt->row_array();
		if($res['val']>0)
			$val	=	$res['val'];
		else
			$val	=	45;
			
		//deactivate user ads		
		if($val>0)
		{					
			$wh	=	'(p.product_is_sold=0  or p.product_is_sold is null or p.product_is_sold=1)';
			$this->db->select("product_id");			
			$this->db->where('u.is_delete',0);
			$this->db->where('p.is_delete',0);
			$this->db->where('u.user_role','generalUser');
			$this->db->where('CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '.$val.' DAY)');
			$this->db->where('p.product_is_inappropriate','Approve');
			$this->db->where('p.admin_modified_at<>"0000-00-00 00:00:00"');		
			$this->db->where('p.admin_modified_at is not null');						
			$this->db->where($wh);			
			$this->db->where('(p.product_deactivate is null or p.product_deactivate=0)');
			$this->db->join('user u','u.user_id=p.product_posted_by','left');
			$q1	=	$this->db->get('product p'); 
			
			if($q1->num_rows()>0)
			{	
				$this->db->query("update product p,user u set p.product_deactivate=1, p.product_is_inappropriate='NeedReview' 
				where CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '".$val."' DAY) and p.is_delete=0 and u.user_role='generalUser' and  (p.product_is_sold=0 or p.product_is_sold=1 or p.product_is_sold is null) AND p.admin_modified_at<>'0000-00-00 00:00:00' and p.admin_modified_at is not null and p.product_is_inappropriate='Approve' and (p.product_deactivate is null or p.product_deactivate=0)");
			}				
			
			$val	=	$val+90;
			$wh1	=	'(p.product_is_sold=0  or p.product_is_sold is null or p.product_is_sold=1)';
			$this->db->select("product_id");			
			$this->db->where('u.is_delete',0);
			$this->db->where('p.is_delete',0);
			$this->db->where('u.user_role','generalUser');
			$this->db->where('CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '.$val.' DAY)');
			$this->db->where('p.product_is_inappropriate','NeedReview');
			$this->db->where('p.admin_modified_at<>"0000-00-00 00:00:00"');			
			$this->db->where('p.admin_modified_at is not null');			
			$this->db->where($wh1);			
			$this->db->where('p.product_deactivate',1);
			$this->db->join('user u','u.user_id=p.product_posted_by','left');
			$q11	=	$this->db->get('product p'); 
			
			if($q11->num_rows()>0)
			{				
				$this->db->query("update product p,user u set p.is_delete=1 
				where CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '".$val."' DAY) and p.is_delete=0 and u.user_role='generalUser' and  (p.product_is_sold=0 or p.product_is_sold=1 or p.product_is_sold is null) AND p.admin_modified_at<>'0000-00-00 00:00:00' and p.admin_modified_at is not null and p.product_is_inappropriate='NeedReview' and p.product_deactivate=1");							
			}
		}
		
		
		$cnt1	=	$this->db->query('select * from settings where id=2 and `key`="adv_availability_admin" limit 1');
		$res1	=	$cnt1->row_array();
		if($res1['val']>0)
			$val1	=	$res1['val'];
		else
			$val1	=	45;
			
		//deactivate admin ads		
		if($val1>0)
		{	
			$wh	=	'(p.product_is_sold=0 or p.product_is_sold=1 or p.product_is_sold is null)';
			
			$this->db->select('p.product_id');			
			$this->db->join('user u','u.user_id=p.product_posted_by','left');
			$this->db->where('u.is_delete','0');					
			$this->db->where('p.is_delete','0');					
			$this->db->where('u.user_role','admin');					
			$this->db->where('CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '.$val1.' DAY) ');							
			$this->db->where('p.admin_modified_at is not null');			
			$this->db->where('p.admin_modified_at<>"0000-00-00 00:00:00"');					
			$this->db->where('p.product_is_inappropriate','Approve');					
			$this->db->where('(p.product_deactivate is null or p.product_deactivate=0)');
			$this->db->where($wh);					
			$q2	=	$this->db->get('product p'); 			
			
			if($q2->num_rows()>0)
			{			
				$this->db->query("update product p,user u set p.product_deactivate=1, p.product_is_inappropriate='NeedReview' where CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '".$val1."' DAY) and p.is_delete=0 and u.user_role='admin' and  (p.product_is_sold=0 or p.product_is_sold=1 or p.product_is_sold is null) AND p.admin_modified_at<>'0000-00-00 00:00:00' and p.admin_modified_at is  not null  and p.product_is_inappropriate='Approve' and (p.product_deactivate is null or p.product_deactivate=0)");				
			}

			$wh22	=	'(p.product_is_sold=0 or p.product_is_sold=1 or p.product_is_sold is null)';
			$val1	=	$val1 + 90;
			$this->db->select('p.product_id');			
			$this->db->join('user u','u.user_id=p.product_posted_by','left');
			$this->db->where('u.is_delete','0');					
			$this->db->where('p.is_delete','0');					
			$this->db->where('u.user_role','admin');					
			$this->db->where('CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '.$val1.' DAY) ');					
			$this->db->where('p.admin_modified_at is not null');				
			$this->db->where('p.admin_modified_at<>"0000-00-00 00:00:00"');					
			$this->db->where('p.product_is_inappropriate','NeedReview');					
			$this->db->where('p.product_deactivate',1);
			$this->db->where($wh22);					
			$q22	=	$this->db->get('product p'); 			
			
			if($q22->num_rows()>0)
			{							
				$this->db->query("update product p,user u set p.is_delete=1  where CURDATE()>ADDDATE(date(p.admin_modified_at), INTERVAL '".$val1."' DAY) and p.is_delete=0 and u.user_role='admin' and  (p.product_is_sold=0 or p.product_is_sold=1 or p.product_is_sold is null) AND p.admin_modified_at<>'0000-00-00 00:00:00' and p.admin_modified_at is not null and p.product_is_inappropriate='NeedReview' and p.product_deactivate=1");				
			}
		}
	}	
	
	
	public function  users_ds_update() {
			//assign user specific period of month
		if(date('Y-m-d')==date('Y-m-01')) {
		
			$from_date	=	date('Y-m-d');			
		    $to_date    =   date('Y-m-t');
			//date('Y-m-d', strtotime("+1 months", strtotime($from_date)));
		    $query		=	' id=3 limit 1';
    		$ads_cnt	=	$this->filter('settings', $query);
			
			if($ads_cnt[0]['val']>0)
				$cnt_ads	=	$ads_cnt[0]['val'];
			else
				$cnt_ads	=	15;
			
			
			$chk_user	=	$this->db->query('select user_id,from_date,to_date,userAdsLeft,userTotalAds from user where is_delete=0 and status="active" and user_role="generalUser"');
			
			$res_user	=	$chk_user->result_array();
			
			if($chk_user->num_rows()>0)
			{
				foreach($res_user as $r)
				{
					//echo '<pre>';
					//print_r($r);
					$data_user=array('user_id'=>$r['user_id'],
									'from_date'=>$r['from_date'],	
									'to_date'=>$r['to_date'],	
									'total_ads'=>$r['userTotalAds'],
									'ads_left'=>$r['userAdsLeft']
									);	
									//echo '<pre>';
									//print_r($data_user);									
					$this->insert('user_old_data',$data_user);
					$wh_user	=	array('user_role'=>'generalUser',
										  'status'=>'active',
										  'is_delete'=>0,			
										  'to_date'=>$r['to_date'],
										  'status'=>'active',
										  'user_id'=>$r['user_id']
										  );
									//print_r($wh_user);	  
					$up_user	= array('userAdsLeft'=>$cnt_ads,
										'userTotalAds'=>$cnt_ads,
										'from_date'=>$from_date,	
									    'to_date'=>$to_date	
										 );
										 //print_r($up_user);	  
					$this->update('user',$wh_user, $up_user);
				}
			}
		}
			
			
	}
	
	public function get_conversation($product_id,$logged_user) {		
		$this->db->select('*');		
		$this->db->where('bs.product_id',$product_id);		
		$this->db->where('bs.sender_id',$logged_user);		
		$this->db->or_where('bs.receiver_id',$logged_user);				
		
		$this->db->join('user u','u.user_id=bs.sender_id or u.user_id=bs.receiver_id','left');				
		$this->db->group_by('bs.con_id');		
		
		$query	=	$this->db->get('buyer_seller_conversation bs');		
		$data = $query->result_array();	
		//echo $this->db->last_query();
		return $data;
	}
	
	public function get_senders($product_id,$logged_user) {					
		

		$this->db->select('bs.product_id,bs.con_id,bs.message,bs.created_at,bs.sender_id,bs.receiver_id,u.username uname,bs.product_id product_id,
		u.profile_picture upick,u1.profile_picture u1pick,u.facebook_id ufb,u1.facebook_id u1fb,
		u.twitter_id utwi,u1.twitter_id u1twei,u.google_id ugoo,u1.google_id u1goo,		
		u1.username u1name,u.user_id uid,u1.user_id u1id');	
		
		$this->db->join('(SELECT bs1.con_id, max(bs1.sender_id) as latest FROM buyer_seller_conversation bs1 GROUP BY bs1.sender_id) t2','bs.sender_id=t2.latest and bs.con_id = t2.con_id','left');	
		
		$this->db->join('user u','u.user_id=bs.sender_id','left');	
		$this->db->join('user u1','u1.user_id=bs.receiver_id','left');	
		
		//$this->db->where('bs.product_owner',$logged_user);		
		$this->db->where('bs.product_id',$product_id);				
		$this->db->where('(bs.sender_id='.$logged_user.' or bs.receiver_id='.$logged_user.')');				
		$this->db->order_by('bs.con_id','DESC');		
		$this->db->group_by('bs.sender_id');		
		$query	=	$this->db->get('buyer_seller_conversation bs');		
		
		$data = $query->result_array();	
		
		return $data;		
		
		/*$query	=	$this->db->query('SELECT bs.*,u1.user_id u1uid, u1.*,u2.*,u2.user_id u2uid,u2.username u2uname FROM buyer_seller_conversation bs LEFT JOIN user u ON u.user_id=bs.receiver_id 	
		
		WHERE bs.product_id = '.$product_id.' AND ( bs.receiver_id = '.$logged_user.' or bs.sender_id = '.$logged_user.' ) AND 
		
		bs.con_id in (SELECT MAX(con_id) FROM buyer_seller_conversation bs1 GROUP BY bs1.product_owner) 
		
		ORDER BY bs.con_id DESC');		
		$data = $query->result_array();		
		return $data; */
	}	
	
	public function last_up_conv($product_id,$sender_id) {
		$current_user   = $this->session->userdata('gen_user');
		
		$this->db->select('bs.con_id,bs.message,bs.created_at,if(sender_id='.$current_user['user_id'].',"Sent","Replied") as mysent',FALSE);		
		$this->db->where('(bs.sender_id ='.$sender_id.' or bs.receiver_id ='.$sender_id.')');		
		$this->db->where('bs.product_id',$product_id);				
		$this->db->order_by('bs.con_id','DESC');		
		$this->db->limit(1);		
		$query	=	$this->db->get('buyer_seller_conversation bs');				
		$data = $query->row_array();			
		return $data;
	
	}
	//for message code
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function last_up_inquiry($inquiry_id) {
		$current_user   = $this->session->userdata('gen_user');
		$this->db->select('*');				
		$this->db->where('i.inquiry_id',$inquiry_id);				
		$this->db->where(('im.message_sent_to='.$current_user['user_id'].' or message_posted_by='.$current_user['user_id'].''));				
		$this->db->order_by('im.message_id','DESC');		
		$this->db->join('inquiry_message im','im.inquiry_id=i.inquiry_id','left');		
		
		$this->db->limit(1);		
		$query	=	$this->db->get('inquiry i');		
		
		$data = $query->row_array();		
		return $data;
	
	}
	function wp_encode_emoji( $content ) {
    if ( function_exists( 'mb_convert_encoding' ) ) {
        $regex = '/(
             \x23\xE2\x83\xA3               # Digits
             [\x30-\x39]\xE2\x83\xA3
           | \xF0\x9F[\x85-\x88][\xA6-\xBF] # Enclosed characters
           | \xF0\x9F[\x8C-\x97][\x80-\xBF] # Misc
           | \xF0\x9F\x98[\x80-\xBF]        # Smilies
           | \xF0\x9F\x99[\x80-\x8F]
           | \xF0\x9F\x9A[\x80-\xBF]        # Transport and map symbols
        )/x';
 
        $matches = array();
        if ( preg_match_all( $regex, $content, $matches ) ) {
            if ( ! empty( $matches[1] ) ) {
                foreach ( $matches[1] as $emoji ) {
                    /*
                     * UTF-32's hex encoding is the same as HTML's hex encoding.
                     * So, by converting the emoji from UTF-8 to UTF-32, we magically
                     * get the correct hex encoding.
                     */
                    $unpacked = unpack( 'H*', mb_convert_encoding( $emoji, 'UTF-32', 'UTF-8'));
                    if ( isset( $unpacked[1] ) ) {
                        $entity = '&#x' . ltrim( $unpacked[1], '0' ) . ';';
                        $content = str_replace( $emoji, $entity, $content );
                    }
                }
            }
        }
    }
 
    return $content;
}	
	function dateDiff($time1, $time2, $precision = 6) {
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
        $diffs = array();

        foreach ($intervals as $interval) {
            $ttime = strtotime('+1 ' . $interval, $time1);
            $add = 1;
            $looped = 0;
            while ($time2 >= $ttime) {
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
        $data = '';
        foreach ($diffs as $interval => $value) {

            if ($count >= $precision) {
                break;
            }

            if ($value > 0) {
                //echo $interval.'=>'.$value.'<br>';
                if ($value != 1) {
                    //  $interval .= "s";
                }
                if ($interval == 'year')
                    $data = $value . ' yr';
                if ($interval == 'month'){
					if($value>1)
						$data = $value . ' months';
					else
						$data = $value . ' month';
				}
                if ($interval == 'day') {
                    if ($value > 1)
                        $data = $value . ' days';
                    else
                        $data = $value . ' day';
                }
                if ($interval == 'hour') {
                    if ($value > 1)
                        $data = $value . ' hrs';
                    else
                        $data = $value . ' hr';
                }
                if ($interval == 'minute') {
                    if ($value > 1)
                        $data = $value . ' mins';
                    else
                        $data = $value . ' min';
                }
                if ($interval == 'second') {
                    $data = $value . ' sec';
                }
                //echo '<br>';
                //$times[] = $value . " " . $interval;
                $times[] = $data; //$value . " " . $interval;
                //print_r($times);
                //echo '<br>';
                $count++;
            }
        }

        // Return string with times
        //echo 'here'.implode(", ", $times);
        return $times[0];
    }	
	
	function myfavorite($product_id,$user_id) {
	
		$this->db->select('*');
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id',$user_id);
		$query	=	$this->db->get('favourite_product');
		$result	= $query->num_rows();
		if((int)$result >0)
			$res	=	1;
		else
			$res	=	0;
		return $res;		
	}
		
	function mylike($product_id,$user_id) {
	
		$this->db->select('*');
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id',$user_id);
		$query	=	$this->db->get('like_product');
		$result	= $query->num_rows();
		if((int)$result >0)
			$res	=	1;
		else
			$res	=	0;
		return $res;		
	}	
		
		
	function getmainimag($product_id)  {
		$this->db->select('IF(product_image IS NULL OR product_image="",0,1) main_img_count, 
						  IF(youtube_link IS NULL  OR youtube_link="",0,1) youyube_count,
						  IF(video_name IS NULL  OR video_name="",0,1) video_count');
		$this->db->where('product_id',$product_id);		
		$this->db->limit('1');
		$que	=	$this->db->get('product');
		$cnt	=	$que->row_array();		
		//print_r($cnt);
		//echo $this->db->last_query();
		$sum	=	(int)$cnt['main_img_count']+(int)$cnt['youyube_count']+(int)$cnt['video_count'];			
		return $sum;
	}
	
	function get_no_of_images($product_id) {		
		$main_cnt	=	$this->getmainimag($product_id);		
		$this->db->select('product_id');
		$this->db->where('product_id',$product_id);
		$query	=	$this->db->get('products_images');
		$res	=	(int)$query->num_rows()+(int)$main_cnt;
		return $res;
	}
	
	function getsub_category($category_id) {	
		$this->db->select('*');
		$this->db->where('category_id',$category_id);
		$query	=	$this->db->get('sub_category');
		return $query->result_array();
	}
}
?>
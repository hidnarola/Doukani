<?php 
if($first_name!='doukani' && $first_name!='classified_application') 
         {
            //Individual Store
            //echo 'yes';
            $where  = " where store_domain ='" . $first_name . "' and store_status=0 and store_is_inappropriate='Approve'";
            $store  = $this->dbcommon->getdetails('store', $where);
            $data['store']  =   $store;
            //print_r($store);

                if(!empty($store)) {

                    $where  = " where user_id ='" .$store[0]->store_owner . "' and  is_delete=0 and status='active'";
                    $store_user  = $this->dbcommon->getdetails('user', $where);
                    $data['store_user']  =   $store_user;
                     if(empty($store_user))
                        header("Location:".HTTPS.doukani_website);

                    if($store_user[0]->contact_number!='')
                         $data['contact_no']     = $store_user[0]->contact_number;
                    elseif($store_user[0]->phone!='')
                          $data['contact_no']     = $store_user[0]->phone;

                    $data['seller_emailid']       = $store_user[0]->email_id;

                    if($store_user[0]->nick_name!='')
                        $title  =   $store_user[0]->nick_name;
                    elseif($store_user[0]->username!='')
                        $title  =   $store_user[0]->username;
                        
                    $data['seller_name']      = $title;

                    $store_user_regidate =  $this->dbcommon->dateDiff(date('y-m-d H:i:s'),$store_user[0]->user_register_date);
                    $data['store_user_regidate'] =  $store_user_regidate;
                    
                    if($store_user[0]->last_logged_in!='')
                        $last_logged_in =   $store_user[0]->last_logged_in;
                    else
                        $last_logged_in =   $store_user[0]->user_register_date;

                    $store_user_last_logged_in =  $this->dbcommon->dateDiff(date('y-m-d H:i:s'),$last_logged_in);

                    $data['store_user_last_logged_in'] =  $store_user_last_logged_in;
                    
                    $query  = " product_id from product where product_posted_by='".$store[0]->store_owner."' and is_delete=0 and product_deactivate IS NULL and product_is_inappropriate='Approve'";
                    $count_no_of_post  = $this->dbcommon->getnumofdetails_($query);
                    $data['count_no_of_post']  =   $count_no_of_post;                


                    $currentusr   = $this->session->userdata('gen_user');
                    $data['currentusr'] =  $currentusr;
                    $where = " where user_id ='" . $currentusr['user_id'] . "'";
                    $current_user  = $this->dbcommon->getdetails('user', $where);
                    $data['current_user'] =  $current_user;

                    $data['is_following']   = 0;
                    if($this->session->userdata('gen_user')!='') {
                        $logged_in_user         =   $currentusr['username'];
                        $data['is_logged']      =   1;
                        $data['login_username'] =   $logged_in_user;            
                        $data['loggedin_user']  =   $currentusr['user_id'];

                        $count_array            = array('user_id'=> $currentusr['user_id'],
                                                        'seller_id'=>$store_user[0]->user_id);
                                                        
                        $following_count        = $this->dbcommon->get_count('followed_seller', $count_array);
                        $data['is_following']   = $following_count;

                        if($currentusr['nick_name']!='')
                            $sender =   $currentusr['nick_name'];
                        else
                            $sender =   $currentusr['username'];
                        if($currentusr['nick_name']!='')
                            $sender_number      = $store_user[0]->contact_number;
                        else
                            $sender_number      = $store_user[0]->phone;

                    }
                    else {
                        $data['is_logged']      =   0;
                        $data['login_username'] =   null;                    
                        $data['current_user']   =   '';
                        $data['loggedin_user']  =   '';
                    }

                    $share_url = '';
                    if(isset($store[0]->store_image) && $store[0]->store_image!='') {
                         $share_url = base_url() . stores . $store[0]->store_image;
                    }

                    $data['share_url']  =  $share_url;
                    $data['page_title'] =  $store[0]->store_name. ' has '.$count_no_of_post.' ads'; 

                     if(isset($_POST['send_mail']) && isset($_POST['message']) && $_POST['message']!='') {
                  
                    $in_arr =   array(
                                'sender_id'=>$currentusr['user_id'],
                                'receiver_id'=>$store_user[0]->user_id,
                                'message'=>$_POST['message']
                                );
                  
                    $this->dbcommon->insert('send_msg_seller',$in_arr);
                  
                    $parser_data['title']           = $sender. ' is sending massage';                                       
                    $subject                        = $sender. ' is sending massage';                                       
                    $parser_data['sender_name']     = $sender;  
                    $parser_data['email_id']        = $store_user[0]->email_id;
                    $parser_data['mobile_no']       = $sender_number;   
                    $parser_data['message']         = $_POST['message'];
                    
                   
                    $new_data = "<style>
                    /*<![CDATA[*/
                        #outlook a {padding:0;} 
                        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
                        .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
                        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
                        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
                        img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
                        a img {border:none;}
                        .image_fix {display:block;}
                        Bring inline: Yes.
                        p {margin: 1em 0;}
                        h1, h2, h3, h4, h5, h6 {color: black !important;}
                        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
                        h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
                            color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
                        }
                        h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
                            color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
                        }
                        table td {border-collapse: collapse;}
                        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
                        a {color: orange;}
                        a:link { color: orange; }
                        a:visited { color: blue; }
                        a:hover { color: green; }
                            /*]]>*/
                        </style>
                        
                        <table align='center' bgcolor='#f4f7f9' border='0' cellpadding='0' cellspacing='0' id='backgroundTable' style='background: #f4f7f9;' width='100%'>
                        <tr>
                            <td align='center'>
                            <center>
                                <table border='0' cellpadding='50' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
                                <tr>
                                    <td align='center' valign='top'>
                                    <!--<img height='75' src='logo' style='outline:none; text-decoration:none;border:none,display:block;' width='100' />-->
                                    " . $this->config->item('site_name') . " 
                                    </td>
                                </tr>
                                </table>
                            </center>
                            </td>
                        </tr>
                        <tr>
                            <td align='center'>
                            <center>
                                <table border='0' cellpadding='30' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
                                <tr>
                                    <td align='left' style='background: #ffffff; border: 1px solid #dce1e5;' valign='top' width=''>
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                        <tr>
                                            <td valign='top' align='center' colspan='2'>
                                                <h1 class='logo'><a style='text-decoration:none' href='{site_url}'><font color='#ed1b33'>Doukani</font></a></h1>
                                            </td>
                                        </tr>                                   
                                        <tr>
                                            <td></td>
                                        </tr>                   
                                                                                        
                                        <tr style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5;'>
                                            <td valign='top' align='center' colspan='2'>
                                                <h4><strong>Sender Details</strong></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5; padding-left:15px;'>
                                                <p style='margin: 1em 0;'>
                                                    <strong>Name:</strong>
                                                    {sender_name}
                                                </p>
                                                <p style='margin: 1em 0;'>
                                                    <strong>E-mail:</strong>
                                                    <a style='color: #000000 !important;' href='{email_id}'>{email_id}</a>
                                                </p>
                                                <p style='margin: 1em 0;'>
                                                    <strong>Mobile Number:</strong>
                                                    {mobile_no}
                                                </p>
                                            </td>
                                        </tr>   
                                        <tr style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5;'>
                                            <td valign='top' align='center' colspan='2'>
                                                <h4><strong>Message</strong></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5; padding-left:15px;'>
                                                <p style='margin: 1em 0;'>                                                  
                                                    {message}
                                                </p>
                                            </td>
                                        </tr>                                       
                                        <tr>
                                            <td><br></td>
                                        </tr>
                                        <tr>
                                            <td align='center'> <font size='1'> &copy; ".year." <b>doukani.com.</b> All rights reserved.</font></td>
                                        </tr>
                                    </table>
                                    </td>
                                </tr>
                                </table>
                            </center>
                            </td>
                        </tr>
                        </table>";
               
                    
                    $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
                
                    if(send_mail($_POST['seller_email'], $subject, $new_data)) {                        
                        $this->session->set_flashdata('msg1','Your message sent successfully');
                     }                  
                    //redirect('store/store/'.$store[0]->store_domain);
                    header('Location:'.HTTPS.$store[0]->store_domain.'.'.doukani_website);               
                  }  
                  $this->load->view('store/store_details',$data);
                }                  
                else{
                   // echo 'HI';
                     header("Location:".HTTPS.doukani_website);
                }
                    //redirect('home');
                //    header("Location:".HTTPS.doukani_website);
                    //echo 'redirect to home page';
            
         }
         else?>
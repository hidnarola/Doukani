<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Text Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/text_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Word Limiter
 *
 * Limits a string to X number of words.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */

//
function remove_href_attr($str)
{
	   //return preg_replace('@((www|http://)[^ ]+)@', '<a href="\1">\1</a>', $str);
		$pattern = '~(<a href="[^"]*">)([^<]*)(</a>)~';

		return preg_replace($pattern, '$2', $str);
	  
}

if ( ! function_exists('encode_display'))
{
	function encode_display($str,$key='')//for this application i userd start and now not from next application user.by anil suhagiya
	{
			$CI =& get_instance();
		/*
	
		if($key=='')
		{
			$key='sunmicrosolutions';
		}
		return $CI->encryption->encode($str,$key);*/
		return $CI->encryption->encode($str);
		
	}
}
if ( ! function_exists('decode_display'))
{
	function decode_display($str,$key='')//for this application i userd start and now not from next application user.by anil suhagiya
	{
		$CI =& get_instance();
	/*	$CI =& get_instance();
		if($key=='')
		{
			$key='sunmicrosolutions';
		}
		return $CI->encryption->decode($str,$key);*/
		return $CI->encryption->decode($str);
		
	}
}
if ( ! function_exists('text_limiter'))
{
	function text_limiter($str='',$start='0',$end='0')//for this application i userd start and now not from next application user.by anil suhagiya
	{
		if (strlen($str) < $end)
		{
			return $str;
		}
		else
		{
			$str=substr($str,0,$end) ."..";
			return $str;
		}
		
	}
}
if ( ! function_exists('text_limiter_title'))
{
	function text_limiter_title($str='', $start='0',$end='0')
	{
		if (strlen($str) < $end)
		{
			return "";
		}
		else
		{
			//$str=substr($str,$start,$end) ."..";
			return $str;
		}
		
	}
}
if ( ! function_exists('error_display'))
{
	function error_display($str)
	{
		if (form_error($str))
		{
			return "inputError";
		}
		else
		{
			//$str=substr($str,$start,$end) ."..";
			return "";
		}
		
	}
}
if ( ! function_exists('post_display'))
{
	function post_display($str='',$data='')
	{
		if(isset($_POST[$str]))
		{
			return $_POST[$str];
		}
		else
		{
			return htmlspecialchars($data);
		}

	}
}
if ( ! function_exists('choise_display'))
{
	function choise_display($array,$index,$value='')
	{
		if($array=='')
		{
			return '';
		}
		else
		{
			return $array->$index;
		}
	}
}
if ( ! function_exists('iff_display'))
{
	function iff_display($var,$value='')
	{
		if(isset($var))
		{
			return $var;
		}
		else
		{
			return $value;
		}
	}
}
if ( ! function_exists('if_display'))
{
	function if_display($var,$value='')
	{
		if($var=='')
		{
			return $value;
		}
		else
		{
			return $var;
		}
	}
}

if ( ! function_exists('display_limiter'))
{
	function display_limiter($str='',$end='0')
	{
		if (strlen($str) < $end)
		{
			//return $str;
			return '<span title="">'.htmlspecialchars($str).'</span>';
		}
		else
		{
			$str_sort=substr($str,0,$end) ."..";
			return '<span title='.htmlspecialchars($str).'>'.htmlspecialchars($str_sort).'</span>';
		}
		
	}
}
if ( ! function_exists('select_radio'))
{
	function select_radio($name,$value,$default="")
	{
		if(isset($_POST[$name]) && $_POST[$name]==$value)
		{
			return 'checked="checked"';
		}
		else if(!isset($_POST[$name]) && $default!='')
		{
			return 'checked="checked"';
		}
		else
		{
			return '';
		}
	}
}
if ( ! function_exists('select_radio_edit'))
{
	function select_radio_edit($value,$set_value)
	{
		if($value==$set_value)
		{
			return 'checked="checked"';
		}
		else
		{
			return '';
		}
	}
}

if ( ! function_exists('display_label'))
{
	function display_label($array,$class)
	{?>
		<script src="js/jquery.inline-labels.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
		$('label.inline').inlineLabel();
				$(function() {
			});
		</script>
		<?php
		foreach($array as $key=>$value)
		{
			?>
            <label for="<?php echo $key ?>" class="<?php echo $class ?>"><?php echo $value ?></label>
            <?php
		}
	}
}
if ( ! function_exists('select_display'))
{
	function select_display($array,$value='',$label='',$set_value='',$single='')//if want to print key(as value),value(as label) than -> select_display($array,''); 
	{
		$str='';
		if($label=='')
		{
			$label=$value;
		}
		if($value!='')
		{
			foreach($array as $row)
			{
				if($row->$value==$set_value)
				{
					$str.="<option value='".$row->$value."' selected='selected'>".$row->$label."</option>";
				}
				else
				{
					$str.="<option value='".$row->$value."'>".$row->$label."</option>";
				}
			}
		}
		else
		{
			if($single!='')
			{
				foreach($array as $key)
				{
					if($key==$set_value)
					{
						$str.="<option value=\"$key\" selected='selected'>$key</option>";
					}
					else
					{
						$str.="<option value=\"$key\">$key</option>";
					}
				}
				
			}
			else
			{
				foreach($array as $key=>$value)
				{
					if($key==$set_value)
					{
						$str.="<option value='".$key."' selected='selected'>".$value."</option>";
					}
					else
					{
						$str.="<option value='".$key."'>".$value."</option>";
					}
				}
				
			}
		}
		return $str;
	}
}
if ( ! function_exists('get_strting'))
{
	function get_strting($array,$index,$seprator)//array,index name of array,separator that we are used
	{
		$str='';
		foreach($array as $row)
		{
			$str.=$seprator .$row->$index;
		}
		$str=trim($str,$seprator);
		return $str;
	}
}
if ( ! function_exists('get_daydiff'))
{
	function get_daydiff($end_date,$today)//Lastdate and current date default otherwise passed date ex... get_daydiff('2012-09-22','2012-09-19');
	{
		if($today=='')
		{
			$today=date('Y-m-d');
		}
		$str = floor(strtotime($end_date)/(60*60*24)) - floor(strtotime($today)/(60*60*24));
		return $str;
	}
}
if ( ! function_exists('date_view'))
{
	function date_view($date,$format='')//Lastdate and current date default otherwise passed date ex ... add_date('2012-07-20','+','20','d');
	{
		return date('d-m-Y',strtotime($date));
	}
}

if ( ! function_exists('date_timeview'))
{
	function date_timeview($date,$format='')//Lastdate and current date default otherwise passed date ex ... add_date('2012-07-20','+','20','d');
	{
		return date('d-M-Y h:i:s',strtotime($date));
	}
}
if ( ! function_exists('add_date'))
{
	function add_date($startdate,$do,$add,$what)//Lastdate and current date default otherwise passed date ex ... add_date('2012-07-20','+','20','d');
	{
		if(($what=='m' || $what=='d') &&($do=='+' ||$do=='-'))
		{
			if($what=='m')
			{
				$what='months';
			}
			else
			{
				$what='days';
			}
			$str=date('Y-m-d',strtotime("$do$add $what",strtotime($startdate)));	
			return $str;
		}
		else
		{
			return 'enter ("2012-07-20"),+/-,"no","m/d" ' ;
		}
	}
}
if ( ! function_exists('sort_field_select'))
{
	function sort_field_select($sort_field,$label)//Lastdate and current date default otherwise passed date ex ... add_date('2012-07-20','+','20','d');
	{
		if(isset($_POST['sort_action']) && $_POST['sort_action']=='DESC' && $_POST['sort_field']==$sort_field)
		{
		?>
		<a id="sort_desc" onClick="javascript:sorting_data('<?php echo $sort_field; ?>','ASC')" style="color:#FFF;"><?php echo $label; ?><img border="0" src="images/sortdown.gif"/></a>			
		<?php
		}
		else if(isset($_POST['sort_action']) && $_POST['sort_action']=='ASC' && $_POST['sort_field']==$sort_field)
		{
		?>
		<a id="sort_asc" onClick="javascript:sorting_data('<?php echo $sort_field; ?>','DESC');" style="color:#FFF;" ><?php echo $label; ?><img border="0" src="images/sortup.gif"/></a>
		<?php  
		}
		else
		{
		?>
		<a id="sort_asc" onClick="javascript:sorting_data('<?php echo $sort_field; ?>','ASC');" style="color:#FFF;" ><?php echo $label; ?></a><?php  
		}
	}
}

/* In New Login Used This Function

if ( ! function_exists('sort_field_select'))
{
	function sort_field_select($sort_field,$label)//Lastdate and current date default otherwise passed date ex ... add_date('2012-07-20','+','20','d');
	{
		if(isset($_POST['sort_field']) && $_POST['sort_field']==$sort_field)
		{
			if($_POST['sort_action']=='ASC')
			{
			?>
				<span class="asc_field" onclick="sort_field('<?php echo $sort_field ?>','DESC');"><?php echo $label; ?></span>
			<?php
			}
			else
			{
			?>
				<span class="desc_field" onclick="sort_field('<?php echo $sort_field ?>','ASC');"><?php echo $label; ?></span>
			<?php
			}
		}
		else
		{
		?>
			<span class="sort_field" onclick="sort_field('<?php echo $sort_field ?>','ASC');"><?php echo $label; ?></span>
		<?php
		}
	}
}


*/
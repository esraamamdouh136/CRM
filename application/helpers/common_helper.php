<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

global $TablesNumber;
$TablesNumber = [
    "radm" => 1,
    'operation_mward'=>2,
    "tasmeed" => 3,
    "ry" => 4,
    "ghars" => 5,
    "mokafaha" => 6,
    "palm_operation" => 7,
    "fasayil" => 8,
    "fasayil_operation" => 9,
    "diseases" => 10,
    "maitance" => 11,
    "mission" => 12,
    "aabar" => 13,
    "rynetwork" => 14,
    "farmdata" => 15,
    "square" => 16,
    "disease_tgrba" => 17
];

function arrGetFirstRow($array,$colomName)
{
    $Obj = [] ;
    for ($i=0; $i < sizeof($array) ; $i++) {
        $Obj[] = $array[$i]->$colomName;
    }
    return $Obj;
}

function check_permission_user($userId,$permissionsId)
{
    $CI = &get_instance();
    $permissions=$CI->Model1->selectdata("permissioncrm",["permissionuser"=>$userId , "permissionid"=>$permissionsId ]);
    if (isset($permissions) && count($permissions) > 0) {
        return true;
    }
    else{
        return false;
    }
}

function getTableNumber($value)
{
    global $TablesNumber;
    return $TablesNumber[$value];
}

function count_points_value($points){



    if($points >= get_setting('min_points')){



        $point_setting= get_setting('points');

        $ex = explode('=', $point_setting);

        $total = $ex[0];

        $equal_points = $ex[1];

        $equal_money = $ex[2];

        return round(($points/$equal_points) * $equal_money,2);

    }else{

        return 'الحد الادنى للاستخدام هو '.get_setting('min_points');

    }

}

function count_total_order_points($total_invoice){



    $point_setting= get_setting('points');

    $ex = explode('=', $point_setting);

    $total = $ex[0];

    $equal_points = $ex[1];

    $equal_money = $ex[2];



    if($total_invoice >= $total )

        return round(($total_invoice / $total )) * $equal_points ;

    else

        return 0;



}

function sendMessage($msg){

    $content = array(

        "ar" => $msg,

        "en"=>$msg

    );



    $fields = array(

        'app_id' => get_setting('oneSignalAppId'),

        'included_segments' => array('All'),

        'data' => array("foo" => "bar"),

        'contents' => $content

    );



    $fields = json_encode($fields);





    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',

        'Authorization: Basic '.get_setting('ONESIGNAL_REST_API_Key')));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);



    $response = curl_exec($ch);

    curl_close($ch);



    return $response;

}

function order_msg(){

    $now = new DateTime(date('Y-m-d H:i'));

    $time_work_start =date('Y-m-d '.get_setting('Time_work_start'));

    $time_work_end = date('Y-m-d '.get_setting('Time_work_end'));

    $tomorow_start = date('Y-m-d H:i',strtotime($time_work_start.'+1 days'));



    $time_work_start = new DateTime($time_work_start, new DateTimeZone('Africa/Cairo'));

    $time_work_end   = new DateTime($time_work_end, new DateTimeZone('Africa/Cairo'));

    $tomorow_start = new DateTime($tomorow_start, new DateTimeZone('Africa/Cairo'));





    if($now >= $time_work_start && $now <= $time_work_end )

        return get_setting('order_received');

    if($now < $time_work_start ){

        $dteDiff  = $time_work_start->diff($now);

        return get_setting('order_send').$dteDiff->format("%H ساعه و %I دقيقة");

    }

    if($now > $time_work_end ){

        $dteDiff  = $tomorow_start->diff($now);

        return get_setting('order_send').$dteDiff->format("%H ساعه و %I دقيقة");

    }

}

function count_table($table,$where){



    $data  = table($table,$where);

    $count = count($data);

    if($count > 0)

        return $count;

    else

        return '0';

}

function getCategoryTreeSelect($module_title,$parent_category_id = 0, $level = ' ', $category_id = 0) {



    $result = table_multi_join('category', 'category_id', ['parent_category_id' => $parent_category_id, 'lang' => 'ar','module_title'=>$module_title,'is_active'=>1], 'category_lang', 'category_id');



    $menu = '';

    if (!empty($result)) {

        foreach ($result as $row) {

            if (  $row -> category_id == $category_id)

                $select = 'selected="selected"';

            else

                $select = '';

            $menu .= '<option ' . $select . ' value="' . $row -> category_id . '" > ' .$level . ' - ' . $row -> title . '</option>';



            $check = table_multi_join('category', 'category_id', ['parent_category_id' => $row -> category_id, 'lang' => 'ar','module_title'=>$module_title,'is_active'=>1], 'category_lang', 'category_id');



            if (!empty($check)) {



                $menu .= getCategoryTreeSelect($module_title,$row -> category_id, $level . ' - '.$row->title  ,$category_id);

            }

        }

    }



    return $menu;



}

function getMenuTreeCategory($module_title,$parent_category_id = 0, $category_id = 0) {

    $result = table_multi_join('category', 'category_id', ['parent_category_id' => $parent_category_id, 'lang' => 'ar','module_title'=>$module_title,'is_active'=>1], 'category_lang', 'category_id');



    $menu = '';

    if (count($result) > 0) {

        foreach ($result as $row) {

            $check =table_multi_join('category', 'category_id', ['parent_category_id' => $row->category_id, 'lang' => 'ar','module_title'=>$module_title,'is_active'=>1], 'category_lang', 'category_id');

            if (urldecode( current_url()) == site_url('home/category_posts/'.$row -> slug.'/limit'))

                $class = 'active';

            else

                $class = '';

            if (!empty($check)) {

                if($parent_category_id == 0)

                    $menu_class = 'MainMenu';else $menu_class = 'SubMenu';







                $menu .= '

				 <a   href="'.site_url("home/category_posts/".$row -> slug.'/limit').'" class="link '.$class.'">'.$row->title.'</a>

          <div href="#getMenuTreeCategory'.$row->category_id.'" class="list-group-item bg-group '.$class.'" data-toggle="collapse" data-parent="#'.$menu_class.'">

              <i class="fa fa-caret-down"></i>

          </div>

          <div class="collapse" id="getMenuTreeCategory'.$row->category_id.'"> ';



                $menu .= getMenuTreeCategory($module_title,$row -> category_id, $category_id);

                $menu .= ' </div>';

            } else {



                $menu .= ' <a href="'.site_url("home/category_posts/".$row -> slug.'/limit').'" class="list-group-item bg-group '.$class.'">'.$row->title.'</a>';

            }

        }

    }



    return $menu;

}

function page_title(){

    $CI = &get_instance();

    return $CI->page_title;



}

function rand_coupon(){

    $code = rand_str(16);

    $coupon = get_row('coupon',['code'=>$code]);

    if(!empty($coupon))

        rand_coupon();

    else

        return $code;

}

function rand_str($length = 5) {

    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $characters = '0123456789';

    $charactersLength = strlen($characters);

    $randomString = '';

    for ($i = 0; $i < $length; $i++) {

        $randomString .= $characters[rand(0, $charactersLength - 1)];

    }

    return $randomString;

}

function youtube_link($link){

    if(empty($link))

        return null;

    else{

        $array = explode('=',$link);

        if(!empty($array[1]))

            return $array[1];

        else

            return null;

    }



}

function count_forms($type = null){

    if($type == null){

        $seen = table('form',array('seen'=>1));

        $count_seen = count($seen);

        if($count_seen>0){

            return $count_seen;

        }else{

            return null;

        }

    }else{

        $seen = table('form',array('type'=>$type,'seen'=>1));

        $count_seen = count($seen);

        if($count_seen>0){

            return $count_seen;

        }else{

            return null;

        }

    }





}

function is_image($path)

{

    $CI = &get_instance();

    $a = getimagesize(FCPATH.$CI->image_path.'/'.$path);

    $image_type = $a[2];



    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))

    {

        return true;

    }

    return false;

}

function json($status,$msg=[]){

    $data['status'] = $status;

    $data['msg'] = $msg;

    echo json_encode($data);

}

function time_elapsed_string($datetime, $full = false) {

    $now = new DateTime;

    $ago = new DateTime($datetime);

    $diff = $now->diff($ago);



    $diff->w = floor($diff->d / 7);

    $diff->d -= $diff->w * 7;



    $string = array(

        'y' => lang('year'),

        'm' => lang('month'),

        'w' => lang('week'),

        'd' => lang('day'),

        'h' => lang('hour'),

        'i' => lang('minute'),

        's' => lang('second'),

    );

    foreach ($string as $k => &$v) {

        if ($diff->$k) {

            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');

        } else {

            unset($string[$k]);

        }

    }



    if (!$full) $string = array_slice($string, 0, 1);

    return $string ? implode(', ', $string) . lang(' ago') : lang('just now');

}

function time_since($since) {

    $chunks = array(

        array(60 * 60 * 24 * 365 , lang('year')),

        array(60 * 60 * 24 * 30 , lang('month')),

        array(60 * 60 * 24 * 7, lang('week')),

        array(60 * 60 * 24 , lang('day')),

        array(60 * 60 , lang('hour')),

        array(60 , lang('minute')),

        array(1 , lang('second'))

    );



    for ($i = 0, $j = count($chunks); $i < $j; $i++) {

        $seconds = $chunks[$i][0];

        $name = $chunks[$i][1];

        if (($count = floor($since / $seconds)) != 0) {

            break;

        }

    }



    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

    return $print;

}

function notification($title, $url,$member_id = 0, $action_data_time = null) {

    $CI = &get_instance();

    $data['title'] = $title;

    $data['url'] = $url;

    $data['member_id'] = $member_id;

    $data['action_data_time'] = $action_data_time;

    if ($CI -> gm -> add('notification', $data))

        return true;

    else

        return false;

}

function mobile_notification($title, $url,$member_id = 0, $action_data_time = null) {

    $CI = &get_instance();

    $data['mobile_title'] = $title;

    $data['mobile_url'] = $url;

    $data['member_id'] = $member_id;

    $data['action_data_time'] = $action_data_time;

    if ($CI -> gm -> add('notification', $data))

        return true;

    else

        return false;

}





function all_notes(){



    $notes = table('notification',array('seen'=>1));

    if(empty($notes))

        return null;

    else

        return $notes;

}





function all_contact(){



    $contacts = table('contact',array('is_read'=>1));

    if(empty($contacts))

        return null;

    else

        return $contacts;

}





function logs($url=null,$title=null){

    if($url == null)

        $url = current_url();

    $CI = &get_instance();

    $data['title'] = $title;

    $data['url'] = $url;

    $data['user_id']= $CI->user_id;

    $data['ip_address']= $_SERVER['REMOTE_ADDR'];

    if ($CI -> gm -> add('log', $data))

        return true;

    else

        return false;



}



function pagination($parm = []) {

    if (empty($parm['segment']))

        $parm['segment'] = 4;



    $CI = &get_instance();

    $CI -> load -> library('pagination');

    //$page = new pagination();

    $config['base_url'] = site_url() .'/'. $parm['url'];

    if(isset($parm['like']))

        $CI->db->like($parm['like']);

    if(!empty($parm['table2']))

        $config['total_rows'] = count(table($parm['table'], $parm['where'],$parm['table2']));

    else

        $config['total_rows'] = count(table($parm['table'], $parm['where']));

    $config['per_page'] = get_setting('per_page');

    $config['uri_segment'] = $parm['segment'];



    // design





    $config['prev_link'] = lang("Previous");

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';

    $config['next_link'] = lang("Next");

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</a></li>';

    $config['cur_tag_open'] = '<li ><a class="active">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';

    $config['first_link'] = FALSE;

    $config['last_link'] = FALSE;



    //design







    $CI -> pagination -> initialize($config);

    return $CI -> pagination -> create_links();



}







function pagination_segment($parm = []) {





    $CI = &get_instance();

    $CI -> load -> library('pagination');

    //$page = new pagination();

    $config['base_url'] = site_url() .'/'. $parm['url'];

    if(!empty($parm['table2']))

        $config['total_rows'] = count(table_multi_join($parm['table'],$parm['table_id'], $parm['where'],$parm['table2'],$parm['table2_id'],null,null,$parm['like']));

    else

        $config['total_rows'] = count(table($parm['table'], $parm['where']));





    $config['per_page'] = get_setting('per_page');

    //$config['uri_segment'] = $parm['segment'];

    $config['enable_query_strings'] = TRUE;

    $config['page_query_string'] = TRUE;

    // design



    $config['prev_link'] = lang("Previous");

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';

    $config['next_link'] = lang("Next");

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</a></li>';

    $config['cur_tag_open'] = '<li ><a class="active">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';

    $config['first_link'] = FALSE;

    $config['last_link'] = FALSE;



    //design







    $CI -> pagination -> initialize($config);

    return $CI -> pagination -> create_links();



}



function lable_title($title, $module_id, $lang,$lang_type = null) {

    if($lang_type == null)

        $lang_type = get_lang();



    $result = get_row('module_titles', array('record_name' => $title, 'module_id' => $module_id));



    if (empty($result -> value_ar) && empty($result -> value_en)) {



        return lang($lang);

        //return lang($lang);

    } else {

        if ($lang_type == 'ar')

            return $result -> value_ar;

        else

            return $result -> value_en;

    }



}



function get_lang() {



    $my = new MY_Controller();

    return $my -> get_lang;

}



function query($query) {

//    var_dump($query);die;

    $CI = &get_instance();

//	var_dump($CI);die;

    return $CI -> db -> query($query) -> result();

}





function table_data($table) {

    $CI = &get_instance();

    $result = $CI -> db -> field_data($table);

    if (empty($result)) {

        return NULL;

    } else {

        return $result;

    }

}



function table($table, $where = array(), $table2 = null, $table3 = null, $join_type = '',$too=null) {

    $CI = &get_instance();

    if ($table2 != NULL) {

        $CI -> db -> join($table2, $table . '.' . $table . '_id = ' . $table2 . '.' . $table . '_id', $join_type);

    }

    if ($table3 != NULL) {

        $CI -> db -> join($table3, $table . '.' . $table . '_id = ' . $table3 . '.' . $table . '_id', $join_type);

    }
    if($too != null)$CI -> db -> order_by($too, 'desc');
    return $CI -> db -> where($where) -> get($table) -> result();

}



function table_multi_join($table, $id = null, $where = array(), $table2 = null, $id2 = null, $table3 = null, $id3 = null,$like=[]) {

    $CI = &get_instance();

    if(!empty($like))

        $CI->db->like($like);

    if ($table2 != NULL) {

        $CI -> db -> join($table2, $table . '.' . $id . ' = ' . $table2 . '.' . $id2);

    }

    if ($table3 != NULL) {

        $CI -> db -> join($table3, $table . '.' . $id . ' = ' . $table3 . '.' . $id3);

    }

    return $CI -> db -> where($where) -> get($table) -> result();

}



function get_member_rank($member_id) {



    $member = get_row('member', array('member_id' => $member_id));

    $rank = round($member -> rank);

    //  echo $rank;

    $class1 = '';

    $class2 = '';

    $class3 = '';

    $class4 = '';

    $class5 = '';

    if ($rank >= 1)

        $class1 = 'color_lbrown';

    if ($rank >= 2)

        $class2 = 'color_lbrown';

    if ($rank >= 3)

        $class3 = 'color_lbrown';

    if ($rank >= 4)

        $class4 = 'color_lbrown';

    if ($rank >= 5)

        $class5 = 'color_lbrown';



    echo '

   <li onclick="member_rank(' . $member_id . ',1)" class="' . $class1 . '"><i class="fa fa-star tr_all"></i></li>

   <li onclick="member_rank(' . $member_id . ',2)" class="' . $class2 . '"><i class="fa fa-star tr_all"></i></li>

   <li onclick="member_rank(' . $member_id . ',3)" class="' . $class3 . '"><i class="fa fa-star tr_all"></i></li>

   <li onclick="member_rank(' . $member_id . ',4)" class="' . $class4 . '"><i  class="fa fa-star tr_all"></i></li>

   <li onclick="member_rank(' . $member_id . ',5)" class="' . $class5 . '"><i class="fa fa-star tr_all"></i></li>

    ';



}



function get_rank($post_id) {



    $post = get_row('post', array('post_id' => $post_id));

    $rank = round($post -> rank);

    //  echo $rank;

    $class1 = '';

    $class2 = '';

    $class3 = '';

    $class4 = '';

    $class5 = '';

    if ($rank >= 1)

        $class1 = 'active';

    if ($rank >= 2)

        $class2 = 'active';

    if ($rank >= 3)

        $class3 = 'active';

    if ($rank >= 4)

        $class4 = 'active';

    if ($rank >= 5)

        $class5 = 'active';



    echo '

   <li onclick="rank(' . $post_id . ',1)" class="' . $class1 . '"></li>

   <li onclick="rank(' . $post_id . ',2)" class="' . $class2 . '"></li>

   <li onclick="rank(' . $post_id . ',3)" class="' . $class3 . '"></li>

   <li onclick="rank(' . $post_id . ',4)" class="' . $class4 . '"></li>

   <li onclick="rank(' . $post_id . ',5)" class="' . $class5 . '"></li>

    ';



}





function get_rank_app($post_id) {



    $post = get_row('post', array('post_id' => $post_id));

    $rank = round($post -> rank);

    //  echo $rank;

    $class1 = '';

    $class2 = '';

    $class3 = '';

    $class4 = '';

    $class5 = '';

    if ($rank >= 1)

        $class1 = 'active';

    if ($rank >= 2)

        $class2 = 'active';

    if ($rank >= 3)

        $class3 = 'active';

    if ($rank >= 4)

        $class4 = 'active';

    if ($rank >= 5)

        $class5 = 'active';





    return '

	 			<input   class="star star-5 ' . $class5 . '" id="star-5" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ')"  class="star star-5 ' . $class5 . '" for="star-5"></label>

                <input  class="star star-4 ' . $class4 . '" id="star-4" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ')"  class="star star-4 ' . $class4 . '" for="star-4"></label>

                <input  class="star star-3 ' . $class3 . '" id="star-3" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ')"  class="star star-3 ' . $class3 . '" for="star-3"></label>

                <input    class="star star-2 ' . $class2 . '" id="star-2" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ')"  class="star star-2 ' . $class2 . '" for="star-2"></label>

                <input    class="star star-1 ' . $class1 . '" id="star-1" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ')"  class="star star-1 ' . $class1 . '" for="star-1"></label>

	

   

    ';







    /*return '

                 <input   class="star star-5 ' . $class5 . '" id="star-5" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ',5)"  class="star star-5 ' . $class5 . '" for="star-5"></label>

                <input  class="star star-4 ' . $class4 . '" id="star-4" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ',4)"  class="star star-4 ' . $class4 . '" for="star-4"></label>

                <input  class="star star-3 ' . $class3 . '" id="star-3" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ',3)"  class="star star-3 ' . $class3 . '" for="star-3"></label>

                <input    class="star star-2 ' . $class2 . '" id="star-2" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ',2)"  class="star star-2 ' . $class2 . '" for="star-2"></label>

                <input    class="star star-1 ' . $class1 . '" id="star-1" type="radio" name="star" />

                <label  onclick="rank(' . $post_id . ',1)"  class="star star-1 ' . $class1 . '" for="star-1"></label>



   

    ';

    */



}





function get_image($image = 'no_image.png') {

    if ($image == null)

        $image = 'no_image.png';

    return base_url() . 'assets/uploads/images/' . $image;

}



function view($view_name, $data = array()) {

    $CI = &get_instance();

    $CI -> load -> view($view_name, $data);

}



function lastq() {

    $CI = &get_instance();

    echo $CI -> db -> last_query();

    die ;

}



function get_row($table, $where_array ,$like_array)  {
    $CI = &get_instance();
    if ($where_array != null ) {
        $CI->db->where($where_array);
    }
    if ($like_array != null) {
        $CI->db->LIKE($like_array);
    }
    $select = $CI->db->get($table);
    if ($CI->db->affected_rows() == 0)
        return NULL;
    else
        return $select->row();

}



function get_setting($key) {

    $setting = get_row('setting', array('key' => $key));

    if ($setting != null)

        return $setting -> value;

    else

        return null;

}



function status_image($val) {

    if ($val == 0)

        return '<a  title="not active" ><i class="fa fa-close"></i></a>';

    if ($val == 1)

        return '<a title="active" ><i class="fa fa-check-circle-o"></i></a>';

}



function status_home($val) {

    if ($val == 0)

        return '<a title="show in home" ><i class="icon-home"></i></a>';

    if ($val == 1)

        return '<a title="show in home" ><i class="fa fa-home"></i></a>';

}



function get_category($parent_category_id) {

    $CI = &get_instance();

    $CI -> load -> model('General_model');



    $category = $CI -> General_model -> get_join('category', array('category.category_id' => $parent_category_id));

    //echo $CI->db->last_query();die;

    if ($category != null) {

        foreach ($category as $row)

            return $row -> title;

    } else

        return ' - ';

}



function get_modules() {



    $CI = &get_instance();

    $CI -> load -> model('General_model');

    return $CI -> General_model -> get('module');

}



function create_slug($title, $id) {



    return str_replace(' ', '_', $title) . '_' . $id;

}



function create_option($type, $name, $lang, $val = array()) {

    $field = get_row('field_option', array('field_name' => $name));

    $title = $field -> field_title;

    if (!isset($val['post_id']))// add post

        $val['post_id'] = 0;



    if ($type == 'text') {

        if ($lang) {

            $result = ' <div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . ' ' . lang($lang) . '</label>

                    <div class="col-md-4">

                    <input  name="' . $name . '_' . $lang . '" value="' . get_field_value($val["post_id"], $val["field_option_id"], $lang) . '" class="form-control" id="form_control_1" >

                    <div class="form-control-focus"> </div></div></div>  ';

        } else {

            $result = '<div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . '</label>

                    <div class="col-md-4">

                    <input  name="' . $name . '" value="' . get_field_value($val["post_id"], $val["field_option_id"]) . '" class="form-control" id="form_control_1" >

                    <div class="form-control-focus"> </div></div></div>  ';

        }

    }

    if ($type == 'textarea') {



        if ($lang) {

            $result = ' <div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . ' ' . lang($lang) . '</label>

                    <div class="col-md-4">

                    <textarea  name="' . $name . '_' . $lang . '" rows="3" class="form-control" >' . get_field_value($val["post_id"], $val["field_option_id"], $lang) . '</textarea>

                    <div class="form-control-focus"> </div></div></div>  ';

        } else {

            $result = '<div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . '</label>

                    <div class="col-md-4">

                   <textarea name="' . $name . '" rows="3" class="form-control" >' . get_field_value($val["post_id"], $val["field_option_id"]) . '</textarea>

                    <div class="form-control-focus"> </div></div></div>  ';

        }

    }

    if ($type == 'select') {



        if ($lang) {

            $field_value = get_field_value($val["post_id"], $val["field_option_id"], $lang);

            $result = ' <div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . ' ' . lang($lang) . '</label>

                    <div class="col-md-4">

                     <select name="' . $name . '_' . $lang . '" class="form-control">';



            if ($val["val_" . $lang] != null) {

                $val_lang = unserialize($val["val_" . $lang]);

                foreach ($val_lang as $row) {

                    $selected = "";

                    if ($field_value == $row)

                        $selected = "selected";



                    $result .= '<option ' . $selected . ' value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select>  <div class="form-control-focus"> </div></div></div>  ';

        } else {

            $field_value = get_field_value($val["post_id"], $val["field_option_id"]);

            $result = ' <div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . '</label>

                    <div class="col-md-4">

                     <select name="' . $name . '" class="form-control">';



            if ($val["val"] != null) {

                $val = unserialize($val["val"]);

                foreach ($val as $row) {

                    $selected = "";

                    if ($field_value == $row)

                        $selected = "selected";



                    $result .= '<option  ' . $selected . '  value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select>  <div class="form-control-focus"> </div></div></div>  ';

        }

    }



    if ($type == 'multi_select') {



        if ($lang) {



            $field_value = get_field_value($val["post_id"], $val["field_option_id"], $lang, 1);



            $result = ' <div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . ' ' . lang($lang) . '</label>

                    <div class="col-md-4">

                     <select name="' . $name . '_' . $lang . '[]" class="bs-select form-control" multiple >';



            if ($val["val_" . $lang] != null) {

                $val_lang = unserialize($val["val_" . $lang]);



                foreach ($val_lang as $row) {

                    $selected = "";

                    if (is_array($field_value)) {

                        if (in_array($row, $field_value))

                            $selected = "selected";

                    }



                    $result .= '<option ' . $selected . ' value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select> ' . lang("multi_select") . '  <div class="form-control-focus"> </div></div></div>  ';

        } else {



            $field_value = get_field_value($val["post_id"], $val["field_option_id"], false, 1);

            $result = ' <div class="form-group form-md-line-input">

                   <label for="inputEmail1" class="col-md-2 control-label">' . $title . '</label>

                    <div class="col-md-4">

                     <select name="' . $name . '[]" class="bs-select form-control" multiple >';



            if ($val["val"] != null) {

                $val = unserialize($val["val"]);

                foreach ($val as $row) {

                    $selected = "";

                    if (is_array($field_value)) {

                        if (in_array($row, $field_value))

                            $selected = "selected";

                    }

                    $result .= '<option  ' . $selected . ' value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select>  ' . lang("multi_select") . '  <div class="form-control-focus"> </div></div></div>  ';

        }

    }



    if ($type == 'radio') {

        $option_id = $val["field_option_id"];

        if ($lang) {



            $value = unserialize($val["val_" . $lang]);

            if ($value != null) {

                $field_value = get_field_value($val["post_id"], $val["field_option_id"], $lang);

                $result = '

<div class="form-group form-md-line-input">

 <label class="col-md-2 control-label" for="form_control_1">' . $title . '</label>

 <div class="col-md-10">

  <div class="md-radio-inline">';

                if ($lang == 'en')

                    $counter = 100;

                if ($lang == 'ar')

                    $counter = 103;

                foreach ($value as $row) {

                    $check = "";

                    if ($field_value == $row)

                        $check = "checked";

                    $num = $option_id + $counter;

                    $result .= '<div class="md-radio">

   <input type="radio" ' . $check . ' value="' . $row . '" id="radio' . $num . '"  name="' . $name . '_' . $lang . '" class="md-radiobtn">

  <label for="radio' . $num . '">

  <span></span>

 <span class="check"></span>

  <span class="box"></span>' . $row . ' </label>

 </div>';



                    $counter++;

                }



                $result .= '</div></div></div>';

            }

        } else {

            if ($val["val"] != null) {

                $field_value = get_field_value($val["post_id"], $val["field_option_id"]);

                $result = '

<div class="form-group form-md-line-input">

 <label class="col-md-2 control-label" for="form_control_1">' . $title . '</label>

 <div class="col-md-10">

  <div class="md-radio-inline">';

                $counter = 200;



                if(!empty($val['val'])){foreach (unserialize($val["val"]) as $row) {

                    $check = "";

                    if ($field_value == $row)

                        $check = "checked";

                    $num = $option_id + $counter;

                    $result .= '<div class="md-radio">

   <input type="radio"  ' . $check . '  value="' . $row . '" id="radio' . $num . '" name="' . $name . '" class="md-radiobtn">

  <label for="radio' . $num . '">

  <span></span>

 <span class="check"></span>

  <span class="box"></span>' . $row . ' </label>

 </div>';



                    $counter++;

                }



                    $result .= '</div></div></div>';

                }}

        }

    }



    return $result;

}



function create_option_front_end($type, $name, $lang, $val = array()) {

    $field = get_row('field_option', array('field_name' => $name));

    $title = $field -> field_title;

    if (!isset($val['post_id']))// add post

        $val['post_id'] = 0;



    if ($type == 'text') {

        if ($lang) {

            $result = ' <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . ' ' . lang($lang) . '</label>

                   

                    <input  name="' . $name . '_' . $lang . '" value="' . get_field_value($val["post_id"], $val["field_option_id"], $lang) . '" class="tr_all w_full fs_medium color_light" id="form_control_1" >

                    </li> ';

        } else {

            $result = ' <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . '</label>

               

                    <input  name="' . $name . '" value="' . get_field_value($val["post_id"], $val["field_option_id"]) . '" class="tr_all w_full fs_medium color_light" id="form_control_1" >

                   </li>  ';

        }

    }

    if ($type == 'textarea') {



        if ($lang) {

            $result = '  <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . ' ' . lang($lang) . '</label>

                   

                    <textarea  name="' . $name . '_' . $lang . '" rows="3" class="tr_all w_full fs_medium color_light" >' . get_field_value($val["post_id"], $val["field_option_id"], $lang) . '</textarea>

                   </li>  ';

        } else {

            $result = ' <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . '</label>

                   

                   <textarea name="' . $name . '" rows="3" class="tr_all w_full fs_medium color_light" >' . get_field_value($val["post_id"], $val["field_option_id"]) . '</textarea>

                  </li>  ';

        }

    }

    if ($type == 'select') {



        if ($lang) {

            $field_value = get_field_value($val["post_id"], $val["field_option_id"], $lang);

            $result = ' <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . ' ' . lang($lang) . '</label>

                   

                     <select name="' . $name . '_' . $lang . '" class="tr_all w_full fs_medium color_light">';



            if ($val["val_" . $lang] != null) {

                $val_lang = unserialize($val["val_" . $lang]);

                foreach ($val_lang as $row) {

                    $selected = "";

                    if ($field_value == $row)

                        $selected = "selected";



                    $result .= '<option ' . $selected . ' value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select>    </li> ';

        } else {

            $field_value = get_field_value($val["post_id"], $val["field_option_id"]);

            $result = '  <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font" >' . $title . '</label>

                    

                     <select name="' . $name . '" class="tr_all w_full fs_medium color_light">';



            if ($val["val"] != null) {

                $val = unserialize($val["val"]);

                foreach ($val as $row) {

                    $selected = "";

                    if ($field_value == $row)

                        $selected = "selected";



                    $result .= '<option  ' . $selected . '  value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select>  </li> ';

        }

    }



    if ($type == 'multi_select') {



        if ($lang) {



            $field_value = get_field_value($val["post_id"], $val["field_option_id"], $lang, 1);



            $result = ' <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . ' ' . lang($lang) . '</label>

                   

                     <select name="' . $name . '_' . $lang . '[]" class="bs-select form-control" multiple >';



            if ($val["val_" . $lang] != null) {

                $val_lang = unserialize($val["val_" . $lang]);



                foreach ($val_lang as $row) {

                    $selected = "";

                    if (is_array($field_value)) {

                        if (in_array($row, $field_value))

                            $selected = "selected";

                    }



                    $result .= '<option ' . $selected . ' value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select><br><p> ' . lang("multi_select") . '</p> </li> ' . ' <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



                       

 <script src="select2/components-bootstrap-select.min.js" type="text/javascript"></script>' . '<script src="select2/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>

<script src="select2/js/select2.full.min.js" type="text/javascript"></script>

<script src="select2/components-multi-select.min.js" type="text/javascript"></script>

<script type="text/javascript">

  $(".select2").select2();

  $(".select2-selection").css("float","right");

  $(".select2-selection").css("width","450px");

</script>

';

        } else {



            $field_value = get_field_value($val["post_id"], $val["field_option_id"], false, 1);

            $result = ' <li>

                   <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . '</label>

                   

                     <select name="' . $name . '[]" class="select2 fw_light color_light relative tr_all bs-select form-control" multiple >';



            if ($val["val"] != null) {

                $val = unserialize($val["val"]);

                foreach ($val as $row) {

                    $selected = "";

                    if (is_array($field_value)) {

                        if (in_array($row, $field_value))

                            $selected = "selected";

                    }

                    $result .= '<option  ' . $selected . ' value="' . $row . '">' . $row . '</option>';

                }

            }

            $result .= '  </select> <br><p> ' . lang("multi_select") . ' </p></li> ' . ' <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



                       

 <script src="select2/components-bootstrap-select.min.js" type="text/javascript"></script>' . '<script src="select2/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>

<script src="select2/js/select2.full.min.js" type="text/javascript"></script>

<script src="select2/components-multi-select.min.js" type="text/javascript"></script>

<script type="text/javascript">

  $(".select2").select2();

 

  

 

</script>

<style>

.select2-selection{float:right;width:450px}

.select2-dropdown{    right: -43px;!important;width:450px!important}

</style>

';

        }

    }



    if ($type == 'radio') {

        $option_id = $val["field_option_id"];

        if ($lang) {



            $value = unserialize($val["val_" . $lang]);

            if ($value != null) {

                $field_value = get_field_value($val["post_id"], $val["field_option_id"], $lang);

                $result = '

<li>

 <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . '</label>

 

  ';

                if ($lang == 'en')

                    $counter = 100;

                if ($lang == 'ar')

                    $counter = 103;

                foreach ($value as $row) {

                    $check = "";

                    if ($field_value == $row)

                        $check = "checked";

                    $num = $option_id + $counter;

                    $result .= '

   <input type="radio" ' . $check . ' value="' . $row . '" id="radio' . $num . '"  name="' . $name . '_' . $lang . '" class="tr_all w_full fs_medium color_light">

  <label class=" clickable d_inline_b m_bottom_5 second_font" for="radio' . $num . '">

  <span></span>

 <span class="check"></span>

  <span class="box"></span>' . $row . ' </label>

 ';



                    $counter++;

                }



                $result .= '</li>';

            }

        } else {

            if ($val["val"] != null) {

                $field_value = get_field_value($val["post_id"], $val["field_option_id"]);

                $result = '

<li>

 <label class=" clickable d_inline_b m_bottom_5 second_font">' . $title . '</label>

 ';

                $counter = 200;

                foreach ($val["val"] as $row) {

                    $check = "";

                    if ($field_value == $row)

                        $check = "checked";

                    $num = $option_id + $counter;

                    $result .= '

   <input type="radio"  ' . $check . '  value="' . $row . '" id="radio' . $num . '" name="' . $name . '" class="tr_all w_full fs_medium color_light">

  <label class=" clickable d_inline_b m_bottom_5 second_font" for="radio' . $num . '">

  <span></span>

 <span class="check"></span>

  <span class="box"></span>' . $row . ' </label>

 ';



                    $counter++;

                }



                $result .= '</li>';

            }

        }

    }



    return $result;

}



function get_field_value($post_id = 0, $field_option_id = 0, $lang = false, $is_multi = 0) {



    if ($post_id) {

        if ($lang)

            $where = array('lang' => $lang, 'post_id' => $post_id, 'field_option_id' => $field_option_id);

        else

            $where = array('post_id' => $post_id, 'field_option_id' => $field_option_id);

        $field_value = get_row('post_field_value', $where);



        if (!$field_value) {

            if ($is_multi)

                return array();

            else

                return '';

        } else {

            if (!$is_multi)

                return $field_value -> field_value;

            else

                return unserialize($field_value -> field_value);

        }

    } else

        return '';

}



function get_perm_id($perm_name) {

    $CI = &get_instance();

    $get = $CI -> db -> where('name', $perm_name) -> get('permission') -> row();

    // echo $CI->db->last_query();

    if ($get)

        return $get -> permission_id;

    else

        return null;

}



function check_permission($group_id, $perm_id) {



    $CI = &get_instance();

    $get = $CI -> db -> where('user_group_id', $group_id) -> where('permission_id', $perm_id) -> get('active_permission') -> row();

    // echo $CI->db->last_query();

    if ($get == NULL)

        return false;

    else

        return true;

}



function perm($name, $module = 'general') {



    $CI = &get_instance();

    if ($CI -> tank_auth -> get_user_id() == 1)

        return true;

    else

        return check_permission($CI -> session -> userdata('user_group_id'), get_perm_id($module . '-' . $name));

}



function module_id($module_title) {

    $module = get_row('module', array('title' => $module_title));

    if ($module)

        return $module -> module_id;

    else

        return null;

}



function category_module($category_id) {



    $category = get_row('category', array('category_id' => $category_id));

    if ($category)

        return module_id($category -> module_title);

    else

        return null;

}



function post_module($post_id) {

    $post = get_row('post', array('post_id' => $post_id));

    if ($post)

        return module_id($post -> module_title);

    else

        return null;

}



function module_title_by_category($category_id) {

    $category = get_row('category', array('category_id' => $category_id));

    if ($category)

        return $category -> module_title;

    else

        return null;

}



function get_current_currancy() {

    $CI = &get_instance();

    $CI -> load -> model('General_model');

    $array = array();

    $posts = $CI -> General_model -> get_join_active_home('post', array('module_title' => 'currency'));

    if ($posts != null) {

        foreach ($posts as $row)

            $currancy_symbol = get_row('post_field_value', array('post_id' => $row -> post_id, 'field_option_id' => 1));

        if ($currancy_symbol != null)

            $array['symbol'] = $currancy_symbol -> field_value;

        // $array = array_merge((array)$row, (array)$currancy_symbol);



        $currancy_shortcut = get_row('post_field_value', array('post_id' => $row -> post_id, 'field_option_id' => 5));

        if ($currancy_shortcut != null)

            $array['shortcut'] = $currancy_shortcut -> field_value;

        //$array = array_merge((array)$row, (array)$currancy_shortcut);

        $array = array_merge((array)$row, (array)$array);

    }



    return $array;

}



function count_price($price) {

    $CI = &get_instance();

    $count = $CI -> current_currency['price'] * $price;



    return $CI -> current_currency['symbol'] . ' ' . $count;

}



function get_gallery($post_id) {

    $CI = &get_instance();

    return $CI -> General_model -> get('gallery', array('post_id' => $post_id));

}



function get_comments($post_id) {

    return table_multi_join('comment', 'member_id', array('post_id' => $post_id), 'member', 'member_id', 'member_profiles', 'member_id');

}










function get_ads($ads_id, $lang, $ads_size) {

    $data['url'] = '';

    $data['image'] = 'ddd.png';

    $data['title'] = get_setting('ads_here') . ' ' . $ads_size;

    if ($ads_id != 0) {

        $ads = get_row('post', array('post.post_id' => $ads_id, 'lang' => $lang), 'post_lang');

        if (!empty($ads)) {

            if ($ads -> end_date < date('Y-m-d')) {

                // $ads_size = get_field_value($ads_id, 10);

                $data['url'] = '';

                $data['image'] = 'ddd.png';

                $data['title'] = get_setting('ads_here') . ' ' . $ads_size;

            }

            if ($ads -> end_date > date('Y-m-d')) {

                $ads_url = get_field_value($ads_id, 6);

                $data['url'] = $ads_url;

                $data['image'] = $ads -> image;

                $data['title'] = $ads -> title;

            }

        }

    }

    return $data;

}


/////////////////////////////////////////////RAMADAN START FROM////////////////////////////////////////////////
/*add employee in table_employee */
function addWorked_Employee($employees ,$cost , $From_Table , $From_Row ,$type)
{
    $CI = &get_instance();
    $EmployeeIDs = explode("@",$employees);
    $CostArray = explode("@",$cost);
    for ($i=0; $i < sizeof($EmployeeIDs) ; $i++) {
        if ($CI->Model1->addtotable("employee_table",["employee_id"=> $EmployeeIDs[$i],"from_t"=> $From_Table, "table_id"=>$From_Row, "cost" => $CostArray[$i], "type" => $type ]) == "ERROR") {
            return "ADDEMPERROR";
        }
    }
    return "ok";
}

function RemoveTable_Employee($EmpID, $table)
{
    $CI = &get_instance();
    $EmployeeIDs = explode("@",$EmpID);
    for ($i=0; $i < sizeof($EmployeeIDs) ; $i++) {
        if ($CI->Model1->removefromtable($table,["id" => $EmployeeIDs[$i] ]) == "ERROE") {
            return "ERROR";
        }
    }
    return "DONE";
}


// start from here
//insert  mo3dat_table 
function addm3dmaintance()
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $row['mo3da_id'] = $CI->post("mo3da_id");
    $data['table_id'] = $CI->post("table_id");
    $row['num_hours'] =$CI->post("num_hours");
    $row['type'] = $CI->post("type");
    $row['cost'] = $CI->post("cost");



    $result = $CI->Model1->addtotable("mo3da_table" , $row);

}

//insert  ore_table
function addoremintance()
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $row['khama_id'] = $CI->post("khama_id");
    $row['cost'] =$CI->post("cost");
    $row['quntity'] = $CI->post("quntity");
    $row['unit_id'] = $CI->post("unit_id");
    $row['type'] = $CI->post("type");
    $row['way_use'] = $CI->post("way_use");


    $result = $CI->Model1->addtotable("khamat_table" , $row);

}
//update  mo3dat_table
function updatem3dmaintance()
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $cond["id"]=$CI->post("myid");
    $row['mo3da_id'] = $CI->post("mo3da_id");
    $data['table_id'] = $CI->post("table_id");
    $row['num_hours'] =$CI->post("num_hours");
    $row['type'] = $CI->post("type");
    $row['cost'] = $CI->post("cost");



    $result = $CI->Model1->addtotable("mo3da_table" , $cond,$row);

}

//insert  ore_table
function updateoremintance()
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $cond["id"]=$CI->post("myid");
    $row['khama_id'] = $CI->post("khama_id");
    $row['cost'] =$CI->post("cost");
    $row['quntity'] = $CI->post("quntity");
    $row['unit_id'] = $CI->post("unit_id");
    $row['type'] = $CI->post("type");
    $row['way_use'] = $CI->post("way_use");


    $result = $CI->Model1->addtotable("khamat_table" ,$cond, $row);

}

//remove from m3ad_table
function removem3ad($m3adid)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $cond["id"]=$m3adid;
    $result = $CI->Model1->removefromtable("mo3da_table",$cond);

}
//remove from ore_table
function removekham($kham)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $cond["id"]=$kham;
    $result = $CI->Model1->removefromtable("khamat_table",$cond);

}

//get m3ad_table
function getallm3ad($id=NULL,$table_id=NULL,$m3ad_id=NULL)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $cond["1"]=1;
    if($m3ad_id!=NULL)
    {
        $cond["mo3da_id"]=$m3ad_id;
    }
    if($id!=NULL)
    {
        $cond["id"]=$id;
    }
    if($table_id!=NULL)
    {
        $cond["table_id"]=$table_id;
    }
    $result= $CI->Model1->selectdata("mo3da_table",$cond,null);



}

//start crm project
function getuname($id=NULL)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $cond["1"]=1;

    if($id!=NULL)
    {
        $cond["userCrmId"]=$id;
    }
    $result= $CI->Model1->selectdata("usercrm",$cond,null);
    if($result==NULL)
    {
        return "لا يوجد له مشرف";
    }
    else
    {
        return $result[0]->userCrmName;
    }

}
//get count call
function countCall($userid,$callstatus=NULL)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    if($callstatus==0)
    {

        $result = $CI->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
            "(customercrm.Callstatus=0 and customerCrmEmp=".$userid.") or (Date(customercrm.customerCrmUpdateDate)='".date("Y:m:d")."' and customerCrmEmp=".$userid.") or 
			 (statuscrm.statusCrmfilter=1 and Date(customercrm.follow)='".date("Y:m:d")."' and customerCrmEmp=".$userid.")");
    }
    if($callstatus==1)
    {
        $result = $CI->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
            "(customercrm.Callstatus=0 and customerCrmEmp=".$userid.")  or (statuscrm.statusCrmfilter=1 and Date(customercrm.follow)='".date("Y:m:d")."' and customerCrmEmp=".$userid.")");
    }
    else
    {
        $result= $CI->Model1->selectdata("customercrm",["customerCrmEmp"=>$userid],null);

    }
    if($result!=null)
    {
        return count($result);
    }
    else
    {
        return 0;
    }

}
function get_message($userid,$type,$send)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    if($send==1)
    {
        $result= $CI->Model1->selectdata("messagecrm",["CrmMessagesFrom"=>$userid,"CrmMessagesType"=>$type],null);
    }
    else
    {
        $result= $CI->Model1->selectdata("messagecrm",["CrmMessagesTo"=>$userid,"CrmMessagesType"=>$type],null);
    }
    return $result;
}
function get_pre($userid,$type)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $result= $CI->Model1->selectdata("permissioncrm",["permissionuser"=>$userid,"permissionid"=>$type],null);
    if($result==NULL)
    {
        return 0;
    }else
        return 1;
}

function get_premissions($userid,$objCode)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $result= $CI->Model1->selectdata("crm_users_permissions",["UserID"=>$userid,"Object_Code"=>$objCode],null);
    if($result==NULL)
    {
        return 0;
    }else{
        return $result[0]->IsGranted;
    }

}


function get_name($userid,$type)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    if($type==1)
    {
        $result= $CI->Model1->selectdata("usercrm",["userCrmId"=>$userid],null);
        if($result!=NULL)
            return $result[0]->userCrmName;
        return "لا يوجد";
    }
    else
    {
        $result= $CI->Model1->selectdata("customercrm",["customerCrmId"=>$userid],null);
        if($result!=NULL)
            return $result[0]->customerCrmName;

        return "لا يوجد";
    }
}



function get_Emp_name($userid)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $result= $CI->Model1->selectdata("crm_users",["ID"=>$userid],null);
    if($result!=NULL)
        return $result[0]->Name;
    return "لا يوجد";

}
function get_Super_Name($userid){
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $result= $CI->Model1->selectdata("crm_users",["ID"=>$userid],null);
    if($result!=NULL)
        return get_Emp_name($result[0]->Super);
    return "لا يوجد";

}

function get_change($type)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $result= $CI->Model1->selectdata("changecrm",["type"=>$type],null);
    return $result[0]->Content;
}

//ge emp calls for reports
function get_Call($userid=NULL,$callstatus=NULL,$statusCrmfilter=NULL , $from=0 , $sDate = null , $eDate = null)
{
    $CI = &get_instance();
    //$CI->load->model("Model1");
    $CI->load->model("Employee_Taskes");
    $data['url'] = base_url();


    $cond["1"]="1";
    if($userid!=NULL)
    {
        $cond["customerCrmEmp"]=$userid;
    }
    if($callstatus!=NULL)
    {
        $cond["statusCrmType"]=$callstatus;
    }
    if($statusCrmfilter!=NULL)
    {
        $cond["statusCrmfilter"]=$statusCrmfilter;
    }
    if($from){
        $cond["date(customercrm.customerCrmCreateDate) >= "]=$sDate;
        $cond["date(customercrm.customerCrmCreateDate) <= "]=$eDate;
    }
    if ($sDate ==null){
        $date1 =  date("Y-m-d") ;
    }else{
        $date1= $sDate;
    }
    if ($eDate ==null){
        $date2 =  date("Y-m-d") ;

    }else{
        $date2= $eDate;
    }

    if ($userid == null){
        $ID = 0;
    }else{
        $ID = $userid;
    }
    $result = $CI->Employee_Taskes->GetTasksCount($date1,$date2,$callstatus,$ID);

    if($result!=null){
        return $result;
    }
    else{
        return 0;
    }




//
//
//    $cond["1"]="1";
//    if($userid!=NULL)
//    {
//        $cond["customerCrmEmp"]=$userid;
//    }
//    if($callstatus!=NULL)
//    {
//        $cond["statusCrmType"]=$callstatus;
//    }
//    if($statusCrmfilter!=NULL)
//    {
//        $cond["statusCrmfilter"]=$statusCrmfilter;
//    }
//    if($from){
//        $cond["date(customercrm.customerCrmCreateDate) >= "]=$sDate;
//        $cond["date(customercrm.customerCrmCreateDate) <= "]=$eDate;
//    }
//    $result = $CI->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" , $cond);
//
//    if($result!=null){
//        return count($result);
//    }
//    else{
//        return 0;
//    }

}

function get_Scall($userid,$callstatus=NULL,$statusCrmfilter=NULL , $from=0 , $sDate = null , $eDate = null)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();


    $cond["userCrmSuper"]=$userid;
    if($callstatus!=NULL)
    {
        $cond["statusCrmType"]=$callstatus;
    }
    if($statusCrmfilter!=NULL)
    {
        $cond["statusCrmfilter"]=$statusCrmfilter;
    }
    if($from){
        $cond["date(customercrm.customerCrmCreateDate) >= "]=$sDate;
        $cond["date(customercrm.customerCrmCreateDate) <= "]=$eDate;
    }

    $result = $CI->Model1->get_three_join("customercrm","usercrm", "statuscrm" ,"usercrm.userCrmId=customercrm.customerCrmEmp", "customercrm.Callstatus=statuscrm.statusCrmId" ,
        $cond);


    if($result!=null)
    {
        return count($result);
    }
    else
    {
        return 0;
    }

}
function count_product($prodid)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();
    $cond["prouductCrmId"]=$prodid;
    $result = $CI->Model1->selectdata("customerproductcrm", $cond);
    if($result!=null)
    {
        return count($result);
    }
    else
    {
        return 0;
    }

}

function GetClientByEMail($EMail){
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $result= $CI->Model1->selectdata("customercrm",["customerCrmEmail"=>$EMail],null);
    if($result!=NULL)
        return $result[0]->customerCrmName;
    return $EMail;
}

function GetOrderSettings($ParentID){
    $CI = &get_instance();
    $CI->load->model("ordersettingsModel");
    return $CI->ordersettingsModel->getAllChieldOrderSettings($ParentID);
}


function get_proudct_service($type){

    // $type => 1  Product ,,, $type  => 2  Service
    $CI = &get_instance();
    $CI->load->model("Products_Model");
    $item=$CI->Products_Model->GetProductsByType($type);
    // print_r((array)$item);die;
    foreach($item as $value){
        echo '<option value="'.$value->Product_ID.'">
                '.$value->Product_Name.'
            </option>';
    }
}

function IsHaveChiled($ID){
    $CI = &get_instance();
    $CI->load->model("ordersettingsModel");
    $result = $CI->ordersettingsModel->getChieldOrderSettings($ID);
    return (count($result) >0);
}

function getItemName($ID){
    $CI = &get_instance();
    $CI->load->model("Model1");
    $result = $CI->Model1->selectdata('crm_products',['Product_ID'=>$ID]);
    return $result[0]->Product_Name;
}

function getTransferTypeName($ID){
    $CI = &get_instance();
    $CI->load->model("Model1");
    $result = $CI->Model1->selectdata('crm_transfer_type',['transfer_ID'=>$ID]);
    return $result[0]->transfer_Name;
}

function getPaymentTypeName($ID){
    $CI = &get_instance();
    $CI->load->model("Model1");
    $result = $CI->Model1->selectdata('paymenttypes',['ID'=>$ID]);
    return $result[0]->Name;
}


function GetCallDuration($userID,$clientID){
    $parameters['userID']=$userID;
    $parameters['clientID']=$clientID;


    $CI = &get_instance();
    $CI->load->model("Users_Model");

    $result = $CI->Users_Model->GetCallDuration($parameters);
    //print_r($result);//die();

    if (count($result) <= 0 || !isset($result) ||is_null($result)){
        return 0;
    }else{
        return $result[0]->Duration;
    }

}

function GetTotalDelayedCalls(){
    $CI = &get_instance();
    $CI->load->model("CRM_FollowsModel");
    // get permission
    $per=get_premissions($_SESSION["userid"],'05');
    if ($per == 1){
        $result = count($CI->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2,$_SESSION['usertype'],1));
    }else{
        $result = count($CI->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2,$_SESSION['usertype']));
    }

    $_SESSION['TotalDelayedCalls'] =$result;
    return $result;
}
function GetcomplaintsCount(){
    $CI = &get_instance();
    $CI->load->model("ComplainModel");
    $result = count($CI->ComplainModel->GetUnReadComplain());
    return $result;
}
function GetTotalUpcommingCalls(){
    $CI = &get_instance();
    $CI->load->model("CRM_FollowsModel");
    $result = $CI->CRM_FollowsModel->getUpcommingCalls($_SESSION['userid']);
    $_SESSION['TotalUpcommingCalls'] =$result;
    return $result;
}
function GetNotifications(){
    $CI = &get_instance();
    $CI->load->model("Employee_Taskes");
    $result = $CI->Employee_Taskes->IsExistedNotification($_SESSION['userid']);
    $CI->Employee_Taskes->deleteNotification($_SESSION['userid']);
    return $result;
}
function GetMessages(){
    $CI = &get_instance();
    $CI->load->model("CRM_MessagesModel");
    $result = 0;
    $userID  = $_SESSION['userid'];
    $userType = $_SESSION['usertype'];
    if (!isset($userID) || is_null($userID)){
        return 0;
    }
    if ($userType == 1){
        $result = $CI->CRM_MessagesModel->GetUnreadMessages($userID,$userType);

        $result += $CI->CRM_MessagesModel->GetUnreadMessages($userID);

    }else{
        $result = $CI->CRM_MessagesModel->GetUnreadMessages($userID);
    }
    return $result;
}
function GetDelayedCallsCount(){
    $CI = &get_instance();
    $CI->load->model("CRM_FollowsModel");
    $userID  = $_SESSION['userid'];
    $userType = $_SESSION['usertype'];
    $per=get_premissions($_SESSION["userid"],'05');
    if ($per == 1){
        $result = $CI->CRM_FollowsModel->getUpcoming($userID,2,$userType,1);
    }else{
        $result = $CI->CRM_FollowsModel->getUpcoming($userID,2,$userType);
    }
   return count($result);
}
function GetUpcommingCallsCount(){
    $CI = &get_instance();
    $CI->load->model("CRM_FollowsModel");
    $userID  = $_SESSION['userid'];
    $per=get_premissions($_SESSION["userid"],'06');
    if ($per == 1){
        $result = $CI->CRM_FollowsModel->getUpcoming($userID,1,null,1);
    }else{
        $result = $CI->CRM_FollowsModel->getUpcoming($userID,1);
    }

    return count($result);
}

function get_Emp_role($userid)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $result= $CI->Model1->selectdata("crm_users",["ID"=>$userid],null);
    if($result!=NULL){
        $usertype = $result[0]->Type;
        $strUserType = "()";
        switch ($usertype){
            case 1:
                $strUserType = "(مدير)";
                break;
            case 2:
                $strUserType = "(مشرف)";
                break;
            case 3:
                $strUserType = "(موظف)";
                break;
            case 4:
                $strUserType = "(إدارى)";
                break;
        }
        return $strUserType;
    }

    return "()";

}

function get_Emp_ProfileImage($userid)
{
    $CI = &get_instance();
    $CI->load->model("Model1");
    $data['url'] = base_url();

    $result= $CI->Model1->selectdata("crm_users",["ID"=>$userid],null);
    if($result!=NULL)
        return $result[0]->Image;
    return "لا يوجد";

}
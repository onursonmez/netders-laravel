<?php

function static_url($path, $secure = null){
    return 'https://static.netders.com/' . trim($path, '/');
}

function txtLower($metin, $kod='UTF-8')
{
	$metin = trim($metin);

	if(Session::get('site_sl') == 'tr'){
		$ara = array('I');
		$deg = array('ı');

		$metin = str_replace($ara, $deg, $metin);
	}
	return mb_convert_case($metin, MB_CASE_LOWER, $kod);
}

function txtUpper($metin, $kod='UTF-8')
{
	$metin = trim($metin);

	if(Session::get('site_sl') == 'tr'){
		$ara = array('i');
		$deg = array('İ');

		$metin = str_replace($ara, $deg, $metin);
	}
	
	return mb_convert_case($metin, MB_CASE_UPPER, $kod);
}

function txtFirstUpper($metin, $kod='UTF-8'){
   mb_internal_encoding($kod);
   $mtn = trim($metin);
   $bas = mb_substr(txtUpper($mtn, $kod), 0, 1);
   $son = mb_substr(txtLower($mtn, $kod), 1);
   return $bas . $son;
}

function txtWordUpper($metin, $kod='UTF-8'){
   $mtn = explode(' ',$metin);
   foreach($mtn as $no => $klm) if($klm) $snc[] = txtFirstUpper($klm, $kod);
   if(is_array($snc)) return implode(' ',$snc);
}

function make_filter_link($type = null)
{
	$parameters = Request::all();
	foreach($parameters as $key => $value){
		if(strstr($key, 'sort_') == true){
			unset($parameters[$key]);
		}
	}
	$url = $parameters ? URL::current() . '?' . http_build_query($parameters, '', '&') : URL::current();
	$symb = $parameters ? '&' : '?';

	if($type){
		$ascdesc = Request::get($type) == 'asc' ? 'desc' : 'asc';
		return $url . $symb. $type . '=' . $ascdesc;
	} else {
		return $url;
	}
}

function teacher_profile_missing($user_id)
{
	$response = new stdClass;
	$response->total = 0;
	$response->profile = false;
	$response->prices = false;
	$response->locations = false;
	
	//Missing profile fields
	$user_detail = \App\Models\User_detail::where('user_id', $user_id)->first();
	if(!empty($user_detail))
	{
		if(!empty($user_detail->title) && !empty($user_detail->long_text))
		{
			$response->profile = true;
			$response->total += 1;
		}

		if(\App\Models\Price::where('user_id', $user_id)->count() > 0)
		{
			$response->prices = true;
			$response->total += 1;			
		}

		if(\App\Models\Location::where('user_id', $user_id)->count() > 0)
		{
			$response->locations = true;
			$response->total += 1;			
		}		
	}

	return $response;
    
}

function teacher_profile_completed()
{
	/*
	$response = [];
	$response['total'] = 0;
	$response['profile'] = $response['total'] += User::teacher_profile()->whereNotNull('title')->whereNotNull('text_long')->count() > 0 ? true : false;
	$response['prices'] = $response['total'] += User::teacher_prices()->count() > 0 ? true : false;
	$response['locations'] = $response['total'] += User::teacher_locations()->count() > 0 ? true : false;

	return $response;
	*/

	return $this->hasMany(\App\Models\Teacher::class);
}

function teacher_prices_text_completed()
{
	return false;
}

function webp_src($image_src)
{
	$path_parts = pathinfo($image_src);

	return url($path_parts['dirname'] . '/webp/' . $path_parts['filename'] . '.webp');
}

function content($id)
{
	
	return DB::table('contents')->where('id', $id)->value('description');
}

function user_fullname($firstname, $lastname, $lastname_privacy = 2)
{	
	$show_lastname = $lastname ? txtUpper(mb_substr($lastname, 0, 1, 'UTF-8')).'.' : '';

	if($lastname_privacy == 1)
	{
		$show_lastname = $lastname;
	}

	if($lastname_privacy == 2)
	{
		$show_lastname = 'Öğretmen';
	}

	return txtWordUpper($firstname . ' ' . $show_lastname);
}	

function truncate($data, $length){
	if(strlen($data) > $length){
		return mb_substr($data, 0, $length, 'UTF-8').'...';
	} else {
		return $data;
	}
}

function getIp() {
	dd($_SERVER);
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
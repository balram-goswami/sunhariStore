<?php

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
	Countries,
	States,
	Cities,
	Option,
	User,
	WalletCredit,
	WalletTransactions,
	Links,
	Terms,
	Posts,
	VisitorData,
	Category,
	Product,
	ProductCategory,
	ProductGallery,
	ProductTag,
	ProductVariation
};

function appName()
{
	return config('app.name');
}
function siteUrl()
{
	return 'http://127.0.0.1:8000/';
}
function publicPath($url = null)
{
	return asset($url);
}
function assetPath($url = null)
{
	return asset('assets/' . $url);
}
function publicbasePath()
{
	return '/public';
}
function basePath()
{
	return base_path('/public/');
}

function pagination($per_page = 20)
{
	return $per_page ?? 20;
}
function adminBasePath()
{
	return 'admin';
}

function CleanHtml($html = null)
{
	return preg_replace(
		array(
			'/ {2,}/',
			'/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
		),
		array(
			' ',
			''
		),
		$html
	);
}

function maybe_decode($original)
{
	if (is_serialized($original))
		return @unserialize($original);
	return $original;
}
function is_serialized($data, $strict = true)
{
	if (! is_string($data)) {
		return false;
	}
	$data = trim($data);
	if ('N;' == $data) {
		return true;
	}
	if (strlen($data) < 4) {
		return false;
	}
	if (':' !== $data[1]) {
		return false;
	}
	if ($strict) {
		$lastc = substr($data, -1);
		if (';' !== $lastc && '}' !== $lastc) {
			return false;
		}
	} else {
		$semicolon = strpos($data, ';');
		$brace     = strpos($data, '}');
		if (false === $semicolon && false === $brace)
			return false;
		if (false !== $semicolon && $semicolon < 3)
			return false;
		if (false !== $brace && $brace < 4)
			return false;
	}
	$token = $data[0];
	switch ($token) {
		case 's':
			if ($strict) {
				if ('"' !== substr($data, -2, 1)) {
					return false;
				}
			} elseif (false === strpos($data, '"')) {
				return false;
			}
		case 'a':
		case 'O':
			return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
		case 'b':
		case 'i':
		case 'd':
			$end = $strict ? '$' : '';
			return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
	}
	return false;
}

function maybe_encode($data)
{
	if (is_array($data) || is_object($data))
		return serialize($data);
	if (is_serialized($data, false))
		return serialize($data);
	return $data;
}

function fileuploadmultiple($request)
{
	$files = $request->file('attachments');
	$uploaded_file = [];
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	notExistsCreateDir($destinationPath);
	foreach ($files as $file) {
		$filename = str_replace(array(' ', '-', '`', ','), '_', time() . '_' . $file->getClientOriginalName());
		$upload_success = $file->move($destinationPath, $filename);
		$uploaded_file[] = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	}
	return $uploaded_file;
}
function fileupload($request)
{
	$file = $request->file('image');
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$filename = time() . '_' . $file->getClientOriginalName();
	$upload_success = $file->move($destinationPath, $filename);
	$uploaded_file = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	return $uploaded_file;
}
function fileuploadExtra($request, $key)
{
	$file = $request->file($key);
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$filename = time() . '_' . $file->getClientOriginalName();
	$upload_success = $file->move($destinationPath, $filename);
	$uploaded_file = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	return $uploaded_file;
}
function fileuploadArray($file)
{
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$filename = time() . '_' . $file->getClientOriginalName();
	$upload_success = $file->move($destinationPath, $filename);
	$uploaded_file = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	return $uploaded_file;
}
function fileuploadUrl($url)
{
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$data = str_replace('data:image/jpeg;base64,', '', $url);
	$data = str_replace(' ', '+', $data);
	$data = base64_decode($data); // Decode image using base64_decode
	$file = $destinationPath . '/' . uniqid() . '.jpeg'; // Now you can put this image data to your desired file using file_put_contents function like below:
	$success = file_put_contents($file, $data);
	return $file;
}
function fileuploadLink($url)
{
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$data = file_get_contents($url);
	$file = $destinationPath . '/' . uniqid() . '.jpeg';
	$success = file_put_contents($file, $data);
	return $file;
}
function notExistsCreateDir($destinationPath)
{
	if (!file_exists(public_path() . '/' . $destinationPath)) {
		mkdir(public_path() . '/' . $destinationPath);
	}
}
function randomPassword()
{
	return mt_rand(100000, 999999);
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

function getImgAltName($imgUrl)
{
	$postalt = Posts::select('post_name')->where('media', $imgUrl)->first();
	if ($postalt) {
		return $postalt->post_name;
	} else {
		return 'Image';
	}
}
function getApiCurrentUser()
{
	if (Request()->get('Authorization')) {
		request()->headers->set('Authorization', 'Bearer ' . Request()->get('Authorization'));
		return JWTAuth::parseToken()->authenticate();
	}
	if (Request()->header('Authorization')) {
		return JWTAuth::parseToken()->authenticate();
	}
	return new \App\Models\User();
}
function getCurrentUser()
{
	if (Auth::user()) {
		return Auth::user();
	}
	return new \App\Models\User();
}
function getCurrentUserByKey($key)
{
	$user = getApiCurrentUser();
	if (!empty($key)) {
		return isset($user->$key) ? $user->$key : 0;
	}
	return $user;
}
function getCurrentVisitor()
{
	$visitorIp = request()->ip();
	return VisitorData::where('ip_address', $visitorIp)->first();
}

function getUser($user_id)
{
	return DB::table('users')->where('user_id', $user_id)->select('*')->get()->first();
}

function createUuid($name = 'vendorP')
{
	return Uuid::generate(5, $name, Uuid::NS_DNS);
}
function getPercantageAmount($amount, $percent)
{
	return $amount / 100 * $percent;
}
function getDuration($date)
{
	$time = '';
	$t1 = \Carbon\Carbon::parse($date);
	$t2 = \Carbon\Carbon::parse();
	$diff = $t1->diff($t2);
	if ($diff->format('%y') != 0) {
		$time .= $diff->format('%y') . " Year ";
	}
	if ($diff->format('%m') != 0) {
		$time .= $diff->format('%m') . " Month ";
	}
	if ($diff->format('%d') && $diff->format('%m') == 0) {
		$time .= $diff->format('%d') . " Days ";
	}
	if ($diff->format('%h') != 0 && $diff->format('%m') == 0) {
		$time .= $diff->format('%h') . " Hours ";
	}
	if ($diff->format('%i') != 0 && $diff->format('%d') == 0) {
		$time .= $diff->format('%i') . " Minutes ";
	}
	if ($diff->format('%s') != 0 && $diff->format('%h') == 0) {
		$time .= $diff->format('%s') . " Seconds ";
	}
	return $time;
}
function getDays($startDate = null, $endDate = null)
{
	$time = '';
	$t1 = \Carbon\Carbon::parse($startDate);
	$t2 = \Carbon\Carbon::parse($endDate);
	$diff = $t1->diff($t2);
	return $diff->format('%d');
}
function addDays($date = null, $days = 0)
{
	$date = $date ?? date('Y-m-d');
	return date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
}
function minusDays($date = null, $days = 0)
{
	$date = $date ?? date('Y-m-d');
	return date('Y-m-d', strtotime('-' . $days . ' days', strtotime($date)));
}
function weekOfMonth($currentMonth)
{
	$stdate = $currentMonth . '-01';
	$enddate = $currentMonth . '-31'; //get end date of month
	$begin = new \DateTime('first day of ' . $stdate);
	$end = new \DateTime('last day of ' . $enddate);
	$interval = new \DateInterval('P1W');
	$daterange = new \DatePeriod($begin, $interval, $end);

	$dates = array();
	foreach ($daterange as $key => $date) {
		$check = ($date->format('W') != $end->modify('last day of this month')->format('W')) ? '+6 days' : 'last day of this week';
		$dates[$key + 1] = array(
			'start' => $date->format('Y-m-d'),
			'end' => ($date->modify($check)->format('Y-m-d')),
		);
		if ($dates[$key + 1]['end'] > date('Y-m-d', strtotime($enddate))) {
			$dates[$key + 1]['end'] = date('Y-m-d', strtotime($enddate));
		}
	}
	return $dates;
}
function datesRange($first, $last, $diffDays = 1, $output_format = 'd-m-Y')
{
	$step = '+' . $diffDays . ' day';
	$dates = array();
	$current = strtotime($first);
	$last = strtotime($last);

	while ($current <= $last) {

		$dates[] = date($output_format, $current);
		$current = strtotime($step, $current);
	}

	return $dates;
}
function getLatLong($address = null)
{
	$latLong = [];
	$latLong['lattitude'] = '';
	$latLong['longitude'] = '';
	if (!empty($address)) {
		$address = str_replace(" ", "+", $address);
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyCjEHaWgv-lmblYJ-m0fp3lwfrWrgzQEPE&address=" . urlencode($address) . "&sensor=false");
		$json = json_decode($json);
		if ($json->status == 'OK') {
			$latLong['lattitude'] = $json->results[0]->geometry->location->lat;
			$latLong['longitude'] = $json->results[0]->geometry->location->lng;
		}
	}
	return $latLong;
}
function address($user)
{
	$address = [];
	if (isset($user->address) && !empty($user->address)) {
		$address[] = $user->address;
	}
	if (isset($user->city) && !empty($user->city)) {
		$address[] = $user->city;
	}
	if (isset($user->state) && !empty($user->state)) {
		$address[] = $user->state;
	}
	if (isset($user->country) && !empty($user->country)) {
		$address[] = $user->country;
	}
	return implode(',', $address);
}
function bindAddress($user)
{
	$address = [];
	if (isset($user->address) && !empty($user->address)) {
		$address[] = $user->address;
	}
	if (isset($user->city) && !empty($user->city)) {
		$address[] = $user->city;
	}
	if (isset($user->state) && !empty($user->state)) {
		$address[] = $user->state;
	}
	if (isset($user->country) && !empty($user->country)) {
		$address[] = $user->country;
	}
	$address = implode(' ', $address);
	echo str_replace(" ", "+", $address);
}

function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if (isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
function ip_info($purpose = "location", $deep_detect = TRUE)
{
	$output = NULL;
	$ip = $_SERVER['REMOTE_ADDR'];
	if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
		$ip = $_SERVER["REMOTE_ADDR"];
		if ($deep_detect) {
			if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
	}
	$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
	$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
	$continents = array(
		"AF" => "Africa",
		"AN" => "Antarctica",
		"AS" => "Asia",
		"EU" => "Europe",
		"OC" => "Australia (Oceania)",
		"NA" => "North America",
		"SA" => "South America"
	);
	if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

		if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
			switch ($purpose) {
				case "location":
					$output = array(
						"city"           => @$ipdat->geoplugin_city,
						"state"          => @$ipdat->geoplugin_regionName,
						"country"        => @$ipdat->geoplugin_countryName,
						"country_code"   => @$ipdat->geoplugin_countryCode,
						"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
						"continent_code" => @$ipdat->geoplugin_continentCode
					);
					break;
				case "address":
					$address = array($ipdat->geoplugin_countryName);
					if (@strlen($ipdat->geoplugin_regionName) >= 1)
						$address[] = $ipdat->geoplugin_regionName;
					if (@strlen($ipdat->geoplugin_city) >= 1)
						$address[] = $ipdat->geoplugin_city;
					$output = implode(", ", array_reverse($address));
					break;
				case "city":
					$output = @$ipdat->geoplugin_city;
					break;
				case "state":
					$output = @$ipdat->geoplugin_regionName;
					break;
				case "region":
					$output = @$ipdat->geoplugin_regionName;
					break;
				case "country":
					$output = @$ipdat->geoplugin_countryName;
					break;
				case "countrycode":
					$output = @$ipdat->geoplugin_countryCode;
					break;
			}
		}
	}
	return $output;
}

if (!function_exists('getLocationFromIp')) {
    function getLocationFromIp($ip)
    {
        if ($ip === "127.0.0.1" || $ip === "::1") {
            $ip = "8.8.8.8";
        }

        $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city");
        $data = @json_decode($response, true);

        if ($data && $data['status'] === 'success') {
            return trim(($data['city'] ?? '') . ', ' .
                        ($data['regionName'] ?? '') . ', ' .
                        ($data['country'] ?? ''), ', ');
        }

        return "Unknown";
    }
}

function getSettings()
{
	$settingQs = \App\Models\Settings::select('key', 'value')->get();
	$settings = [];
	foreach ($settingQs as $setting) {
		$settings[$setting->key] = maybe_decode($setting->value);
	}
	global $settings;
}

//getSettings();

function calculateDaysAccTime($days, $start_time, $end_time)
{
	$start_time_h = strtotime($start_time);
	$end_time_h = strtotime($end_time);
	if ($end_time_h < $start_time_h) {
		$end_time_h += 24 * 60 * 60;
	}
	$total_min = ($end_time_h - $start_time_h) / 60;
	if ($total_min < 300) {
		$days = $days / 2;
	}
	return $days;
}
function dateTime()
{
	return date('Y-m-d H:i:s');
}
function dateFormat($date)
{
	return date('F d Y', strtotime($date));
}
function dateTimeFormat($date)
{
	return date('F d Y h:i A', strtotime($date));
}
function timeFormat($date)
{
	return date('h:i A', strtotime($date));
}

function userTypes()
{
	return [
		User::ADMIN => 'Admin',
		User::USER => 'User'
	];
}
function daysName()
{
	return [
		'monday' => 'Monday',
		'tuesday' => 'Tuesday',
		'wednesday' => 'Wednesday',
		'thursday' => 'Thursday',
		'friday' => 'Friday',
		'saturday' => 'Saturday',
		'sunday' => 'Sunday'
	];
}

function priceFormat($price)
{
	return '$ ' . number_format($price, 2);
}

// function priceFormat($number)
// {
// 	return '$ ' . number_format($number, 2);
// }
function itemShowPrice($menuItem)
{
	/*if ($menuItem->item_is == 'Attributes') {
        return \App\MenuItemAttributes::join('menu_attributes','menu_attributes.menu_attr_id','menu_item_attributes.menu_attr_id')
            ->where('menu_item_id', $menuItem->menu_item_id)
            ->where('menu_attributes.attr_main_choice', 1)
            ->select('menu_item_attributes.attr_name as item_attr_name','menu_item_attributes.attr_price', 'menu_item_attributes.item_attr_id','menu_attributes.attr_name as menu_attr_name','menu_attributes.attr_type')
            ->orderBy('attr_price', 'ASC')
            ->get()->pluck('attr_price')->first();
    }*/
	$delivery_pickup_address = Session::get('delivery_pickup_address');
	$slot = (isset($delivery_pickup_address['slot']) ? $delivery_pickup_address['slot'] : '');
	$order_type = (isset($delivery_pickup_address['order_type']) ? $delivery_pickup_address['order_type'] : '');
	$item_for = json_decode($menuItem->item_for);
	$extraPrice = 0;
	if ($order_type == 'Pickup') {
		$extraPrice = (isset($item_for->$slot->pickup_price) ? $item_for->$slot->pickup_price : 0);
	} else {
		$extraPrice = (isset($item_for->$slot->delivery_price) ? $item_for->$slot->delivery_price : 0);
	}
	$price = $menuItem->item_price;
	if ($menuItem->item_sale_price) {
		$price = $menuItem->item_sale_price;
	}
	$discountPrice = $price;
	if ($menuItem->item_discount_start <= date('Y-m-d') && $menuItem->item_discount_end >= date('Y-m-d')) {
		$discount = ($price * $menuItem->item_discount / 100);
		$discountPrice = $price - $discount;
	}
	return $discountPrice + $extraPrice;
}
function genders()
{
	return [
		'male' => 'Male',
		'female' => 'Female'
	];
}
function filterData(&$str)
{
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}
function getCountryName($countryId)
{
	return Countries::where('id', $countryId)->get()->pluck('name')->first();
}
function getStateName($stateId)
{
	return States::where('id', $stateId)->get()->pluck('name')->first();
}
function getCityName($cityId)
{
	return Cities::where('id', $cityId)->get()->pluck('name')->first();
}
function getMenus()
{
	return [
		// Admin
		[
			'title' => 'Dashboard',
			'route' => 'dashboard.index',
			'icon' => 'tf-icons bx bx-home-circle',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Users',
			'route' => 'users.index',
			'icon' => 'menu-icon tf-icons bx bx-group',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Media',
			'route' => 'media.index',
			'icon' => 'menu-icon tf-icons bx bxs-file-image',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Settings',
			'route' => 'themes.index',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Subscribers',
			'route' => 'subscribers.index',
			'icon' => 'tf-icons bx bx-envelope',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Requests and Queries',
			'route' => 'feedbacks.index',
			'icon' => 'tf-icons bx bx-envelope',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Menus',
			'route' => 'menus',
			'icon' => 'tf-icons bx bx-list-ul',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Visitors',
			'route' => 'visitor',
			'icon' => 'tf-icons bx bx-show',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Product',
			'route' => null,
			'icon' => 'tf-icons bx bxs-vector',
			'role' => [User::ADMIN],
			'childs' => [
				[
					'title' => 'View',
					'route' => 'products.index',
				],
				[
					'title' => 'Add',
					'route' => 'products.create',
				],
				[
					'title' => 'Category',
					'route' => 'category.index',
				],
				[
					'title' => 'Tag',
					'route' => 'tags.index',
				],
				[
					'title' => 'Variations',
					'route' => 'variations.index',
				],
				[
					'title' => 'Orders',
					'route' => 'orders.index',
				]
			]
		],

		// Customer
		[
			'title' => 'Dashboard',
			'route' => 'customer.index',
			'icon' => 'tf-icons bx bx-home-circle',
			'role' => [User::USER],
		],
		[
			'title' => 'My Profile',
			'route' => 'customerProfile',
			'icon' => 'tf-icons bx bx-user',
			'role' => [User::USER],
		],
		[
			'title' => 'My Orders',
			'route' => 'customerOrders',
			'icon' => 'tf-icons bx bx-cart',
			'role' => [User::USER],
		],

	];
}
function postTypes()
{
	return [
		'page' => [
			'area' => 'Admin',
			'title' => 'Page',
			'icon' => 'tf-icons bx bx-book-content',
			'slug' => 'page',
			'role' => [User::ADMIN],
			'showMenu' => true,
			'multilng' => false,
			'support' => ['content', 'excerpt', 'seo', 'featured'],
			'templateOption' => [
				'PostDefault' => 'Default Template',
				'AboutUs' => 'About US Template',
				'ContactUs' => 'Contact US Template',
				'Blogs' => 'All Blog Template',
				'Services' => 'Our Services Page',
				'Faqs' => 'Faqs Template',
				'Testimonial' => 'Testimonial Template',
				'PolicyPage' => 'Policy Page',
				'Shop' => 'Shop Page Template',
				'ThankYou' => 'ThankYou Page',
			],
			'taxonomy' => []
		],

		'blog' => [
			'area' => 'Admin',
			'title' => 'Blog',
			'icon' => 'tf-icons bx bxl-blogger',
			'slug' => 'blog',
			'role' => [User::ADMIN],
			'showMenu' => true,
			'multilng' => false,
			'support' => ['excerpt', 'seo', 'featured', 'content'],
			'templateOption' => [
				'SingleBlog' => 'Default Template',
			],
			'taxonomy' => [
				'category' => [
					'title' => 'Category',
					'slug' => 'category',
					'showMenu' => true,
					'showPost' => [],
					'hasVariations' => false
				],
				'tag' => [
					'title' => 'Tags',
					'slug' => 'tag',
					'showMenu' => true,
					'showPost' => [],
					'hasVariations' => false
				],
			]
		],

		'tagManager' => [
			'area' => 'Admin',
			'title' => 'Tag Manager',
			'icon' => 'tf-icons bx bx-purchase-tag-alt',
			'slug' => 'tagManager',
			'role' => [User::ADMIN],
			'showMenu' => false,
			'multilng' => false,
			'support' => [],
			'templateOption' => [
				'PostDefault' => 'Default Template',
			],
			'taxonomy' => []
		],

		'slider' => [
			'area' => 'Admin',
			'title' => 'Sliders',
			'icon' => 'tf-icons bx bx-slideshow',
			'slug' => 'slider',
			'role' => [User::ADMIN],
			'showMenu' => true,
			'multilng' => false,
			'support' => ['featured',],
			'templateOption' => [
				'PostDefault' => 'Default Template',
			],
			'taxonomy' => []
		],

		'coupon' => [
			'area' => 'Admin',
			'title' => 'Coupon',
			'icon' => 'tf-icons bx bx-purchase-tag',
			'slug' => 'coupon',
			'role' => [User::ADMIN],
			'showMenu' => false,
			'multilng' => false,
			'support' => [],
			'templateOption' => [
				'PostDefault' => 'Default Template',
			],
			'taxonomy' => []
		],


	];
}
function getPostsByPostTypebyTerm($postType = null, $limit = 0, $order_by = '', $extraFields = false, $pagination = false, $faqCategoryId = null)
{
	if ($limit == 0) {
		$limit = pagination();
	}
	$orderColumn = 'posts.menu_order';
	$orderBy = 'ASC';
	if ($order_by == 'new') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'DESC';
	} else if ($order_by == 'old') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'ASC';
	} else if ($order_by == 'order') {
		$orderColumn = 'posts.menu_order';
		$orderBy = 'ASC';
	}
	$posts = \App\Models\Posts::where('posts.post_type', $postType)
		->leftJoin('posts as getImage', 'getImage.post_id', 'posts.guid')
		->leftJoin('users as user', 'user.user_id', 'posts.user_id')
		->select('posts.*', 'getImage.media as post_image', 'user.name as user_name', 'getImage.post_title as post_image_alt')
		->where('posts.post_status', 'publish')
		->where(function ($query) use ($faqCategoryId) {
			if ($faqCategoryId) {
				$termIDs = \App\Models\Terms::where('id', $faqCategoryId)->pluck('id')->toArray();
				$termRelations = \App\Models\TermRelations::whereIn('term_id', $termIDs)->pluck('object_id')->toArray();
				$query->whereIn('posts.post_id', $termRelations);
			}
		})
		->orderBy($orderColumn, $orderBy);
	if ($pagination == true) {
		$posts = $posts->paginate($limit);
	} else {
		$posts = $posts->limit($limit)->get();
	}
	if (!$extraFields) {
		return $posts;
	}
	foreach ($posts as &$post) {
		$postTypes = getPostType($post->post_type);
		$post->extraFields = getPostMeta($post->post_id);
		$post->posted_date = date('M d, Y', strtotime($post->created_at));
		$post->posted_time = date('h:i A', strtotime($post->created_at));
		$termRelations = \App\Models\TermRelations::where('object_id', $post->post_id)->select('term_id');
		if (!empty($postTypes['taxonomy'])) {
			$termsSelected = [];
			foreach ($postTypes['taxonomy'] as $key => $value) {
				$termsSelected[$key] = \App\Models\Terms::whereIn('id', $termRelations)->where('term_group', $key)->get();
			}
			$post->category = $termsSelected;
		}
		$postedComments = \App\Models\Comment::where('post_id', $post->post_id)->where('comment_approved', 1)->get();
		foreach ($postedComments as &$postedComment) {
			$postedComment->rating = getCommentMeta($postedComment->comment_ID, 'comment_rating');
		}
		$post->postedComments = $postedComments;
	}
	return $posts;
}
function getPostsByPostType($postType = null, $limit = 0, $order_by = '', $extraFields = false, $pagination = false)
{
	if ($limit == 0) {
		$limit = pagination();
	}
	$orderColumn = 'posts.menu_order';
	$orderBy = 'ASC';
	if ($order_by == 'new') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'DESC';
	} else if ($order_by == 'old') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'ASC';
	} else if ($order_by == 'order') {
		$orderColumn = 'posts.menu_order';
		$orderBy = 'ASC';
	}
	$posts = \App\Models\Posts::where('posts.post_type', $postType)
		->leftJoin('posts as getImage', 'getImage.post_id', 'posts.guid')
		->leftJoin('users as user', 'user.user_id', 'posts.user_id')
		->select('posts.*', 'getImage.media as post_image', 'user.name as user_name', 'getImage.post_title as post_image_alt')
		->where('posts.post_status', 'publish')
		->where(function ($query) {
			if (request()->get('term')) {
				$termIDs = \App\Models\Terms::where('slug', request()->get('term'))->pluck('id')->toArray();
				$termRelations = \App\Models\TermRelations::whereIn('term_id', $termIDs)->pluck('object_id')->toArray();
				$query->whereIn('posts.post_id', $termRelations);
			}
		})
		->orderBy($orderColumn, $orderBy);
	if ($pagination == true) {
		$posts = $posts->paginate($limit);
	} else {
		$posts = $posts->limit($limit)->get();
	}
	if (!$extraFields) {
		return $posts;
	}
	foreach ($posts as &$post) {
		$postTypes = getPostType($post->post_type);
		$post->extraFields = getPostMeta($post->post_id);
		$post->posted_date = date('M d, Y', strtotime($post->created_at));
		$post->posted_time = date('h:i A', strtotime($post->created_at));
		$termRelations = \App\Models\TermRelations::where('object_id', $post->post_id)->select('term_id');
		if (!empty($postTypes['taxonomy'])) {
			$termsSelected = [];
			foreach ($postTypes['taxonomy'] as $key => $value) {
				$termsSelected[$key] = \App\Models\Terms::whereIn('id', $termRelations)->where('term_group', $key)->get();
			}
			$post->category = $termsSelected;
		}
		$postedComments = \App\Models\Comment::where('post_id', $post->post_id)->where('comment_approved', 1)->get();
		foreach ($postedComments as &$postedComment) {
			$postedComment->rating = getCommentMeta($postedComment->comment_ID, 'comment_rating');
		}
		$post->postedComments = $postedComments;
	}
	return $posts;
}
function getTerms($termGroup = null, $postType = null, $limit = 3)
{
	$terms = \App\Models\Terms::where('term_group', $termGroup)
		->where('post_type', $postType)
		->limit($limit)
		->get();
	foreach ($terms as $term) {
		$term->category_icon = getTermMeta($term->id, 'category_icon');
	}
	return $terms;
}
function getPostType($postType = null)
{
	$posts = postTypes();
	if (isset($posts[$postType]) && !empty($posts[$postType])) {
		return (isset($posts[$postType]) ? $posts[$postType] : '');
	}
	return;
}
function getTaxonomyType($postType = null, $taxonomy = null)
{
	$posts = postTypes();
	if (isset($posts[$postType]) && !empty($posts[$postType])) {
		if (isset($posts[$postType]['taxonomy'][$taxonomy]['title'])) {
			return ($posts[$postType]['taxonomy'][$taxonomy]['title']);
		}
	}
	return;
}
function getTaxonomyArray($postType = null, $taxonomy = null)
{
	$posts = postTypes();
	if (isset($posts[$postType]) && !empty($posts[$postType])) {
		if (isset($posts[$postType]['taxonomy'][$taxonomy])) {
			return ($posts[$postType]['taxonomy'][$taxonomy]);
		}
	}
	return;
}
function getPostTypeByTax($taxonomy = null)
{
	$posts = postTypes();
	foreach ($posts as $postKey => $postValue) {
		if (isset($postValue['taxonomy'][$taxonomy])) {
			return $postValue['slug'];
		}
	}
	return;
}
function getTermSlugByTax($taxonomy = null)
{
	$posts = postTypes();
	foreach ($posts as $postKey => $postValue) {
		if (isset($postValue['taxonomy'][$taxonomy])) {
			return $postValue['taxonomy'][$taxonomy]['slug'];
		}
	}
	return;
}
function getTermTaxBySlug($taxonomy = null)
{
	$posts = postTypes();
	foreach ($posts as $postKey => $postValue) {
		if (isset($postValue['taxonomy']) && is_array($postValue['taxonomy'])) {
			foreach ($postValue['taxonomy'] as $key => $value) {
				if (isset($value['slug']) && $value['slug'] == $taxonomy) {
					return $key;
				}
			}
		}
	}
	return;
}

/*****post meta action******/
function addPostMetaBox($post_type,  $post_id)
{
	$postBoxHtml = '';
	switch ($post_type) {
		case 'post':
			$postBoxHtml = postPostMetaBox($post_id);
			break;
		case 'testimonials':
			$postBoxHtml = postTestimonialsMetaBox($post_id);
			break;
		case 'page':
			$postBoxHtml = postPageMetaBox($post_id);
			break;
		case 'tagManager':
			$postBoxHtml = posttagManagerMetaBox($post_id);
			break;
		case 'products':
			$postBoxHtml = postproductsMetaBox($post_id);
			break;
		case 'coupon':
			$postBoxHtml = postcouponMetaBox($post_id);
			break;
		case 'slider':
			$postBoxHtml = postsliderMetaBox($post_id);
			break;
		default:
			$postBoxHtml = '';
			break;
	}
	echo $postBoxHtml;
}
function insertUpdatePostMetaBox($post_type, $request, $post_id)
{
	switch ($post_type) {
		case 'post':
			insertUpdatePostPostMetaBox($request, $post_id);
			break;
		case 'testimonials':
			insertUpdateTestimonialsPostMetaBox($request, $post_id);
			break;
		case 'page':
			insertUpdatePagePostMetaBox($request, $post_id);
			break;
		case 'tagManager':
			insertUpdatetagManagerPostMetaBox($request, $post_id);
			break;
		case 'products':
			insertUpdateproductsPostMetaBox($request, $post_id);
			break;
		case 'coupon':
			insertUpdatecouponPostMetaBox($request, $post_id);
			break;
		case 'slider':
			insertUpdatesliderPostMetaBox($request, $post_id);
			break;
		default:
			return;
			break;
	}
}

/*****Post post meta action******/
function postPostMetaBox($post_id)
{
	ob_start();
?>

<?php
	return ob_get_clean();
}
function insertUpdatePostPostMetaBox($request, $post_id) {}

/**products post meta action***/
function postproductsMetaBox($post_id)
{
	ob_start();
?>
	<br>
	<div class="input-group row">
		<h5 style="color: red;">Product Details</h5>
		<div class="col-md-4">
			<label class="col-form-label" for="sku">SKU*</label><br>
			<input type="text" name="sku" id="sku" class="form-control form-control-lg" placeholder="SKU" value="<?php echo getPostMeta($post_id, 'sku') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-4">
			<label class="col-form-label" for="stock_quantity">Stock Quantity</label><br>
			<input type="text" name="stock_quantity" id="stock_quantity" class="form-control form-control-lg" placeholder="Stock Quantity" value="<?php echo getPostMeta($post_id, 'stock_quantity') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-4">
			<label class="col-form-label" for="price_regular">Regular price (INR ₹)*</label><br>
			<input required type="text" name="price_regular" id="price_regular" class="form-control form-control-lg" placeholder="Regular price (INR ₹)" value="<?php echo getPostMeta($post_id, 'price_regular') ?>">
			<span class="md-line"></span>
		</div>
	</div>
	<br>
	<div class="input-group row">
		<h5 style="color: red;">Product Multiple Images (Size:- 500x500px)</h5>
		<div class="col-md-3 imageUploadGroup">
			<label class="col-form-label" for="img_1">Image</label><br>
			<img src="<?php echo publicPath(getPostMeta($post_id, 'img_1')) ?>" id="img_1-img" style="width: 100%;height: 200px;">
			<button type="button" data-eid="img_1" class="btn btn-success setFeaturedImage">Select image</button>
			<button type="button" data-eid="img_1" class="btn btn-warning removeFeaturedImage">Remove image</button>
			<input type="hidden" name="img_1" id="img_1" value="<?php echo getPostMeta($post_id, 'img_1') ?>">
		</div>
		<div class="col-md-3 imageUploadGroup">
			<label class="col-form-label" for="img_2">Image</label><br>
			<img src="<?php echo publicPath(getPostMeta($post_id, 'img_2')) ?>" id="img_2-img" style="width: 100%;height: 200px;">
			<button type="button" data-eid="img_2" class="btn btn-success setFeaturedImage">Select image</button>
			<button type="button" data-eid="img_2" class="btn btn-warning removeFeaturedImage">Remove image</button>
			<input type="hidden" name="img_2" id="img_2" value="<?php echo getPostMeta($post_id, 'img_2') ?>">
		</div>
		<div class="col-md-3 imageUploadGroup">
			<label class="col-form-label" for="img_3">Image</label><br>
			<img src="<?php echo publicPath(getPostMeta($post_id, 'img_3')) ?>" id="img_3-img" style="width: 100%;height: 200px;">
			<button type="button" data-eid="img_3" class="btn btn-success setFeaturedImage">Select image</button>
			<button type="button" data-eid="img_3" class="btn btn-warning removeFeaturedImage">Remove image</button>
			<input type="hidden" name="img_3" id="img_3" value="<?php echo getPostMeta($post_id, 'img_3') ?>">
		</div>
		<div class="col-md-3 imageUploadGroup">
			<label class="col-form-label" for="img_4">Image</label><br>
			<img src="<?php echo publicPath(getPostMeta($post_id, 'img_4')) ?>" id="img_4-img" style="width: 100%;height: 200px;">
			<button type="button" data-eid="img_4" class="btn btn-success setFeaturedImage">Select image</button>
			<button type="button" data-eid="img_4" class="btn btn-warning removeFeaturedImage">Remove image</button>
			<input type="hidden" name="img_4" id="img_4" value="<?php echo getPostMeta($post_id, 'img_4') ?>">
		</div>
	</div>
	<br>
	<div class="input-group row">
		<h5 style="color: red;">Sale Details</h5>
		<div class="col-md-12">
			<label class="col-form-label" for="sale_regular">Sale price (INR ₹)</label><br>
			<input type="text" name="sale_regular" id="sale_regular" class="form-control form-control-lg" placeholder="Sale price (INR ₹)" value="<?php echo getPostMeta($post_id, 'sale_regular') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="sale_start_date">Sale start Date</label><br>
			<input type="date" name="sale_start_date" id="sale_start_date" class="form-control form-control-lg" placeholder="Sale start Date" value="<?php echo getPostMeta($post_id, 'sale_start_date') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="sale_end_date">Sale End Date</label><br>
			<input type="date" name="sale_end_date" id="sale_end_date" class="form-control form-control-lg" placeholder="Sale End Date" value="<?php echo getPostMeta($post_id, 'sale_end_date') ?>">
			<span class="md-line"></span>
		</div>
	</div>
	<br>
	<div class="input-group row">
		<h5 style="color: red;">Tax Details</h5>
		<div class="col-md-6">
			<label class="col-form-label" for="tax_status">Tax Status</label><br>
			<select name="tax_status" id="tax_status" class="form-control form-control-lg">
				<option value="non_taxable" <?php echo (getPostMeta($post_id, 'tax_status') == 'non_taxable') ? 'selected' : ''; ?>>None</option>
				<option value="taxable" <?php echo (getPostMeta($post_id, 'tax_status') == 'taxable') ? 'selected' : ''; ?>>Taxable</option>
				<option value="shipping_only" <?php echo (getPostMeta($post_id, 'tax_status') == 'shipping_only') ? 'selected' : ''; ?>>Shipping Only</option>
			</select>
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="tax_class">Tax Class</label><br>
			<select name="tax_class" id="tax_class" class="form-control form-control-lg">
				<option value="standerd" <?php echo (getPostMeta($post_id, 'tax_class') == 'standerd') ? 'selected' : ''; ?>>Standers</option>
				<option value="reduce_rate" <?php echo (getPostMeta($post_id, 'tax_class') == 'reduce_rate') ? 'selected' : ''; ?>>Reduce Rate</option>
				<option value="zero_rate" <?php echo (getPostMeta($post_id, 'tax_class') == 'zero_rate') ? 'selected' : ''; ?>>Zero Rate</option>
			</select>
			<span class="md-line"></span>
		</div>
	</div>

	<script>
		document.querySelector('form').addEventListener('submit', function(event) {
			var startDate = document.getElementById('sale_start_date').value;
			var endDate = document.getElementById('sale_end_date').value;

			if (startDate && endDate && startDate >= endDate) {
				event.preventDefault(); // Prevent form submission
				alert("Sale start date must be less than the sale end date.");
			}
		});
	</script>
<?php
	return ob_get_clean();
}
function insertUpdateproductsPostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'sku', $request->sku);
	updatePostMeta($post_id, 'stock_quantity', $request->stock_quantity);
	updatePostMeta($post_id, 'price_regular', $request->price_regular);
	updatePostMeta($post_id, 'img_1', $request->img_1);
	updatePostMeta($post_id, 'img_2', $request->img_2);
	updatePostMeta($post_id, 'img_3', $request->img_3);
	updatePostMeta($post_id, 'img_4', $request->img_4);
	updatePostMeta($post_id, 'sale_regular', $request->sale_regular);
	updatePostMeta($post_id, 'sale_start_date', $request->sale_start_date);
	updatePostMeta($post_id, 'sale_end_date', $request->sale_end_date);
	updatePostMeta($post_id, 'tax_status', $request->tax_status);
	updatePostMeta($post_id, 'tax_class', $request->tax_class);
}

function postcouponMetaBox($post_id)
{
	ob_start();
?>
	<br>
	<div class="input-group row">
		<h5 style="color: red;">Coupon Details</h5>
		<div class="col-md-6">
			<label class="col-form-label" for="coupon_type">Coupon Type</label><br>
			<select name="coupon_type" id="coupon_type" class="form-control form-control-lg">
				<option value="percentage" <?php echo (getPostMeta($post_id, 'coupon_type') == 'percentage') ? 'selected' : ''; ?>>Percentage</option>
				<option value="flatDiscount" <?php echo (getPostMeta($post_id, 'coupon_type') == 'flatDiscount') ? 'selected' : ''; ?>>Flat Discount</option>
			</select>
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="discount_amount">Coupon Amount</label><br>
			<input type="text" name="discount_amount" id="discount_amount" class="form-control form-control-lg" placeholder="Sale start Date" value="<?php echo getPostMeta($post_id, 'discount_amount') ?>">
			<span class="md-line"></span>
		</div>
	</div>
<?php
	return ob_get_clean();
}
function insertUpdatecouponPostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'coupon_type', $request->coupon_type);
	updatePostMeta($post_id, 'discount_amount', $request->discount_amount);
}

/** Slider area */
function postsliderMetaBox($post_id)
{
	ob_start();
	$links = getPostsByPostType('page', 0, 'new',  true, true);
	?>

	<br>
	<div class="col-md-11">
		<label class="col-form-label" for="slider_text">Slider Text</label><br>
		<input type="text" name="slider_text" id="slider_text" class="form-control form-control-lg" 
			placeholder="Sale start Date" 
			value="<?php echo htmlspecialchars(getPostMeta($post_id, 'slider_text')) ?>">
		<span class="md-line"></span>
	</div>

	<br>
	<div class="input-group row">
		<h5 style="color: red;">Button Details</h5>

		<div class="col-md-6">
			<label class="col-form-label" for="button_text">Button Text</label><br>
			<input type="text" name="button_text" id="button_text" class="form-control form-control-lg" 
				placeholder="Sale Button Text" 
				value="<?php echo htmlspecialchars(getPostMeta($post_id, 'button_text')) ?>">
			<span class="md-line"></span>
		</div>

		<div class="col-md-6">
			<label class="col-form-label" for="button_link">Button Link</label><br>
			<select name="button_link" id="button_link" class="form-control form-control-lg">
				<?php 
				$current_link = getPostMeta($post_id, 'button_link');
				foreach ($links as $link) { 
					$selected = ($current_link == $link->post_name) ? 'selected' : '';
				?>
					<option value="<?php echo $link->post_name ?>" <?php echo $selected; ?>>
						<?php echo $link->post_title ?>
					</option>
				<?php } ?>
			</select>
			<span class="md-line"></span>
		</div>
	</div>

	<?php
	return ob_get_clean();
}

function insertUpdatesliderPostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'slider_text', $request->slider_text ?? '');
	updatePostMeta($post_id, 'button_text', $request->button_text ?? '');
	updatePostMeta($post_id, 'button_link', $request->button_link ?? '');
}


/*****Post Page action******/
function postpageMetaBox($post_id)
{
	ob_start();

?>

<?php
	return ob_get_clean();
}

function insertUpdatepagePostMetaBox($request, $post_id) {}

// Post Testimonials action 
function postTestimonialsMetaBox($post_id)
{
	ob_start();
?>
	<div class="input-group row">
		<label class="col-form-label" for="link">Youtube URL Link</label><br>
		<input type="text" name="link" id="link" class="form-control form-control-lg" placeholder="Short Text" value="<?php echo getPostMeta($post_id, 'link') ?>">
		<span class="md-line"></span>
	</div>
<?php
	return ob_get_clean();
}
function insertUpdateTestimonialsPostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'link', $request->link);
}

/*****Post post Tag Manager action******/
function posttagManagerMetaBox($post_id)
{
	ob_start();
?>
	<div class="input-group row">
		<label class="col-form-label" for="head">Header code</label><br>
		<textarea name="head" id="head" class="form-control form-control-lg" placeholder="Head Tag" value="<?php echo getPostMeta($post_id, 'head') ?>"> </textarea>
		<span class="md-line"></span>
	</div>
	<div class="input-group row">
		<label class="col-form-label" for="bodytag">body code ( if any )</label><br>
		<textarea name="bodytag" id="bodytag" class="form-control form-control-lg" placeholder="Body Tag" value="<?php echo getPostMeta($post_id, 'bodytag') ?>"></textarea>
		<span class="md-line"></span>
	</div>
<?php
	return ob_get_clean();
}
function insertUpdatetagManagerPostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'head', $request->head);
	updatePostMeta($post_id, 'bodytag', $request->bodytag);
}


function updatePostMeta($post_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($post_id) && empty($meta_key)) {
		return;
	}
	if ($postMeta = \App\Models\PostMetas::where('post_id', $post_id)->where('meta_key', $meta_key)->get()->first()) {
		$postMeta->meta_value = maybe_encode($meta_value);
		$postMeta->updated_at = new DateTime;
		$postMeta->save();
	} else {
		$postMeta = new \App\Models\PostMetas;
		$postMeta->post_id = $post_id;
		$postMeta->meta_key = $meta_key;
		$postMeta->meta_value = maybe_encode($meta_value);
		$postMeta->created_at = new DateTime;
		$postMeta->updated_at = new DateTime;
		$postMeta->save();
	}
	return $post_id;
}

function getPostMeta($post_id = null, $meta_key = null)
{
	if (empty($post_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\PostMetas::where('post_id', $post_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$postMetas = \App\Models\PostMetas::where('post_id', $post_id)->select('meta_key', 'meta_value')->get()->toArray();
		$postMetasData = [];
		foreach ($postMetas as &$postMeta) {
			$postMetasData[$postMeta['meta_key']] = maybe_decode($postMeta['meta_value']);
			unset($postMeta['meta_key']);
			unset($postMeta['meta_value']);
		}
		return $postMetasData;
	}
}

function updateTermMeta($term_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($term_id) && empty($meta_key)) {
		return;
	}
	if ($termMeta = \App\Models\TermMetas::where('term_id', $term_id)->where('meta_key', $meta_key)->get()->first()) {
		$termMeta->meta_value = maybe_encode($meta_value);
		$termMeta->updated_at = new DateTime;
		$termMeta->save();
	} else {
		$termMeta = new \App\Models\TermMetas;
		$termMeta->term_id = $term_id;
		$termMeta->meta_key = $meta_key;
		$termMeta->meta_value = maybe_encode($meta_value);
		$termMeta->created_at = new DateTime;
		$termMeta->updated_at = new DateTime;
		$termMeta->save();
	}
	return $term_id;
}
function getTermMeta($term_id = null, $meta_key = null)
{
	if (empty($term_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\TermMetas::where('term_id', $term_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$termMetas = \App\Models\TermMetas::where('term_id', $term_id)->select('meta_key', 'meta_value')->get()->toArray();
		foreach ($termMetas as &$termMeta) {
			$termMeta[$termMeta['meta_key']] = maybe_decode($termMeta['meta_value']);
			unset($termMeta['meta_key']);
			unset($termMeta['meta_value']);
		}
		return $termMetas;
	}
}
/*****term meta action******/
function addTermMetaBox($registerTerm,  $term_id)
{
	$termBoxHtml = '';
	switch ($registerTerm) {
		case 'category':
			$termBoxHtml = categoryTermMetaBox($term_id);
			break;
		default:
			$termBoxHtml = '';
			break;
	}
	echo $termBoxHtml;
}
function insertUpdateTermMetaBox($taxonomy, $request, $term_id)
{
	switch ($taxonomy) {
		case 'category':
			return insertcategoryTermMetaBox($request, $term_id);
			break;
		default:
			return;
			break;
	}
}
function categoryTermMetaBox($term_id)
{
?>
	<div class="input-group row">
		<label class="col-form-label" for="category_icon>">Icon</label><br>
		<input type="text" name="category_icon" id="category_icon" class="form-control form-control-lg" placeholder="Icon" value="<?php echo getTermMeta($term_id, 'category_icon') ?>">
		<span class="md-line"></span>
	</div>
<?php
}
function insertcategoryTermMetaBox($request, $term_id)
{
	updateTermMeta($term_id, 'category_icon', $request->category_icon);
}
/***** Comment Meta********/
function getCommentMeta($comment_id = null, $meta_key = null)
{
	if (empty($comment_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\CommentMeta::where('comment_id', $comment_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$commentMetas = \App\Models\CommentMeta::where('comment_id', $comment_id)->select('meta_key', 'meta_value')->get()->toArray();
		$commentMetasData = [];
		foreach ($commentMetas as &$commentMeta) {
			$commentMetasData[$commentMeta['meta_key']] = maybe_decode($commentMeta['meta_value']);
			unset($commentMeta['meta_key']);
			unset($commentMeta['meta_value']);
		}
		return $commentMetasData;
	}
}

function updateCommentMeta($comment_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($comment_id) && empty($meta_key)) {
		return;
	}
	if ($commentMeta = \App\Models\CommentMeta::where('comment_id', $comment_id)->where('meta_key', $meta_key)->get()->first()) {
		$commentMeta->meta_value = maybe_encode($meta_value);
		$commentMeta->updated_at = new DateTime;
		$commentMeta->save();
	} else {
		$commentMeta = new \App\Models\CommentMeta;
		$commentMeta->comment_id = $comment_id;
		$commentMeta->meta_key = $meta_key;
		$commentMeta->meta_value = maybe_encode($meta_value);
		$commentMeta->created_at = new DateTime;
		$commentMeta->updated_at = new DateTime;
		$commentMeta->save();
	}
	return $comment_id;
}
/***** User Meta********/
function getUserMeta($user_id = null, $meta_key = null)
{
	if (empty($user_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\UserMetas::where('user_id', $user_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$userMetas = \App\Models\UserMetas::where('user_id', $user_id)->select('meta_key', 'meta_value')->get()->toArray();
		$userMetasData = [];
		foreach ($userMetas as &$userMeta) {
			$userMetasData[$userMeta['meta_key']] = maybe_decode($userMeta['meta_value']);
			unset($userMeta['meta_key']);
			unset($userMeta['meta_value']);
		}
		return $userMetasData;
	}
}

function updateUserMeta($user_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($user_id) && empty($meta_key)) {
		return;
	}
	if ($userMeta = \App\Models\UserMetas::where('user_id', $user_id)->where('meta_key', $meta_key)->get()->first()) {
		$userMeta->meta_value = maybe_encode($meta_value);
		$userMeta->updated_at = new DateTime;
		$userMeta->save();
	} else {
		$userMeta = new \App\Models\UserMetas;
		$userMeta->user_id = $user_id;
		$userMeta->meta_key = $meta_key;
		$userMeta->meta_value = maybe_encode($meta_value);
		$userMeta->created_at = new DateTime;
		$userMeta->updated_at = new DateTime;
		$userMeta->save();
	}
	return $user_id;
}
function registerNavBarMenu()
{
	return [
		'primary_menu' => 'Primary Menu',
		'footer_menu' => 'Footer Menu'
	];
}
function createUpdateSiteMapXML($postUrl)
{
    $postUrl = str_replace('in//', 'in/', $postUrl);
    $sitemapPath = base_path('public/sitemap.xml');

    if (!file_exists($sitemapPath)) {
        // create a new sitemap if it doesn't exist
        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
        file_put_contents($sitemapPath, $xmlContent);
    }

    $xmlObjects = simplexml_load_file($sitemapPath);

    $xmlRow = '';
    $existRow = false;
    if (!empty($xmlObjects->url)) {
        foreach ($xmlObjects->url as $xmlObject) {
            if ((string)$xmlObject->loc == $postUrl) {
                $existRow = true;
                $xmlRow .= '<url>
                    <loc>' . $xmlObject->loc . '</loc>
                    <lastmod>' . date('c', time()) . '</lastmod>
                    <priority>' . $xmlObject->priority . '</priority>
                </url>';
            } else {
                $xmlRow .= '<url>
                    <loc>' . $xmlObject->loc . '</loc>
                    <lastmod>' . $xmlObject->lastmod . '</lastmod>
                    <priority>' . $xmlObject->priority . '</priority>
                </url>';
            }
        }
    }
    if (!$existRow) {
        $xmlRow .= '<url>
            <loc>' . $postUrl . '</loc>
            <lastmod>' . date('c', time()) . '</lastmod>
            <priority>0.5</priority>
        </url>';
    }

    $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        ' . $xmlRow . '
    </urlset>';

    $dom = new \DOMDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xmlContent);
    $dom->save($sitemapPath);
}

function deleteSiteMapXML($postUrl)
{
    $postUrl = str_replace('in//', 'in/', $postUrl);
    $sitemapPath = base_path('public/sitemap.xml');

    if (!file_exists($sitemapPath)) {
        return; // no sitemap to modify
    }

    $xmlObjects = simplexml_load_file($sitemapPath);

    $xmlRow = '';
    if (!empty($xmlObjects->url)) {
        foreach ($xmlObjects->url as $xmlObject) {
            if ((string)$xmlObject->loc != $postUrl) {
                $xmlRow .= '<url>
                    <loc>' . $xmlObject->loc . '</loc>
                    <lastmod>' . $xmlObject->lastmod . '</lastmod>
                    <priority>' . $xmlObject->priority . '</priority>
                </url>';
            }
        }
    }

    $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        ' . $xmlRow . '
    </urlset>';

    $dom = new \DOMDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xmlContent);
    $dom->save($sitemapPath);
}

function getInnerChildMenu($menuOptions, $menufor)
{
	$menus = [];
	foreach ($menuOptions as $menuOption) {
		if (in_array($menuOption->target_type, ['page'])) {
			$menuOption->target_type = '';
		}
		if (in_array($menuOption->target_type, ['post'])) {
			$menuOption->target_type = 'blog';
		}
		if (in_array($menuOption->target_type, ['category', 'tag'])) {
			$menuOption->link_target = 'blog';
		}
		if (in_array($menuOption->link_target, ['post'])) {
			$menuOption->link_target = '';
		}
		if (in_array($menuOption->target_type, ['gallery_category'])) {
			$menuOption->link_target = 'gallery';
			$menuOption->target_type = 'gallery-category';
		}
		$childMenuOptions = Links::where('link_visible', 'Y')->where('link_parent', $menuOption->id)->where('links.link_rel', $menufor)->orderBy('link_order', 'ASC')->get();
		$menus[] = [
			'link_name' => $menuOption->link_name,
			'link_url' => ($menuOption->link_target ? '/' . $menuOption->link_target . '/' . $menuOption->target_type : ($menuOption->target_type ? '/' . $menuOption->target_type : '')) . '/' . $menuOption->link_url,
			'childMenus' => getInnerChildMenu($childMenuOptions, $menufor)
		];
	}
	return $menus;
}
function hasSubChild($menus)
{
	$hasSubChild = false;
	if (is_array($menus)) {
		foreach ($menus as $menu) {
			if (count($menu['childMenus']) > 0) {
				$hasSubChild = true;
			}
		}
	}
	return $hasSubChild;
}


/*Get all products*/

function getProducts()
{
	return Product::with('variations')->paginate(pagination());
}
function getProductCategories()
{
	return Category::whereHas('products')->limit(10)->get();
}

function generateUniqueSlug($name, $id = null)
{
	$slug = Str::slug($name);
	$count = Product::where('slug', 'LIKE', "{$slug}%")->when($id, function ($query) use ($id) {
		return $query->where('id', '!=', $id); // Ignore current product if updating
	})->count();

	return $count ? "{$slug}-" . ($count + 1) : $slug;
}
function getProductSortBy()
{
	return [
		'featured' => 'Featured',
		'best-selling' => 'Best selling',
		'title-ascending' => 'Alphabetically, A-Z',
		'title-descending' => 'Alphabetically, Z-A',
		'price-ascending' => 'Price, low to high',
		'price-descending' => 'Price, high to low',
		'created-ascending' => 'Date, old to new',
		'created-descending' => 'Date, new to old'
	];
}
function getProductPrice($product)
{
	if ($product->type == "simple") {
		// Check if the sale price is valid and within the sale period
		if (
			$product->sale_price > 0 &&
			$product->sale_price < $product->main_price &&
			isSaleActive($product->sale_start_date, $product->sale_end_date)
		) {
			return $product->sale_price;
		} else {
			return $product->main_price;
		}
	} else {
		return getVariableProductPrice($product);
	}
}

function getProductDisplayPrice($product, $productSetting)
{
	$currency = (isset($productSetting['currency']) ? $productSetting['currency'] : '$');
	if ($product->type == "simple") {
		if (
			$product->sale_price > 0 &&
			$product->sale_price < $product->main_price &&
			isSaleActive($product->sale_start_date, $product->sale_end_date)
		) {
			return "<del>{$currency} {$product->main_price}</del> <strong>{$currency} {$product->sale_price}</strong>";
		} else {
			return "<strong>{$currency} {$product->main_price}</strong>";
		}
	} else {
		return getVariableProductDisplayPrice($product, $currency);
	}
}

// Get min & max price from variations
function getVariableProductPrice($product)
{
	$minPrice = $product->variations()->min('sale_price') ?? $product->variations()->min('main_price');
	$maxPrice = $product->variations()->max('main_price');

	if ($minPrice == $maxPrice) {
		return number_format($minPrice, 2);
	}
	return number_format($maxPrice, 2);
}

// Display formatted variable product price
function getVariableProductDisplayPrice($product, $currency)
{
	$minPrice = $product->variations()->min('sale_price') ?? $product->variations()->min('main_price');
	$maxPrice = $product->variations()->max('main_price');

	if ($minPrice == $maxPrice) {
		return "<span class='price'>" . $currency . " " . number_format($minPrice, 2) . "</span>";
	}
	if ($minPrice > 0) {
		return "<span class='price'>" . $currency . " " . number_format($minPrice, 2) . " - " . $currency . " " . number_format($maxPrice, 2) . "</span>";
	}
	return "<span class='price'>" . $currency . " " . number_format($maxPrice, 2) . "</span>";
}

// Display formatted variable product price
function getVariationDisplayPrice($variation, $currency)
{
	$minPrice = $variation->sale_price;
	$maxPrice = $variation->main_price;

	if ($minPrice == $maxPrice) {
		return "<span class='price'>" . $currency . " " . number_format($minPrice, 2) . "</span>";
	}
	if (
		$minPrice > 0 &&
		isSaleActive($variation->sale_start_date, $variation->sale_end_date)
	) {
		return "<del>" . $currency . " " . number_format($maxPrice, 2) . " </del><strong> " . $currency . " " . number_format($minPrice, 2) . "</strong>";
	}
	return "<span class='price'>" . $currency . " " . number_format($maxPrice, 2) . "</span>";
}

// Display formatted variable product price
function getVariationPrice($variation)
{
	$minPrice = $variation->sale_price;
	$maxPrice = $variation->main_price;

	if ($minPrice == $maxPrice) {
		return $minPrice;
	}
	if ($minPrice > 0 && isSaleActive($variation->sale_start_date, $variation->sale_end_date)) {
		return $minPrice;
	}
	return $maxPrice;
}

// Helper function to check if the sale is active
function isSaleActive($start_date, $end_date)
{
	$currentDate = date('Y-m-d');

	return (!$start_date || $currentDate >= $start_date) &&
		(!$end_date || $currentDate <= $end_date);
}
function getCurrencyList()
{
	return [
		'$'  => 'USD',
		'€'  => 'EUR',
		'£'  => 'GBP',
		'₹'  => 'INR',
		'A$' => 'AUD',
		'C$' => 'CAD',
		'CHF' => 'CHF',
		'¥'  => 'CNY/JPY',
		'₽'  => 'RUB',
		'R$' => 'BRL',
		'R'  => 'ZAR',
		'Mex$' => 'MXN',
		'₩'  => 'KRW',
		'S$' => 'SGD',
		'NZ$' => 'NZD',
		'HK$' => 'HKD',
		'₺'  => 'TRY',
		'د.إ' => 'AED',
		'ر.س' => 'SAR',
		'฿'  => 'THB',
		'Rp' => 'IDR',
		'RM' => 'MYR',
		'₱'  => 'PHP',
		'₫'  => 'VND',
		'E£' => 'EGP',
		'₦'  => 'NGN',
		'₨'  => 'PKR',
		'৳'  => 'BDT',
	];
}

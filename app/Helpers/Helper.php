<?php

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
	Product,
	SiteSetting
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
function siteSetting()
{
	$siteData = SiteSetting::first();

	return $siteData;
}


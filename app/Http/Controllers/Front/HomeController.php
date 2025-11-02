<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use App\Models\{Product, SiteSetting, Slider, CustomerAddress, Order};

use Illuminate\Support\Facades\Http;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect, Cart;

class HomeController extends Controller
{

  public function homePage()
  {
    $view = "Templates.Home";
    $products = Product::where('status', 2)->orderBy('id', 'desc')->get();
    $slider = Slider::where('status', 1)->get(); 

    $data = siteSetting();
    $breadcrumbs = [
      'title' => $data->meta_title ?? 'Sunhari',
      'metaTitle' => $data->meta_title ?? 'Sunhari',
      'metaDescription' => $data->meta_description ?? 'Sunhari -  Where Tradition Shines',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    return view('Front', compact('view', 'products', 'breadcrumbs', 'slider'));
  }

  public function profile()
  {
    $userData = Auth::user();

    $addresses = CustomerAddress::where('customer_id', $userData->id)->get();
    $orders = Order::where('customer_id', $userData->id)->get();

    $breadcrumbs = [
      'title' => $data->meta_title ?? 'Sunhari',
      'metaTitle' => $data->meta_title ?? 'Sunhari',
      'metaDescription' => $data->meta_description ?? 'Sunhari -  Where Tradition Shines',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    $view = "Templates.Profile";

    return view('Front', compact('view', 'userData', 'breadcrumbs', 'addresses', 'orders'));
  }

  public function contuctUs()
  {
    $view = "Templates.ContactUs";
    $contact = SiteSetting::first();
    $breadcrumbs = [
      'title' => $data->meta_title ?? 'Sunhari',
      'metaTitle' => $data->meta_title ?? 'Sunhari',
      'metaDescription' => $data->meta_description ?? 'Sunhari -  Where Tradition Shines',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    return view('Front', compact('view', 'contact', 'breadcrumbs'));
  }

  public function aboutUs()
  {
    $view = "Templates.AboutUs";
    $breadcrumbs = [
      'title' => $data->meta_title ?? 'Sunhari',
      'metaTitle' => $data->meta_title ?? 'Sunhari',
      'metaDescription' => $data->meta_description ?? 'Sunhari -  Where Tradition Shines',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    return view('Front', compact('view', 'breadcrumbs'));
  }

  public function terms()
  {
    $view = "Templates.Terms";
    $breadcrumbs = [
      'title' => $data->meta_title ?? 'Sunhari',
      'metaTitle' => $data->meta_title ?? 'Sunhari',
      'metaDescription' => $data->meta_description ?? 'Sunhari -  Where Tradition Shines',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    return view('Front', compact('view', 'breadcrumbs'));
  }

  public function returnRefund()
  {
    $view = "Templates.Return-refund";
    $breadcrumbs = [
      'title' => $data->meta_title ?? 'Sunhari',
      'metaTitle' => $data->meta_title ?? 'Sunhari',
      'metaDescription' => $data->meta_description ?? 'Sunhari -  Where Tradition Shines',
      'metaKeyword' => '',
      'links' => [
        ['url' => url('/'), 'title' => 'Home']
      ]
    ];

    return view('Front', compact('view', 'breadcrumbs'));
  }

}

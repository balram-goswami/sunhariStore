<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;
use JWTAuth;

use App\Services\{
    CommonService,
    OrderService
};

class OrderController extends Controller
{
    protected $commonService;
    protected $orderService;
    public function __construct(
        CommonService $commonService,
        OrderService $orderService
    ) {
        $this->commonService = $commonService;
        $this->orderService = $orderService;
    }
    public function doOrder(Request $request)
    {
        $this->orderService->store($request);
        Session::forget('cart');
        Session::flash('success', 'Product removed from cart');
        return redirect()->route('thank.you');
    }


    public function thankyou()
    {
        $breadcrumbs = [
            'title' => 'Thank you',
            'metaTitle' => 'Thank you',
            'metaDescription' => 'Thank you',
            'metaKeyword' => 'Thank you',
            'links' => [
                ['url' => url('/'), 'title' => 'Home']
            ]
        ];
        $view = 'Templates.ThankYou';
        return view('Front', compact('view', 'breadcrumbs'));
    }

    
}

<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Oseintow\Shopify\Shopify;

class ShopifyAuthController extends Controller
{
	/**
	 * @var Shopify
	 */
	private $shopify;

	public function __construct(Shopify $shopify)
	{
		$this->shopify = $shopify;
	}

	public function install()
	{
		Session::put('store', request('store_url'));

		$shopify = $this->shopify->setShopUrl(request('store_url'));

		return redirect()->to($shopify->getAuthorizeUrl(['read_orders'], route('auth.callback')));
	}

	public function callback()
	{
		if (!Session::has('store')) {
			return redirect()->route('home')->with('error', 'You need to click install first.');
		}
		$storeUrl = Session::get('store');

		$accessToken = $this->shopify->setShopUrl($storeUrl)->getAccessToken(request('code'));

		$store               = new Store;
		$store->store        = $storeUrl;
		$store->access_token = $accessToken;
		$store->save();

		Session::forget('store');

		return redirect()->route('home')->with('success', 'Successfully installed app.');
	}
}

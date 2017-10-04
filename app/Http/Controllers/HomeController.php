<?php

namespace App\Http\Controllers;

use App\Store;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;

class HomeController extends Controller
{


	/**
	 * Show the application dashboard.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$queryString = $request->getQueryString() ?? [];
		//dd($queryString);
		if ($request->has('shop') && $request->has('hmac')) {
			if (Shopify::verifyRequest($queryString) && Store::where('store', $request->shop)->first()) {
				return redirect('/store?' . $queryString);
			}
		}

		return view('home');
	}

	public
	function store()
	{
		dd('hi');
	}
}

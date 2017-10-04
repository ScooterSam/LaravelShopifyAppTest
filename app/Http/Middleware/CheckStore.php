<?php

namespace App\Http\Middleware;

use App\Store;
use Closure;
use Oseintow\Shopify\Facades\Shopify;

class CheckStore
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$queryString = $request->getQueryString() ?? [];

		if (!$request->has('hmac') || !$request->has('shop')) {
			return redirect()->route('home')->with('error', 'You cannot view the store with this link.');
		}

		if (!Shopify::verifyRequest($queryString)) {
			return redirect()->route('home')->with('error', 'Failed to verify.');
		}

		if (!Store::where('store', $request->shop)->first()) {
			return redirect()->route('home')->with('error', 'Please register the store.');
		}

		return $next($request);
	}
}

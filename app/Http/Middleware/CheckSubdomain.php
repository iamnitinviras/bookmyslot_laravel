<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $product = $request->route('product');
        // Check if the subdomain exists in the database
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect()->to(config('app.url'));
        }
        return $next($request);
    }
}

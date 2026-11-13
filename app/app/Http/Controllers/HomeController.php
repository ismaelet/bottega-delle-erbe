<?php

namespace App\Http\Controllers;

use App\Services\ProductCatalog;
use App\Services\PublicNavigation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(PublicNavigation $navigation, ProductCatalog $catalog): View
    {
        $products = DB::table('items')
            ->where('status', 1)
            ->where('hidden', 0)
            ->whereNotIn('type', DB::table('items_types')->select('tag')->where('category', 'herb'))
            ->orderByDesc('id')
            ->limit(20)
            ->get(['id', 'name', 'type', 'price']);

        $catalog->decorate($products);

        $highlightedProduct = DB::table('items')->where('id', 413)->first(['id', 'name', 'price']);

        if (! $highlightedProduct) {
            Log::warning('The highlighted legacy product is missing.', ['item_id' => 413]);
        }

        return view('home', [
            'menus' => $navigation->menus(),
            'products' => $products,
            'highlightedProduct' => $highlightedProduct,
            'posts' => DB::table('posts')->orderByDesc('time')->limit(6)->get(),
        ]);
    }
}

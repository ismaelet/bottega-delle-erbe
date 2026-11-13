<?php

namespace App\Http\Controllers;

use App\Services\ProductCatalog;
use App\Services\PublicNavigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(Request $request, PublicNavigation $navigation, ProductCatalog $catalog): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:30'],
            'type' => ['nullable', 'string', 'max:3'],
            'use' => ['nullable', 'string', 'max:3'],
            'sort' => ['nullable', 'in:new,pop'],
        ]);
        $search = trim($filters['search'] ?? '');
        $type = $filters['type'] ?? '';
        $use = $filters['use'] ?? '';
        $sort = $filters['sort'] ?? 'pop';
        $types = DB::table('items_types')->where('category', 'product')->orderBy('id')->get();
        $uses = DB::table('items_uses')->orderBy('id')->get();

        if (! $types->contains('tag', $type)) {
            $type = '';
        }
        if (! $uses->contains('tag', $use)) {
            $use = '';
        }

        $query = DB::table('items')
            ->where('status', 1)
            ->whereIn('type', DB::table('items_types')->select('tag')->where('category', 'product'));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhereIn('type', DB::table('items_types')->select('tag')->where(function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%')->orWhere('names', 'like', '%'.$search.'%');
                    }));
            });
        }
        if ($type !== '') {
            $query->where('type', $type);
        }
        if ($use !== '') {
            $query->where('uses', 'like', '%'.$use.'%');
        }
        if ($sort === 'new') {
            $query->orderByDesc('id');
        } else {
            $query->orderByDesc('rsales')->orderByDesc('sales')->orderBy('name');
        }

        $products = $query->paginate(40)->withQueryString();
        $catalog->decorate($products->getCollection());

        return view('shop.index', [
            'menus' => $navigation->menus(),
            'products' => $products,
            'types' => $types,
            'uses' => $uses,
            'search' => $search,
            'type' => $type,
            'use' => $use,
            'sort' => $sort,
        ]);
    }

    public function listing(PublicNavigation $navigation): View
    {
        return view('shop.list', [
            'menus' => $navigation->menus(),
            'products' => DB::table('items')->whereIn('type', DB::table('items_types')->select('tag')->where('category', 'product'))->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function product(Request $request, PublicNavigation $navigation, ProductCatalog $catalog): View|RedirectResponse
    {
        $id = $request->query('id');
        if (! is_string($id) || ! ctype_digit($id)) {
            return redirect('/shop');
        }

        $product = DB::table('items')->where('id', $id)->first();
        if (! $product) {
            return redirect('/shop');
        }

        $catalog->decorate(collect([$product]));

        return view('shop.product', [
            'menus' => $navigation->menus(),
            'product' => $product,
        ]);
    }

    public function herbs(PublicNavigation $navigation): View
    {
        $categories = DB::table('items_types')->where('category', 'herb')->orderBy('id')->get();
        $items = DB::table('items')->whereIn('type', $categories->pluck('tag'))->get()->groupBy('type');

        return view('shop.herbs', [
            'menus' => $navigation->menus(),
            'categories' => $categories,
            'items' => $items,
        ]);
    }
}

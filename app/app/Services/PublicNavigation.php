<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PublicNavigation
{
    public function menus(): array
    {
        $products = DB::table('items_types')->where('category', 'product')->orderBy('id')->get();
        $uses = DB::table('items_uses')->orderBy('id')->get();
        $herbs = DB::table('items_types')->where('category', 'herb')->orderBy('id')->get();

        return [
            'shop' => [
                'size' => 4,
                'categories' => $products->map(function ($type) {
                    $query = DB::table('items')->where('type', $type->tag);
                    $items = (clone $query)->orderBy('name')->limit(7)->get(['id', 'name']);
                    $link = '/shop?'.http_build_query(['type' => $type->tag]);

                    return [
                        'title' => $type->names,
                        'link' => $link,
                        'items' => $items,
                        'more' => $query->count() > 7,
                    ];
                }),
                'link' => '/shop/list',
            ],
            'uses' => [
                'size' => 6,
                'categories' => $uses->map(function ($use) {
                    $query = DB::table('items')->where('uses', 'like', '%'.$use->tag.'%');
                    $items = (clone $query)->orderBy('name')->limit(5)->get(['id', 'name']);
                    $link = '/shop?'.http_build_query(['use' => $use->tag]);

                    return [
                        'title' => $use->name,
                        'link' => $link,
                        'items' => $items,
                        'more' => $query->count() > 5,
                    ];
                }),
                'link' => '/shop/list',
            ],
            'herbs' => [
                'size' => 5,
                'categories' => $herbs->map(fn ($type) => [
                    'title' => $type->names,
                    'link' => '/herbs#'.rawurlencode($type->tag),
                    'items' => collect(),
                    'more' => true,
                ]),
                'link' => null,
            ],
        ];
    }
}

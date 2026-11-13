<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    config([
        'database.default' => 'sqlite',
        'database.connections.sqlite.url' => null,
        'database.connections.sqlite.database' => ':memory:',
    ]);
    DB::purge('sqlite');

    Schema::create('variables', function (Blueprint $table) {
        $table->string('name');
        $table->string('value');
    });
    Schema::create('items_types', function (Blueprint $table) {
        $table->increments('id');
        $table->string('tag');
        $table->string('name');
        $table->string('names');
        $table->string('category');
    });
    Schema::create('items_uses', function (Blueprint $table) {
        $table->increments('id');
        $table->string('tag');
        $table->string('name');
    });
    Schema::create('items', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('type');
        $table->string('uses')->default('');
        $table->decimal('price', 8, 2);
        $table->string('tech')->default('');
        $table->text('info')->default('');
        $table->text('methods')->default('');
        $table->text('ingredients')->default('');
        $table->text('warnings')->default('');
        $table->integer('sales')->default(0);
        $table->integer('rsales')->default(0);
        $table->boolean('status')->default(true);
        $table->boolean('hidden')->default(false);
    });
    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('text');
        $table->boolean('cover');
        $table->timestamp('time');
    });
    Schema::create('courses', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('text');
        $table->string('schedule');
    });
    DB::table('variables')->insert(['name' => 'public', 'value' => '1']);
    DB::table('items_types')->insert([
        ['tag' => 'int', 'name' => 'Integratore', 'names' => 'Integratori', 'category' => 'product'],
        ['tag' => 'her', 'name' => 'Pianta', 'names' => 'Piante', 'category' => 'herb'],
    ]);
});

test('the landing page displays recent visible products and news from the legacy tables', function () {
    for ($i = 1; $i <= 22; $i++) {
        DB::table('items')->insert(['id' => $i, 'name' => 'Prodotto '.$i, 'type' => 'int', 'price' => '12.30']);
    }
    DB::table('items')->insert(['id' => 413, 'name' => 'Prodotto in evidenza', 'type' => 'int', 'price' => '19.90']);
    DB::table('items')->insert(['id' => 414, 'name' => 'Pianta esclusa', 'type' => 'her', 'price' => '5.00']);
    DB::table('items')->insert(['id' => 415, 'name' => 'Prodotto nascosto', 'type' => 'int', 'price' => '5.00', 'hidden' => true]);
    DB::table('items')->insert(['id' => 416, 'name' => 'Prodotto inattivo', 'type' => 'int', 'price' => '5.00', 'status' => false]);
    for ($i = 1; $i <= 7; $i++) {
        DB::table('posts')->insert(['title' => 'Notizia '.$i, 'text' => 'Testo', 'cover' => 1, 'time' => sprintf('2024-01-%02d 12:00:00', $i)]);
    }

    $this->get('/')->assertOk()
        ->assertViewHas('products', fn ($products) => $products->count() === 20
            && $products->first()->id === 413
            && $products->last()->id === 4
            && str_ends_with($products->last()->image, '/legacy/app/resources/images/items/int.png'))
        ->assertViewHas('posts', fn ($posts) => $posts->count() === 6 && $posts->first()->title === 'Notizia 7')
        ->assertSee('Prodotto in evidenza')
        ->assertSee('19,90 €')
        ->assertSee('Storia')
        ->assertSee("L'acquisto online non è ancora disponibile.", false);
});

test('the landing page handles a missing highlighted product and honors offline mode', function () {
    $this->get('/')->assertOk()->assertViewHas('highlightedProduct', null);

    DB::table('variables')->where('name', 'public')->update(['value' => '0']);
    $this->get('/')->assertRedirect('/offline');
});

test('courses list the newest five and show an empty message when appropriate', function () {
    $this->get('/courses')->assertOk()->assertSee('Al momento non ci sono corsi attivi.');

    for ($i = 1; $i <= 6; $i++) {
        DB::table('courses')->insert(['title' => 'Corso '.$i, 'text' => 'Descrizione', 'schedule' => 'Lunedì']);
    }
    $this->get('/courses')->assertOk()
        ->assertViewHas('courses', fn ($courses) => $courses->count() === 5 && $courses->first()->id === 6)
        ->assertSee('storage/courses/6_m.jpg');
    $this->get('/courses?page=2')->assertOk()->assertSee('Corso 1');
});

test('a course shows details and four other courses, and invalid ids redirect', function () {
    for ($i = 1; $i <= 6; $i++) {
        DB::table('courses')->insert(['title' => 'Corso '.$i, 'text' => 'Descrizione', 'schedule' => 'Lunedì']);
    }
    $this->get('/courses/course?id=1')->assertOk()
        ->assertSee('Corso 1')
        ->assertSeeInOrder(['Corso 6', 'Corso 5', 'Corso 4', 'Corso 3'])
        ->assertDontSee('Corso 2')
        ->assertSee('storage/courses/1.jpg');
    $this->get('/courses/course')->assertRedirect('/courses');
    $this->get('/courses/course?id[]=1')->assertRedirect('/courses');
    $this->get('/courses/course?id=999')->assertRedirect('/courses');
});

test('the shop filters and sorts products and retains filters across pages', function () {
    DB::table('items_uses')->insert(['tag' => 'ost', 'name' => 'Articolazioni']);
    DB::table('items_types')->insert(['tag' => 'pom', 'name' => 'Pomata', 'names' => 'Pomate', 'category' => 'product']);
    for ($i = 1; $i <= 42; $i++) {
        DB::table('items')->insert(['name' => 'Articolo '.sprintf('%02d', $i), 'type' => 'int', 'uses' => 'ost', 'price' => '12.30', 'rsales' => $i]);
    }
    DB::table('items')->insert([
        ['name' => 'Altra tipologia', 'type' => 'pom', 'uses' => '', 'price' => 5, 'status' => 1],
        ['name' => 'Pianta', 'type' => 'her', 'uses' => 'ost', 'price' => 5, 'status' => 1],
        ['name' => 'Inattivo', 'type' => 'int', 'uses' => 'ost', 'price' => 5, 'status' => 0],
    ]);

    $this->get('/shop?type=int&use=ost&sort=pop')->assertOk()
        ->assertViewHas('products', fn ($products) => $products->total() === 42 && $products->first()->name === 'Articolo 42')
        ->assertSee('type=int', false)
        ->assertDontSee('Inattivo');
    $this->get('/shop?type=int&use=ost&sort=new&page=2')->assertOk()
        ->assertViewHas('products', fn ($products) => $products->count() === 2 && $products->first()->name === 'Articolo 02');
    $this->get('/shop?search=Pomate')->assertOk()
        ->assertViewHas('products', fn ($products) => $products->total() === 1 && $products->first()->name === 'Altra tipologia');
    $this->get('/shop?search='.urlencode("' OR 1=1 --"))->assertOk()
        ->assertViewHas('products', fn ($products) => $products->isEmpty());
});

test('product pages and the alphabetical list use legacy items safely', function () {
    DB::table('items')->insert([
        ['id' => 1, 'name' => 'Aloe', 'type' => 'int', 'price' => '12.30', 'info' => 'Descrizione', 'methods' => 'Uso', 'status' => 1],
        ['id' => 2, 'name' => 'Betulla', 'type' => 'int', 'price' => 5, 'info' => '', 'methods' => '', 'status' => 0],
        ['id' => 3, 'name' => 'Camomilla', 'type' => 'her', 'price' => 6, 'info' => '', 'methods' => '', 'status' => 1],
    ]);

    $this->get('/shop/list')->assertOk()->assertSeeInOrder(['Aloe', 'Betulla'])->assertDontSee('Camomilla');
    foreach (['/shop/item?id=1', '/item?id=1'] as $url) {
        $this->get($url)->assertOk()->assertSee('Aloe')->assertSee('12,30')->assertSee('Descrizione')->assertSee('Uso');
    }
    $this->get('/item?id[]=1')->assertRedirect('/shop');
    $this->get('/item?id=999')->assertRedirect('/shop');
});

test('herbs show their legacy category and details while purchasing is unavailable', function () {
    DB::table('items')->insert(['name' => 'Camomilla', 'type' => 'her', 'price' => '6.50', 'info' => 'Pianta']);

    $this->get('/herbs')->assertOk()->assertSee('Piante')->assertSee('Camomilla')
        ->assertSee('Pianta')->assertSee('6,50')->assertSee('in etti')
        ->assertSee("L'acquisto online non è ancora disponibile.", false);
});

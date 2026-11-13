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
    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('text');
        $table->boolean('cover');
        $table->timestamp('time');
    });
    Schema::create('items_types', function (Blueprint $table) {
        $table->increments('id');
        $table->string('tag');
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
        $table->string('uses');
    });
    DB::table('variables')->insert(['name' => 'public', 'value' => '1']);
});

test('news lists legacy posts newest first in pages of twelve', function () {
    for ($i = 1; $i <= 13; $i++) {
        DB::table('posts')->insert([
            'id' => $i,
            'title' => 'Notizia '.$i,
            'text' => 'Testo',
            'cover' => 1,
            'time' => sprintf('2024-01-%02d 12:00:00', $i),
        ]);
    }

    DB::table('items_types')->insert(['tag' => 'tea', 'names' => 'Tisane', 'category' => 'product']);
    DB::table('items_uses')->insert(['tag' => 'rel', 'name' => 'Relax']);
    DB::table('items')->insert(['name' => 'Camomilla', 'type' => 'tea', 'uses' => 'rel']);

    $this->get('/blog')->assertOk()
        ->assertSeeInOrder(['Notizia 13', 'Notizia 12'])
        ->assertDontSee('Notizia 1</h1>', false)
        ->assertSee('Tisane')
        ->assertSee('Camomilla')
        ->assertSee('Relax')
        ->assertSee('storage/blog/13_m.jpg');

    $this->get('/blog?page=2')->assertOk()->assertSee('Notizia 1</h1>', false)->assertDontSee('Notizia 13');
});

test('news article shows the selected post and three latest other posts', function () {
    for ($i = 1; $i <= 5; $i++) {
        DB::table('posts')->insert([
            'id' => $i,
            'title' => 'Notizia '.$i,
            'text' => $i === 1 ? '<script>alert(1)</script>' : 'Testo',
            'cover' => 0,
            'time' => sprintf('2024-01-%02d 12:00:00', $i),
        ]);
    }

    $this->get('/blog/post?id=1')->assertOk()
        ->assertSee('Notizia 1')
        ->assertSeeInOrder(['Notizia 5', 'Notizia 4', 'Notizia 3'])
        ->assertDontSee('Notizia 2')
        ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
        ->assertSee('storage/blog/1.jpg');
});

test('missing or invalid news ids redirect to the listing', function () {
    $this->get('/blog/post')->assertRedirect('/blog');
    $this->get('/blog/post?id=invalid')->assertRedirect('/blog');
    $this->get('/blog/post?id=123')->assertRedirect('/blog');
    $this->get('/blog/post?id[]=1')->assertRedirect('/blog');
});

test('news routes honor the legacy offline setting', function () {
    $this->get('/offline')->assertRedirect('/');
    $this->post('/offline')->assertRedirect('/');

    DB::table('variables')->where('name', 'public')->update(['value' => '0']);

    $this->get('/blog')->assertRedirect('/offline');
    $this->get('/blog/post?id=1')->assertRedirect('/offline');
    $this->get('/offline')->assertOk()->assertSee('Sito Offline');
    $this->post('/offline')->assertRedirect('/login');
});

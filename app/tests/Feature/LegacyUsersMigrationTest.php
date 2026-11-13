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
});

test('the starter migration preserves existing legacy users on migration and rollback', function () {
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('username');
        $table->string('mail');
    });

    DB::table('users')->insert(['id' => 1, 'username' => 'existing', 'mail' => 'existing@example.test']);

    $migration = require database_path('migrations/0001_01_01_000000_create_users_table.php');
    $migration->up();

    expect(DB::table('users')->where('id', 1)->value('username'))->toBe('existing');
    expect(Schema::hasColumn('users', 'mail'))->toBeTrue();
    expect(Schema::hasColumn('users', 'email'))->toBeFalse();
    expect(Schema::hasTable('sessions'))->toBeTrue();
    expect(Schema::hasTable('password_reset_tokens'))->toBeTrue();

    $migration->down();

    expect(DB::table('users')->where('id', 1)->value('mail'))->toBe('existing@example.test');
    expect(Schema::hasTable('sessions'))->toBeFalse();
    expect(Schema::hasTable('password_reset_tokens'))->toBeFalse();
});

test('the starter migration does not create a replacement users table', function () {
    $migration = require database_path('migrations/0001_01_01_000000_create_users_table.php');
    $migration->up();

    expect(Schema::hasTable('users'))->toBeFalse();
});

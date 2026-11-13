<?php

use App\Filament\Auth\AdminLogin;
use App\Models\AdminUser;
use Filament\Facades\Filament;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;

beforeEach(function () {
    config([
        'database.default' => 'sqlite',
        'database.connections.sqlite.url' => null,
        'database.connections.sqlite.database' => ':memory:',
    ]);
    DB::purge('sqlite');

    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('username')->default('');
        $table->string('mail')->default('');
        $table->string('password')->default('');
        $table->boolean('guest')->default(false);
        $table->integer('admin')->default(0);
    });
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

test('only legacy administrators can enter the panel', function () {
    DB::table('users')->insert([
        ['username' => 'manager', 'mail' => 'manager@example.org', 'password' => Hash::make('secret'), 'guest' => 0, 'admin' => 2],
        ['username' => 'user', 'mail' => 'user@example.org', 'password' => Hash::make('secret'), 'guest' => 0, 'admin' => 0],
        ['username' => 'guest', 'mail' => 'guest@example.org', 'password' => Hash::make('secret'), 'guest' => 1, 'admin' => 1],
    ]);

    $this->get('/admin')->assertRedirect('/admin/login');
    foreach (['user', 'guest'] as $login) {
        expect(Auth::guard('admin')->attempt(['email' => $login, 'password' => 'secret']))->toBeFalse();
    }

    Livewire::test(AdminLogin::class)
        ->fillForm(['email' => 'manager@example.org', 'password' => 'secret'])
        ->call('authenticate')
        ->assertHasNoFormErrors();
    $this->assertAuthenticatedAs(AdminUser::find(1), 'admin');
    $this->get('/admin')->assertOk();
});

test('legacy passwords upgrade on successful login without replacing users', function () {
    DB::table('users')->insert([
        ['username' => 'old', 'mail' => 'old@example.org', 'password' => md5('secret'), 'guest' => 0, 'admin' => 1],
        ['username' => 'plain', 'mail' => 'plain@example.org', 'password' => 'old-password', 'guest' => 0, 'admin' => 1],
    ]);

    expect(Auth::guard('admin')->attempt(['email' => 'old@example.org', 'password' => 'wrong']))->toBeFalse();
    expect(DB::table('users')->where('username', 'old')->value('password'))->toBe(md5('secret'));
    expect(Auth::guard('admin')->attempt(['email' => 'old@example.org', 'password' => 'secret']))->toBeTrue();
    expect(Hash::check('secret', DB::table('users')->where('username', 'old')->value('password')))->toBeTrue();
    Auth::guard('admin')->logout();
    expect(Auth::guard('admin')->attempt(['email' => 'plain@example.org', 'password' => 'old-password']))->toBeTrue();
    expect(Hash::check('old-password', DB::table('users')->where('username', 'plain')->value('password')))->toBeTrue();
});

test('panel access is revoked when an administrator is demoted', function () {
    $id = DB::table('users')->insertGetId(['username' => 'admin', 'password' => Hash::make('secret'), 'guest' => 0, 'admin' => 1]);
    Auth::guard('admin')->loginUsingId($id);
    DB::table('users')->where('id', $id)->update(['admin' => 0]);
    Auth::guard('admin')->forgetUser();

    $this->get('/admin')->assertForbidden();
});

test('administrators cannot sign in with a username', function () {
    DB::table('users')->insert(['username' => 'manager', 'mail' => 'manager@example.org', 'password' => Hash::make('secret'), 'guest' => 0, 'admin' => 2]);

    expect(Auth::guard('admin')->attempt(['email' => 'manager', 'password' => 'secret']))->toBeFalse();
    expect(Auth::guard('admin')->attempt(['login' => 'manager', 'password' => 'secret']))->toBeFalse();
});

test('administrator email migration updates only matching accounts', function () {
    DB::table('users')->insert([
        ['username' => 'ismaele.t', 'mail' => 'old@example.org'],
        ['username' => 'Bottega', 'mail' => 'shop@example.org'],
        ['username' => 'other', 'mail' => 'other@example.org'],
    ]);

    $migration = require database_path('migrations/2026_11_13_000000_update_administrator_email_addresses.php');
    $migration->up();
    $migration->up();

    expect(DB::table('users')->pluck('mail', 'username')->all())->toBe([
        'ismaele.t' => 'ismaele.tuffanelli@gmail.com',
        'Bottega' => 'silvia@bottegadelleerbe.com',
        'other' => 'other@example.org',
    ]);

    DB::table('users')->delete();
    $migration->up();
    expect(DB::table('users')->count())->toBe(0);
});

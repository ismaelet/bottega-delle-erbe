<?php

use App\Filament\Resources\Courses\Pages\CreateCourse;
use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Models\Course;
use App\Models\Item;
use App\Models\Post;
use App\Services\AdminImages;
use App\Services\ProductCsvImport;
use Filament\Facades\Filament;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;

beforeEach(function () {
    config([
        'database.default' => 'sqlite',
        'database.connections.sqlite.url' => null,
        'database.connections.sqlite.database' => ':memory:',
    ]);
    DB::purge('sqlite');

    $this->imageRoot = sys_get_temp_dir().'/admin-images-'.bin2hex(random_bytes(12));
    config(['filesystems.disks.public.root' => $this->imageRoot]);
    Storage::forgetDisk('public');

    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('username');
        $table->string('mail')->default('');
        $table->string('password')->default('');
        $table->boolean('guest')->default(false);
        $table->integer('admin')->default(0);
    });
    Schema::create('items_types', function (Blueprint $table) {
        $table->increments('id');
        $table->string('tag');
        $table->string('name');
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
        $table->float('price')->default(0);
        $table->string('tech')->default('');
        $table->string('info')->default('');
        $table->string('methods')->default('');
        $table->string('ingredients')->default('');
        $table->string('warnings')->default('');
        $table->timestamp('time')->useCurrent();
    });
    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->string('text');
        $table->boolean('cover')->default(true);
        $table->timestamp('time')->useCurrent();
    });
    Schema::create('courses', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->string('text');
        $table->string('schedule');
    });
    DB::table('items_types')->insert([
        ['tag' => 'int', 'name' => 'Integratore'],
        ['tag' => 'gem', 'name' => 'Gemmoderivato'],
    ]);
    DB::table('items_uses')->insert(['tag' => 'res', 'name' => 'Respirazione']);
    $adminId = DB::table('users')->insertGetId(['username' => 'admin', 'admin' => 2]);
    Auth::guard('admin')->loginUsingId($adminId);
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

afterEach(function () {
    File::deleteDirectory($this->imageRoot);
    Storage::forgetDisk('public');
});

test('resources save legacy records and preserve images when changing product type', function () {
    $item = Item::create(['name' => 'Prodotto', 'type' => 'int', 'info' => '', 'methods' => '', 'ingredients' => '', 'warnings' => '']);
    Storage::disk('public')->put("items/int/{$item->id}.jpg", 'original');
    Storage::disk('public')->put("items/int/{$item->id}_m.jpg", 'thumbnail');
    $this->get('/admin/items')->assertOk();

    Livewire::test(EditItem::class, ['record' => $item->getKey()])
        ->fillForm(['name' => 'Prodotto', 'type' => 'gem', 'uses' => ['res'], 'price' => 12])
        ->call('save')
        ->assertHasNoFormErrors();
    expect($item->fresh()->type)->toBe('gem')
        ->and($item->fresh()->uses)->toBe('res')
        ->and(Storage::disk('public')->get("items/gem/{$item->id}.jpg"))->toBe('original')
        ->and(Storage::disk('public')->get("items/int/{$item->id}.jpg"))->toBe('original');

    Livewire::test(CreatePost::class)
        ->fillForm(['title' => 'Notizia', 'text' => 'Testo'])
        ->call('create')
        ->assertHasNoFormErrors();
    Livewire::test(CreateCourse::class)
        ->fillForm(['title' => 'Corso', 'text' => 'Testo', 'schedule' => 'Lunedì'])
        ->call('create')
        ->assertHasNoFormErrors();
    expect(DB::table('posts')->where('title', 'Notizia')->exists())->toBeTrue()
        ->and(DB::table('courses')->where('title', 'Corso')->exists())->toBeTrue();
});

test('image uploads use the public legacy paths and sizes', function () {
    $item = Item::create(['name' => 'Prodotto', 'type' => 'int', 'info' => '', 'methods' => '', 'ingredients' => '', 'warnings' => '']);
    app(AdminImages::class)->save($item, UploadedFile::fake()->image('product.png', 1200, 600));
    $path = Storage::disk('public')->path("items/int/{$item->id}.jpg");
    $thumb = Storage::disk('public')->path("items/int/{$item->id}_m.jpg");
    expect(getimagesize($path)[0])->toBe(1024)
        ->and(getimagesize($thumb)[0])->toBe(450);

    $post = Post::create(['title' => 'Notizia', 'text' => 'Testo']);
    $course = Course::create(['title' => 'Corso', 'text' => 'Testo', 'schedule' => 'Lunedì']);
    app(AdminImages::class)->save($post, UploadedFile::fake()->image('post.png', 100, 50));
    app(AdminImages::class)->save($course, UploadedFile::fake()->image('course.png', 100, 50));
    $postThumbnail = getimagesize(Storage::disk('public')->path("blog/{$post->id}_m.jpg"));
    $courseThumbnail = getimagesize(Storage::disk('public')->path("courses/{$course->id}_m.jpg"));
    expect([$postThumbnail[0], $postThumbnail[1]])->toBe([500, 700])
        ->and($courseThumbnail[0])->toBe(800);
});

test('product creation saves uploaded image variants', function () {
    Livewire::test(CreateItem::class)
        ->fillForm([
            'name' => 'Prodotto',
            'type' => 'int',
            'price' => 10,
            'uses' => [],
            'image_upload' => UploadedFile::fake()->image('product.png', 100, 50),
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $item = Item::where('name', 'Prodotto')->firstOrFail();
    expect(Storage::disk('public')->exists("items/int/{$item->id}.jpg"))->toBeTrue()
        ->and(Storage::disk('public')->exists("items/int/{$item->id}_m.jpg"))->toBeTrue();
});

test('a failed image write restores the previous variants', function () {
    $item = Item::create(['name' => 'Prodotto', 'type' => 'int', 'info' => '', 'methods' => '', 'ingredients' => '', 'warnings' => '']);
    $full = "items/int/{$item->id}.jpg";
    $thumb = "items/int/{$item->id}_m.jpg";
    $disk = new class($full, $thumb)
    {
        public array $files;

        private int $writes = 0;

        public function __construct(string $full, string $thumb)
        {
            $this->files = [$full => 'original', $thumb => 'thumbnail'];
        }

        public function exists(string $path): bool
        {
            return array_key_exists($path, $this->files);
        }

        public function get(string $path): string
        {
            return $this->files[$path];
        }

        public function put(string $path, string $contents): bool
        {
            if (++$this->writes === 2) {
                return false;
            }
            $this->files[$path] = $contents;

            return true;
        }
    };
    Storage::set('public', $disk);

    expect(fn () => app(AdminImages::class)->save($item, UploadedFile::fake()->image('product.png')))
        ->toThrow(RuntimeException::class, 'Impossibile salvare');
    expect($disk->files)->toBe([$full => 'original', $thumb => 'thumbnail']);
});

test('CSV update preserves empty fields and reports missing products', function () {
    Item::create(['name' => 'Prodotto', 'type' => 'int', 'info' => 'Originale', 'methods' => '', 'ingredients' => '', 'warnings' => '']);
    $file = UploadedFile::fake()->createWithContent('items.csv', "nome;tipo;tech;info;methods;ingredients;warnings;price\nProdotto;gem;;;Nuovo;;;0\nMancante;int;;;;;;\n");
    $missing = app(ProductCsvImport::class)->import($file, true);
    $item = Item::where('name', 'Prodotto')->firstOrFail();
    expect($missing)->toBe(['Mancante'])
        ->and($item->type)->toBe('int')
        ->and($item->info)->toBe('Originale')
        ->and($item->methods)->toBe('Nuovo')
        ->and((float) $item->price)->toBe(0.0);
});

test('CSV validation occurs before any rows are changed', function () {
    $item = Item::create(['name' => 'Prodotto', 'type' => 'int', 'info' => 'Originale', 'methods' => '', 'ingredients' => '', 'warnings' => '']);
    $file = UploadedFile::fake()->createWithContent('items.csv', "Prodotto;int;;Modificato;;;;1\nbad;row\n");
    try {
        app(ProductCsvImport::class)->import($file, true);
        $this->fail('Invalid CSV was accepted.');
    } catch (ValidationException) {
        expect($item->fresh()->info)->toBe('Originale');
    }
});

test('CSV import creates new products and supports quoted semicolons', function () {
    $file = UploadedFile::fake()->createWithContent('items.csv', "Nuovo;int;100ml;\"una; due\";;;;12,50\n");
    expect(app(ProductCsvImport::class)->import($file, false))->toBe([]);
    $item = Item::where('name', 'Nuovo')->firstOrFail();
    expect($item->info)->toBe('una; due')->and((float) $item->price)->toBe(12.5);
});

test('CSV import action accepts an uploaded file', function () {
    $file = UploadedFile::fake()->createWithContent('items.csv', "Nuovo;int;100ml;Testo;;;;12,50\n");
    Livewire::test(ListItems::class)
        ->callAction('import', ['file' => $file, 'updateOnly' => false])
        ->assertHasNoActionErrors();
    expect(Item::where('name', 'Nuovo')->exists())->toBeTrue();
});

test('CSV import action reports invalid rows without writing', function () {
    $file = UploadedFile::fake()->createWithContent('items.csv', "invalid;row\n");
    Livewire::test(ListItems::class)
        ->callAction('import', ['file' => $file, 'updateOnly' => false])
        ->assertNotified('Importazione non riuscita');
    expect(Item::count())->toBe(0);
});

test('resource deletion removes the database record', function () {
    $item = Item::create(['name' => 'Prodotto', 'type' => 'int', 'info' => '', 'methods' => '', 'ingredients' => '', 'warnings' => '']);
    Livewire::test(EditItem::class, ['record' => $item->getKey()])->callAction('delete');
    expect(Item::find($item->getKey()))->toBeNull();
});

test('the site visibility page has been removed', function () {
    $this->get('/admin/public-visibility')->assertNotFound();
    $this->get('/admin')->assertOk()->assertDontSee('Visibilità sito');
});

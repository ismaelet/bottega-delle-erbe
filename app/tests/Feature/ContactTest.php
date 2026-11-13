<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;

beforeEach(function () {
    config([
        'database.default' => 'sqlite',
        'database.connections.sqlite.url' => null,
        'database.connections.sqlite.database' => ':memory:',
        'mail.default' => 'contact-test',
        'mail.mailers.contact-test' => ['transport' => 'contact-test'],
        'mail.from.address' => 'sender@example.org',
        'mail.from.name' => 'Negozio',
    ]);
    DB::purge('sqlite');

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
    Mail::extend('contact-test', fn () => new ArrayTransport);
});

test('contacts page displays the form', function () {
    $this->get('/contacts')->assertOk()->assertSee('Scrivici')->assertSee('Via IX Novembre, 8')
        ->assertSee('name="name"', false)->assertSee('name="mail"', false)->assertSee('name="text"', false);
});

test('valid contact messages are sent to the shop with a reply address', function () {
    $this->post('/contacts', ['name' => 'Mario Rossi', 'mail' => 'mario@gmail.com', 'text' => "Buongiorno\nVorrei informazioni"])
        ->assertRedirect('/contacts#form-anch')->assertSessionHas('contact_sent', true);

    $messages = Mail::mailer()->getSymfonyTransport()->messages();
    expect($messages)->toHaveCount(1);
    $message = $messages->first()->getOriginalMessage();
    expect($message->getTo()[0]->getAddress())->toBe('online@bottegadelleerbe.com')
        ->and($message->getReplyTo()[0]->getAddress())->toBe('mario@gmail.com')
        ->and($message->getReplyTo()[0]->getName())->toBe('Mario Rossi')
        ->and($message->getSubject())->toBe('Richiesta informazioni')
        ->and($message->getTextBody())->toContain('Mario Rossi', "Buongiorno\nVorrei informazioni");
    $this->get('/contacts')->assertOk()->assertSee('Messaggio inviato');
    expect($messages)->toHaveCount(1);
});

test('invalid inputs and legacy spam filters do not send mail', function () {
    $this->from('/contacts')->post('/contacts', ['name' => '', 'mail' => 'invalid', 'text' => str_repeat('x', 501)])
        ->assertSessionHasErrors(['name', 'mail', 'text']);
    $this->post('/contacts', ['name' => 'Mario', 'mail' => 'mario@example.org', 'text' => 'Salve'])
        ->assertRedirect('/contacts#form-anch')->assertSessionHasErrors('mail');
    $this->post('/contacts', ['name' => 'Mario', 'mail' => 'mario@gmail.com', 'text' => 'https://example.org'])
        ->assertRedirect('/contacts#form-anch')->assertSessionHasErrors('text');
    expect(Mail::mailer()->getSymfonyTransport()->messages())->toHaveCount(0);
});

test('unconfigured or failed delivery does not report success and preserves the message', function () {
    $data = ['name' => 'Mario', 'mail' => 'mario@gmail.com', 'text' => 'Salve'];
    config(['mail.default' => 'log']);
    $this->post('/contacts', $data)->assertRedirect('/contacts#form-anch')
        ->assertSessionHasErrors('delivery')->assertSessionHasInput('text', 'Salve')->assertSessionMissing('contact_sent');

    config(['mail.default' => 'contact-failure', 'mail.mailers.contact-failure' => ['transport' => 'contact-failure']]);
    Mail::extend('contact-failure', fn () => new class implements TransportInterface
    {
        public function send(RawMessage $message, ?Envelope $envelope = null): ?SentMessage
        {
            throw new TransportException('Test transport failure');
        }

        public function __toString(): string
        {
            return 'contact-failure';
        }
    });

    $this->post('/contacts', $data)->assertRedirect('/contacts#form-anch')
        ->assertSessionHasErrors('delivery')->assertSessionHasInput('text', 'Salve')->assertSessionMissing('contact_sent');
});

test('a cancelled mail event is not reported as a successful submission', function () {
    Event::listen(MessageSending::class, fn () => false);

    $this->post('/contacts', ['name' => 'Mario', 'mail' => 'mario@gmail.com', 'text' => 'Salve'])
        ->assertRedirect('/contacts#form-anch')->assertSessionHasErrors('delivery')->assertSessionMissing('contact_sent');
    expect(Mail::mailer()->getSymfonyTransport()->messages())->toHaveCount(0);
});

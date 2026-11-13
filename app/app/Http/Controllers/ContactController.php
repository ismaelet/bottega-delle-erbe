<?php

namespace App\Http\Controllers;

use App\Services\PublicNavigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends Controller
{
    private const CONTACT_EMAIL = 'online@bottegadelleerbe.com';

    public function index(PublicNavigation $navigation): View
    {
        return view('contacts', ['menus' => $navigation->menus()]);
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'mail' => ['required', 'string', 'email:rfc', 'max:254'],
                'text' => ['required', 'string', 'max:500'],
            ],
            [
                'required' => 'Il campo :attribute è obbligatorio.',
                'string' => 'Il campo :attribute non è valido.',
                'email' => 'Inserisci un indirizzo e-mail valido.',
                'max.string' => 'Il campo :attribute non può superare :max caratteri.',
            ],
            ['name' => 'nome e cognome', 'mail' => 'indirizzo e-mail', 'text' => 'messaggio'],
        );

        $provider = strtolower(explode('.', explode('@', $data['mail'], 2)[1], 2)[0]);
        if (! in_array($provider, ['tiscali', 'gmail', 'libero', 'yahoo', 'hotmail', 'icloud', 'outlook'], true)) {
            return $this->error('mail', "Errore: l'indirizzo email non è stato riconosciuto.", $request);
        }
        if (preg_match('/(sexy|bitcoin|wellness|dollars|https|free|business)/i', $data['text'])) {
            return $this->error('text', 'Errore: il messaggio non ha superato i nostri filtri anti-spam.', $request);
        }

        $mailer = config('mail.default');
        $transport = config("mail.mailers.{$mailer}.transport");
        $from = config('mail.from.address');
        if (! is_string($transport) || in_array($transport, ['log', 'array', 'failover', 'roundrobin'], true)
            || ! is_string($from) || in_array($from, ['hello@example.com', 'noreply@bottega-delle-erbe.example.com'], true)) {
            Log::error('Contact form mail delivery is not configured for sending.', ['mailer' => $mailer]);

            return $this->error('delivery', 'Non è stato possibile inviare il messaggio.', $request);
        }

        try {
            $sent = Mail::raw("Messaggio da {$data['name']} ({$data['mail']}):\n\n{$data['text']}", function (Message $message) use ($data) {
                $message->to(self::CONTACT_EMAIL)->replyTo($data['mail'], $data['name'])->subject('Richiesta informazioni');
            });
        } catch (TransportExceptionInterface $exception) {
            report($exception);

            return $this->error('delivery', 'Non è stato possibile inviare il messaggio.', $request);
        }

        if ($sent === null) {
            Log::error('Contact form mail was not sent.');

            return $this->error('delivery', 'Non è stato possibile inviare il messaggio.', $request);
        }

        return redirect()->route('contacts.index')->with('contact_sent', true)->withFragment('form-anch');
    }

    private function error(string $field, string $message, Request $request): RedirectResponse
    {
        return redirect()->route('contacts.index')->withErrors([$field => $message])->withInput($request->only('name', 'mail', 'text'))->withFragment('form-anch');
    }
}

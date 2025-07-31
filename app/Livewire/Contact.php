<?php

declare(strict_types=1);

namespace App\Livewire;

use Blockpc\App\Mails\ContactEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Contact extends Component
{
    public $numero_uno;

    public $numero_dos;

    public $suma;

    public $firstname;

    public $lastname;

    public $email;

    public $message;

    public $resultado;

    protected $messages = [
        'resultado.same' => 'La suma no coincide. Intentelo de nuevo',
    ];

    protected $validationAttributes = [
        'firstname' => 'nombre',
        'lastname' => 'apellido',
        'email' => 'correo',
        'message' => 'mensaje',
    ];

    public function mount(int $numero_uno = 0, int $numero_dos = 0)
    {
        $this->numero_uno = $numero_uno ?: random_int(1, 10);
        $this->numero_dos = $numero_dos ?: random_int(1, 10);
        $this->resultado = '';
    }

    #[Layout('layouts.frontend')]
    #[Title('Contacto')]
    public function render()
    {
        $this->suma = $this->numero_uno + $this->numero_dos;

        return view('livewire.contact');
    }

    public function submit()
    {
        $data = $this->validate();
        Mail::send(new ContactEmail($data));
        session()->flash('success', 'Mensaje enviado');
        $this->redirectRoute('contact', navigate: true);
    }

    protected function rules()
    {
        return [
            'firstname' => 'required|string|max:64',
            'lastname' => 'nullable|string|max:64',
            'email' => 'required|email',
            'message' => 'required|string|max:512',
            'resultado' => 'required|integer|size:'.$this->suma,
        ];
    }
}

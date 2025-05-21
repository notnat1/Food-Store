<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Customer;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    
    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'confirmed'],
        ];
    }

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        // redirect if user is already logged in
        if(auth()->guard('customer')->check()) {
            return $this->redirect('/account/my-orders', navigate: true);
        }
    }
    
    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        //validate
        $this->validate();

        //create customer
        Customer::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => bcrypt($this->password),
        ]);

        //session flash
        session()->flash('success', 'Register Berhasil, silahkan login');

        //redirect
        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
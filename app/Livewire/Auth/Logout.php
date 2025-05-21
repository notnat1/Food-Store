<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Logout extends Component
{
    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        // logout
        auth()->guard('customer')->logout();

        // session flash
        session()->flash('success', 'Logout Berhasil');

        // redirect
        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
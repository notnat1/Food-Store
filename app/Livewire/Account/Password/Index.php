<?php

namespace App\Livewire\Account\Password;

use Livewire\Component;
use App\Models\Customer;

class Index extends Component
{
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
            'password'  => 'required|confirmed',
        ];
    }
    
    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        // Validasi input
        $this->validate();

        //update
        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
        $customer->update([
            'password'  => bcrypt($this->password)
        ]);

        // session flash
        session()->flash('success', 'Update Password Berhasil');

        // redirect to the desired page
        return $this->redirect('/account/password', navigate: true);
    }

    public function render()
    {
        return view('livewire.account.password.index');
    }
}
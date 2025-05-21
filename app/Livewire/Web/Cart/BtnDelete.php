<?php

namespace App\Livewire\Web\Cart;

use App\Models\Cart;
use Livewire\Component;

class BtnDelete extends Component
{
    public $cart_id;
    
    /**
     * mount
     *
     * @param  mixed $cart_id
     * @return void
     */
    public function mount($cart_id)
    {
        $this->cart_id = $cart_id;
    }
    
    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $cart = Cart::find($this->cart_id);
        $cart->delete();

        //session flash
        session()->flash('success', 'Keranjang Berhasil Dihapus');

        //redirect
        return $this->redirect('/cart', navigate: true);
    }

    public function render()
    {
        return view('livewire.web.cart.btn-delete');
    }
}
<?php

namespace App\Livewire\Web\Cart;

use App\Models\Cart;
use Livewire\Component;

class BtnIncrement extends Component
{
    public $cart_id;
    public $product_id;
    
    /**
     * mount
     *
     * @param  mixed $cart_id
     * @param  mixed $product_id
     * @return void
     */
    public function mount($cart_id, $product_id)
    {
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
    }
    
    /**
     * increment
     *
     * @return void
     */
    public function increment()
    {
        $cart = Cart::find($this->cart_id);
        $cart->increment('qty');

        //session flash
        session()->flash('success', 'Qty Keranjang Berhasil Ditambahkan');

        //redirect
        return $this->redirect('/cart', navigate: true);
    }

    public function render()
    {
        return view('livewire.web.cart.btn-increment');
    }
}
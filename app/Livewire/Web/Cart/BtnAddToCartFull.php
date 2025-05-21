<?php

namespace App\Livewire\Web\Cart;

use App\Models\Cart;
use Livewire\Component;

class BtnAddToCartFull extends Component
{   
    /**
     * product_id
     *
     * @var mixed
     */
    public $product_id;
    
    /**
     * addToCart
     *
     * @param  mixed $product_id
     * @return void
     */
    public function addToCart()
    {
        //check user is logged in
        if(!auth()->guard('customer')->check()) {

            session()->flash('warning', 'Silahkan login terlebih dahulu');

            return $this->redirect('/login', navigate: true);
        }
        
        //check cart
        $item = Cart::where('product_id', $this->product_id)
                    ->where('customer_id', auth()->guard('customer')->user()->id)
                    ->first();
        
        //if cart already exist
        if ($item) {

            //update cart qty
            $item->increment('qty');

        } else {

            //store cart
            $item = Cart::create([
                'customer_id'   => auth()->guard('customer')->user()->id,
                'product_id'    => $this->product_id,
                'qty'           => 1
            ]);

        }

        // session flash
        session()->flash('success', 'Produk ditambahkan ke keranjang');

        //redirect to cart
        return $this->redirect('/cart', navigate: true);

    }
    
    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.web.cart.btn-add-to-cart-full');
    }
}
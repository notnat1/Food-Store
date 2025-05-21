<?php

namespace App\Livewire\Web\Checkout;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Province;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    public $address;
    public $province_id;
    public $city_id;

    public $loading  = false;
    public $showCost = false;
    public $costs;

    public $selectCourier = '';
    public $selectService = '';
    public $selectCost = 0;

    public $grandTotal = 0;
    
    /**
     * getCartsData
     *
     * @return void
     */
    public function getCartsData()
    {
        //get carts by customer
        $carts = Cart::query()
            ->with('product')
            ->where('customer_id', auth()->guard('customer')->user()->id)
            ->latest()
            ->get();

        // Menghitung total berat
        $totalWeight = $carts->sum(function ($cart) {
            return $cart->product->weight * $cart->qty;
        });

        // Menghitung total harga
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->qty;
        });

        // Return as an array
        return [
            'totalWeight' => $totalWeight,
            'totalPrice'  => $totalPrice,
        ];
    }

    
    /**
     * changeCourier
     *
     * @param  mixed $value
     * @return void
     */
    public function changeCourier($value)
    {
        if (!empty($value)) {

            //set courier
            $this->selectCourier = $value;

            //set loading
            $this->loading = true;

            //set show cost false
            $this->showCost = false;

            //call method CheckOngkir
            $this->CheckOngkir();
        }
    }

    /**
     * Ongkir function: calculate shipping cost or any logic.
     *
     * @return void
     */
    public function CheckOngkir()
    {
        try {

            // Ambil data cart
            $cartData = $this->getCartsData();

            // Fetch Rest API
            $response = Http::withHeaders([
                'key' => config('rajaongkir.api_key')
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin'      => 113, // ID kota Demak
                'destination' => $this->city_id,
                'weight'      => $cartData['totalWeight'],
                'courier'     => $this->selectCourier,
            ]);

            // Process costs (optional: store in a variable)
            $this->costs = $response['rajaongkir']['results'][0]['costs'];
        } catch (\Exception $e) {
            // Handle error (optional: set an error message)
            session()->flash('error', 'Gagal mengambil ongkir.');
        } finally {
            // Always update loading and cost visibility
            $this->loading = false;
            $this->showCost = true;
        }
    }
    
    /**
     * getServiceAndCost
     *
     * @param  mixed $data
     * @return void
     */
    public function getServiceAndCost($data)
    {
        // Pecah data menjadi nilai cost dan service
        [$cost, $service] = explode('|', $data);

        // Set nilai cost dan service
        $this->selectCost = (int) $cost;
        $this->selectService = $service;

        // Ambil total harga dari cart
        $cartData = $this->getCartsData();

        // Hitung grand total
        $this->grandTotal = $cartData['totalPrice'] + $this->selectCost;
    }

    public function render()
    {
        //get provinces
        $provinces = Province::query()->get();

        //get total cart price
        $cartData = $this->getCartsData();
        $totalPrice     = $cartData['totalPrice'];
        $totalWeight    = $cartData['totalWeight'];

        return view('livewire.web.checkout.index', compact('provinces', 'totalPrice', 'totalWeight'));
    }
}
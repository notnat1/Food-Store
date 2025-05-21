<?php

namespace App\Livewire\Account\MyOrders;

use App\Models\Rating;
use Livewire\Component;

class ModalRating extends Component
{
    public $transaction;
    public $item;

    public $rating;
    public $review;
    
    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'rating' => 'required|in:1,2,3,4,5',
            'review' => 'required',
        ];
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }
    
    /**
     * storeRating
     *
     * @return void
     */
    public function storeRating()
    {
        // validate
        $this->validate();

        //check rating already
        $check_rating = Rating::query()
            ->where('product_id', $this->item->product->id)
            ->where('customer_id', auth()->guard('customer')->user()->id)
            ->first();

        if($check_rating) {
            session()->flash('warning', 'Anda sudah pernah memberikan rating untuk produk ini');
            return $this->redirect('/account/my-orders/'.$this->transaction->snap_token, navigate: true);
        }

        // create rating
        Rating::create([
            'transaction_detail_id' => $this->item->id,
            'product_id'            => $this->item->product->id,
            'rating'                => $this->rating,
            'review'                => $this->review,
            'customer_id'           => auth()->guard('customer')->user()->id
        ]);

        //session flash
        session()->flash('success', 'Rating Berhasil Disimpan');

        //redirect
        return $this->redirect('/account/my-orders/'.$this->transaction->snap_token, navigate: true);
    }

    public function render()
    {
        return view('livewire.account.my-orders.modal-rating');
    }
}
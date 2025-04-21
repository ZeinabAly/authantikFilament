<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CheckoutService
{
    /**
     * Calculer et stocker les informations de checkout dans la session.
     */

    public function getCartSubtotal()
    {
        return (float)str_replace(',', '', Cart::instance('cart')->subtotal());
    }

    public function apply_coupon_code($code){
        
        // $subtotal = (float)str_replace(',', '', Cart::instance('cart')->subtotal());
        if(isset($code)){
            $coupon = Coupon::where('code', $code)
                            ->where('expiry_date', '>=', Carbon::today())
                            ->where('cart_value', '<=', $this->getCartSubtotal())
                            ->first();
            
        }

        if(!$coupon){
            return Notification::make()
                ->title('Code invalide')
                ->danger()
                ->body('Votre coupon n\'est pas reconnu par le système. Veuillez réessayer.')
                ->send();
            // return session()->flash('error', 'Code invalide !');
        }else{
            Session::put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);

            return Notification::make()
                ->title('Code appliqué avec succcès  !')
                ->success()
                ->body('Votre code a été appliqué avec succès.')
                ->send();
            // return session()->flash('success', 'Code appliqué avec succcès !');
            $this->calculateDiscount();
        }
    }

    public function calculateDiscount()
    {
        if (Session::has('coupon')) {
            // Si un coupon est appliqué
            if(Session::get('coupon')['type'] == 'fixed'){
                $discount = Session::get('coupon')['value'];
            }else{
                $discount = ($this->getCartSubtotal() * Session::get('coupon')['value'])/100;
            }

            $subtotalAfterDiscount = $this->getCartSubtotal() - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax'))/100 ?? 0;
            // $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;
            $totalAfterDiscount = $subtotalAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format($discount, 0),
                'subtotal' => number_format($subtotalAfterDiscount, 0),
                // 'tax' => number_format($taxAfterDiscount, 0),
                'total' => number_format($totalAfterDiscount, 0),
            ]);
            
        } 
    }

    public function calculateCheckout(){
        if(!Cart::instance('cart')->content()->count() > 0){
            Session::forget('checkout');
            return;
        }

        if(Session::has('coupon')){
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'] ?? 0,
                'total' => Session::get('discounts')['total'],
            ]);
        }else{
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => $this->getCartSubtotal(),
                'tax' => Cart::instance('cart')->tax() ,
                'total' => Cart::instance('cart')->total(),
            ]);
        }

        return Session::get('checkout');
    }

    public function remove_coupon_code(){
        Session::forget('coupon');
        Session::forget('discounts');
    }

    /**
     * Retourner les données du checkout.
     */
    public function getCheckoutData()
    {
        return Session::get('checkout');
    }
}

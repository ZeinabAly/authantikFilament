
<div class="orderConfirmationContent">
    <div class="border md:border-0 pt-10 pb-20 px-5 rounded-md shadow md:shadow-none">
        <div class="flexCenter">
            @if(isset($order))
            <x-icon name="success" fill="#ce9c2d" color="#ce9c2d" size="100" />
            @else
            <x-icon name="visage-fache" fill="#ce9c2d" color="#ce9c2d" size="100" class="mb-5" />
            @endif
        </div>
        <div class="flexColumn">
            @if(isset($order))<h5>
                Votre commande a été passée avec succès ! </h5>
            @endif

            <a href="{{route('home.menu')}}" class="btnContinuerAchats">Continuer les achats</a>
            @if(isset($order))
            <a href="{{route('facture.telecharger', ['order' => $order])}}" class="btnTelechargerFacture">Télecharger la facture</a>
            @else
                <a href="{{route('cart.checkout')}}" class="btnTelechargerFacture">Vous avez sautez l'étape de paiement veuillez y retourner ! </a>
            @endif
            <p class="text-[--color1-green] font-bold">Merci pour votre fidelité ! </p>
        </div>
    </div>
    
</div>


@extends('layouts.app')
@section('content')
<!-- Banniere -->
<div class="pageReservation">
    <div class="banniere">
        <div class="cover">
            <h1>Reservation</h1>
        </div>
    </div>

    <!-- DINNER AVEC ELEGANCE -->
    <div class="dinnerElegant">
        <div class="">
            <p class="section-subtitle"></p>
            <h2 class="section-title text-3xl roboto font-bold">Dinnez avec <span class="allura text-[--color2-yellow]">élégance</span></h2>
    
            <div class="texte">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa adipisci atque numquam, aperiam natus quibusdam dicta tenetur saepe voluptatibus consectetur illo placeat. In dolorum ipsam nobis incidunt voluptas. Molestiae, ex.
            </div>
            <button class="btnPageRersever">Voir le menu</button>
        </div>

        <div class="images">
            <img src="{{asset('assets/images/pageIndex/cotelettes.jpg')}}" alt="">
            <img src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="">
            <img src="{{asset('assets/images/pageIndex/Poulet-Yassa.jpg')}}" alt="">
        </div>
    </div>
    <!-- FIN DINNER AVEC ELEGANCE -->

    <!-- SECTION1 -->
    <section class="section-form">
    <div class="section-container">
        <!-- Reservation -->
        <div class="form-cover">
            <div class="w-full absolute top-0 z-[100000] left-0">
                @if(Session::has('success'))
                    <p class="alert alert-success">{{Session::get('success')}}</p>
                @endif
                @if(Session::has('loginExige'))
                    <p class="alert alert-error">{{ session('loginExige') }}</p>
                @endif
                @if(Session::has('error'))
                    <p class="alert alert-error bg-white text-red-500 py-5 px-4 text-lg">{{Session::get('error')}}</p>
                @endif
                
            </div>

            <h2 class="reservation-accro">Réservation</h2>
            <h2 class="reservation-title">Preparez votre fête a l'avance</h2>
            <p class="reservation-texte">Appelez-nous au <span class="text-[--color2-yellow] font-bold">+224 629836668</span> ou remplissez ce formulaire</p>
            <form method="POST" class="w-[100%] relative" action="{{route('reservation.store')}}">
                @csrf
                <div class="reservation-inputs">
                    
                    <select name="nbrPers" value="{{old('nbrPers')}}" class="selectNbr champInput" style="grid-area: nbre">
                        <option value="">Nombre</option>
                        @for($i= 1; $i <= 10; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                    <input type="date" name="date" value="{{old('date')}}" style="grid-area: date" class="champInput">
                    @error('date')<span class="text-red-500">{{$message}}</span>@enderror

                    <input type="time" name="heure" value="{{old('heure')}}" class="champInput" style="grid-area: heure">
                    @error('heure')<span class="text-red-500">{{$message}}</span>@enderror

                    <input type="text" name="name" placeholder="Nom" value="{{old('name')}}" class="champInput" style="grid-area: nom">
                    @error('name')<span class="text-red-500">{{$message}}</span>@enderror

                    <input type="number" name="phone" placeholder="Télephone" value="{{old('phone')}}" class="champInput" style="grid-area: phone">
                    @error('phone')<span class="text-red-500">{{$message}}</span>@enderror

                    <input type="email" name="email" placeholder="Email" value="{{old('email')}}" style="grid-area: email" class="champInput">
                    @error('email')<span class="alert alert-danger text-center">{{$message}}</span>@enderror
                    
                    <textarea name="details" value="{{old('details')}}" style="grid-area: textearea" id="details" value="{{ old('details') }}" placeholder="Donnez quelques détails" class="champInput"></textarea>
                    @error('details')<span class="text-red-500">{{$message}}</span>@enderror
                </div>
    
                <button type="submit" class="btnPageRersever">Réserver</button>
            </form>
        </div>
    </div>
</section>
    <!-- FIN SECTION1 -->
    
    <!-- SECTION2: Contact -->
     <div class="contact mb-5">
        <div class="image">
            <img src="{{asset('assets/images/pageIndex/hero-slider-1.jpg')}}" alt="">
        </div>
        <div class="contact-infos">
            <div class="mt-5">
                <h2 class="">
                    Contacts
                </h2>
                <p class="flex items-center gap-[7px]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="16" fill="#ce9c2d"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                    <span>+224 628967854</span>
                </p>
                <p class="flex items-center gap-[7px]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="16" fill="#ce9c2d"><path d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"/></svg>
                    <span>authentik@gmail.com</span>
                </p>
                <p class="flex items-center gap-[7px]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="16" fill="#ce9c2d"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                    <span>Dixinn Terasse</span>
                </p>
            </div>

            <button class="appel btnPageRersever">
                <a href="tel:+225629836668">Appelez-nous</a>
            </button>
        </div>
        <div class="horaires" >
            <div class="horaires-cover">
                <p class="text-white text-3xl font-bold"><span class="text-gray-500">Horaires <br /></span> d'ouverture</p>
                <div class="">
                    <div class="min-w-[150px] ">
                        <p class="my-2 text-gray-500 font-bold text-[17px]">Lundi - Vendredi</p>
                        <p class="text-white">7h - 12h (Petit dej)</p>
                        <p class="text-white mt-1">12h - 23h (Déj/Dinner)</p>
                    </div>
                    <div class="min-w-[150px] ">
                        <p class="my-2 text-gray-500 font-bold text-[17px]">Samedi - Dimanche</p>
                        <p class="text-white mt-1">9h - 12h (Petit dej)</p>
                        <p class="text-white mt-1">12h - 23h (Déj/Dinner)</p>
                    </div>
                </div>
            </div>
        </div>

        
     </div>
    <!-- FIN SECTION2 -->
    
    <!-- SECTION3 -->
    <!-- FIN SECTION3 -->
</div>

@endsection
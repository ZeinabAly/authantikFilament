<div class="topHeader">
    <div class="contacts">
        <div class="adresse mt-0">
            <a href="{{route('home.contact')}}#map" class="flexCenter gap-2 scroll-smooth" rel="noopener noreferrer">
                <x-icon name="adresse" fill="#411f00" />
                <p>{{$settings->address ? $settings->address : "Dixinn Terasse"}}</p>
            </a>
        </div>
        <div class="phone">
            <a href="tel:+224{{$settings->phone ?? 620185893}}" class="flexCenter gap-2">
                <x-icon name="phone" fill="#411f00" />
                <p>{{$settings->phone ?? 629836564}} </p>
            </a>
        </div>
        <div class="email">
            <a href="mailto:{{$settings->email ?? 'authantik@gmail.com'}}" class="flexCenter gap-2">
                <x-icon name="enveloppe" fill="#411f00" />
                <p>{{$settings->email ?? "authantik@gmail.com"}}</p>
            </a>
        </div>
    </div>
    <div class="button">
        <a href="{{asset('storage/'.$settings->menu_pdf_path)}}" download="Menu">Télecharger le menu</a>
    </div>
</div>

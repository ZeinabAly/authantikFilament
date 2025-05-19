@extends("layouts.app")

@section('content')

<div class="contactPage">

    <section class="banniere">
      <div class="cover">
        <h2 class="page-title">CONTACT</h2>
        <p class="pageFilAriane">Accueil / Contact</p>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us">
      <div class="">
        <div class="contact-us__form">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dissimible fade show" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
            
            <div class="form_infos-contact">
                <!-- Les infos de contact -->
                <div class="contact_infos">
                    <div class="contactInfosContent">
                        <p class="text-white text-3xl allura"><span class="text-gray-400 sofia">Horaires <br /></span> d'ouverture</p>
                        <div class="contactsContainer">
                            <div class="min-w-[150px]">
                                <p class="contact_title">Lundi - Vendredi</p>
                                <p class="horaires">7h - 12h (Petit dej)</p>
                                <p class="horaires">12h - 23h (Déj/Dinner)</p>
                            </div>
                            <div class="min-w-[150px] ">
                                <p class="contact_title">Samedi - Dimanche</p>
                                <p class="horaires">9h - 12h (Petit dej)</p>
                                <p class="horaires">12h - 23h (Déj/Dinner)</p>
                            </div>
                            <div class="min-w-[150px]">
                                <p class="contact_title">Contacts</p>
                                <p class="contact">+224 628967854</p>
                                <p class="contact">authentik@gmail.com</p>
                                <p class="adresse">Dixinn Terasse</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form name="contact-us-form" action="{{route('home.contact.store')}}" class="contactForm" method="POST">
                    @csrf
                    <div class="formCover">
                        <p class="section-subtitle">Besoin de nos services ?</p>
                        <h3 class="section-title">Laissez-nous un message</h3>
                        <div class="nom_phone">
                            <div class="inputContent">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Nom" required>
                                @error('name') <span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="inputContent">
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}" placeholder="Téléphone" required>
                                @error('phone') <span class="text-danger">{{$message}}</span>@enderror
                            </div>
                        </div>
                        <div class="inputContent">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" required>
                            @error('email') <span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="inputContent">
                        <textarea class="form-control form-control_gray" name="message" placeholder="J'aurais besoin de votre aide pour..." cols="30"
                            rows="8" required>{{old('message')}}</textarea>
                            @error('comment') <span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <button type="submit" class="">Envoyer</button>
    
                    </div>
                </form>
            </div>
        </div>
      </div>
    </section>


    <!-- DINNER AVEC ELEGANCE -->
    <section class="dinnerElegant">
        <div class="">
            <p class="section-subtitle"></p>
            <h2 class="section-title text-3xl roboto font-bold">Laissez vous <span class="allura text-[--color2-yellow]">emporter</span></h2>
    
            <div class="texte">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa adipisci atque numquam, aperiam natus quibusdam dicta tenetur saepe voluptatibus consectetur illo placeat. In dolorum ipsam nobis incidunt voluptas. Molestiae, ex.
            </div>
            <div class="mt-5">
                <a href="{{route('home.menu')}}"><button>Voir le menu</button></a>
            </div>
        </div>

        <div class="images">
            <img src="{{asset('assets/images/pageIndex/cotelettes.jpg')}}" alt="">
            <img src="{{asset('assets/images/pageIndex/Foutou_banane_sauce_graine.jpeg')}}" alt="">
            <img src="{{asset('assets/images/pageIndex/Poulet-Yassa.jpg')}}" alt="">
        </div>
    </section>
    <!-- FIN DINNER AVEC ELEGANCE -->


    <!-- CARTE -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d296.4842516883969!2d-13.675467820645977!3d9.548102416585204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf1cd74b7bae531f%3A0xd95a7ff6549d2438!2sDixinn%20Terasse!5e1!3m2!1sfr!2s!4v1738586907369!5m2!1sfr!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <!-- FIN CARTE -->

</div>
@endsection
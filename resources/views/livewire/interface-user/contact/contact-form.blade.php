<div class="contactComponent">
    
    <form wire:submit.prevent="submit" class="contactForm">
        <div class="formCover">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-error">
                <p>{{ session('error') }}</p>
                <a href="{{route('login')}}" class="border-b text-sm">Cliquer pour vous connecter </a>
            </div>
            @endif
            <p class="section-subtitle">Besoin de nos services ?</p>
            <h3 class="section-title">Laissez-nous un message</h3>

            <div class="nom_phone">
                <div class="inputContent">
                    <label for="name">Nom</label>
                    <input type="text" id="name" wire:model.defer="name" class="form-control" placeholder="Mariam Sylla">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="inputContent">
                    <label for="phone">Téléphone</label>
                    <input type="number" id="phone" wire:model.defer="phone" class="form-control" placeholder="623849274">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="inputContent">
                <label for="email">Email</label>
                <input type="email" id="email" wire:model.defer="email" class="form-control" placeholder="mariam@gmail.com">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="inputContent">
                <label for="message">Message</label>
                <textarea wire:model.defer="message" class="form-control form-control_gray" placeholder="J'aurais besoin de votre aide pour..." cols="30" rows="8"></textarea>
                @error('message') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="">Envoyer</button>
        </div>
    </form>
</div>

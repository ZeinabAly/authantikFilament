<div>
    <div class="w-full text-left">
        @if(Session::has('success'))
            <p class="alert alert-success">{{Session::get('success')}}</p>
        @endif
        @if(Session::has('loginExige'))
            <div class="alert alert-error">
                <p>{{ session('loginExige') }}</p>
                <a href="{{route('login')}}" class="border-b text-sm p-0">Cliquer pour vous connecter </a>
            </div>
        @endif
        
    </div>
    <h2 class="reservation-accro">Réservation</h2>
    <h3 class="reservation-title">Preparez votre fête a l'avance</h3>
    <p class="reservation-texte">Appelez-nous au <span class="text-[--color2-yellow] font-bold">+224 629836668</span> ou remplissez ce formulaire</p>
    <form wire:submit.prevent="submit" class="w-[100%] relative">
        <div class="reservation-inputs">
            <div class="selectNbr champInput" style="grid-area: nbre">
                <select wire:model.defer="nbrPers">
                    <option value="">Nombre</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                @error('nbrPers')<span class="text-error">{{ $message }}</span>@enderror
            </div>
            

            <div style="grid-area: date" class="champInput" >
                <input type="date" wire:model.defer="date"  placeholder="Date * ">
                @error('date')<span class="text-error">{{ $message }}</span>@enderror
            </div>

            <div style="grid-area: heure" class="champInput">
                <input type="time" wire:model.defer="heure">
                @error('heure')<span class="text-error">{{ $message }}</span>@enderror
            </div>

            <div style="grid-area: nom" class="champInput">
                <input type="text" wire:model.defer="name" placeholder="Nom">
                @error('name')<span class="text-error">{{ $message }}</span>@enderror
            </div>

            <div style="grid-area: phone" class="champInput">
                <input type="number" wire:model.defer="phone" placeholder="Téléphone">
                @error('phone')<span class="text-error">{{ $message }}</span>@enderror
            </div>

            <div style="grid-area: email" class="champInput">
                <input type="email" wire:model.defer="email" placeholder="Email">
                @error('email')<span class="text-error">{{ $message }}</span>@enderror
            </div>

            <div style="grid-area: textearea" class="champInput">
                <textarea wire:model.defer="details" placeholder="Donnez quelques détails"></textarea>
                @error('details')<span class="text-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <button type="submit" class="btnPageRersever">Réserver</button>
    </form>
</div>

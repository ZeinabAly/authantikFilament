<div x-data="{ openReservation: false }" x-on:close-modal.window="openReservation = false" class="pageReservation" @open-reservation.window="openModalCmd = true">
    
    
    <!-- Bouton pour ouvrir -->
    <div class="reservation-btn" id="reservation-btn">
        <button @click="openReservation = true" class="w-full">
            <div class="btn btn-primary px-[20px] !important">
                <span class="text-sm ">Reserver maintenant</span>
            </div>
        </button>
    </div>

    <!-- Modal -->
    <div x-show="openReservation" x-cloak class="fixed inset-0 z-[500] bg-black/60 flex items-center justify-center" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
        
        <div @click.outside="openReservation = false" class="bg-white rounded-lg shadow-xl p-6 w-[90%] max-w-2xl relative">

            <!-- Close -->
            <button @click="openReservation = false" class="absolute top-3 right-4 text-gray-600 text-2xl">&times;</button>

            <h2 class="text-xl font-bold mb-4 mt-3">Réserver une table</h2>

            <form wire:submit.prevent="save" class="grid gap-3 sm:grid-cols-2">
                <div class="champInput col-span-2">
                    <select wire:model="nbrPers" class="w-full">
                        <option value="">Nombre de personnes</option>
                        @for($i= 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('nbrPers') <div class="text-red-500 col-span-2 text-sm space-y-1">{{ $message }}</div> @enderror
                </div>

                <div class="champInput">
                    <input type="date" wire:model="date" class="w-full">
                    @error('date') <div class="text-red-500 col-span-2 text-sm space-y-1">{{ $message }}</div> @enderror
                </div>

                <div class="champInput">
                    <input type="time" wire:model="heure" class="w-full">
                    @error('time') <div class="text-red-500 col-span-2 text-sm space-y-1">{{ $message }}</div> @enderror
                </div>

                <div class="champInput">
                    <input type="text" wire:model="name" placeholder="Nom" class="w-full">
                    @error('name') <div class="text-red-500 col-span-2 text-sm space-y-1">{{ $message }}</div> @enderror
                </div>

                <div class="champInput">
                    <input type="number" wire:model="phone" placeholder="Téléphone" class="w-full">
                    @error('phone') <div class="text-red-500 col-span-2 text-sm space-y-1">{{ $message }}</div> @enderror
                </div>

                <div class="champInput col-span-2">
                    <input type="email" wire:model="email" placeholder="Email" class="w-full">
                    @error('email') <div class="text-red-500 col-span-2 text-sm space-y-1">{{ $message }}</div> @enderror
                </div>

                <div class="champInput col-span-2">
                    <textarea wire:model="details" placeholder="Détails" class="w-full"></textarea>
                </div>

                <div class="col-span-2 flex justify-end gap-2 mt-4">
                    <button type="button" @click="openReservation = false" class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Réserver
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>

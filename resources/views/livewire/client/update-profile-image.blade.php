<div>
    <div class="text-center relative">


        <!-- Fenêtre modale -->
        <div x-data="{ open: false }" x-cloak class="relative">
            <!-- Bouton pour ouvrir la popup -->
            <div class=" flexColumn gap-4">
                @if($user->id === auth()->user()->id)
                    <button @click="open = !open" class="btnCommander text-xs md:text-sm">
                        Modifier la photo
                    </button>
                @endif
            </div>

            <div class="photoModaleContainer" x-show="open" @click.outside="open = false">
                <form wire:submit="save">   
                    <div class="formContent" style="transform: translateX(50%)">
                        <h2 class="photoTitre">Changer votre photo de profil</h2>
        
                        <!-- Aperçu de l'image sélectionnée -->
                        <div class="apercuImgBox">
                            <!-- Preview box -->
                            <div id="previewContainer" class="previewContainer">
                                @if(auth()->user()->image)
                                    <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Photo actuelle" class="object-cover" loading="lazy" />
                                @else
                                    <span class="text-gray-400 text-sm">Aperçu</span>
                                @endif
                            </div>

                            <!-- Input file -->
                            <input 
                                type="file" 
                                id="photoInput" 
                                name="photo"
                                class="photoInput"
                            >
                        </div>

                        <!-- Messages d'erreur -->
                        @error('photo') 
                            <p class="text-red-500 text-sm">{{ $message }}</p> 
                        @enderror
        
                        <!-- Boutons -->
                        <div class="btnsContent">
                            <button @click="open = false" class="btnCommander btnAnnuler">
                                Annuler
                            </button>
                            <button type="submit" wire:submit="save" class="btnCommander" @click.debounce.500ms="open = !open" >
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

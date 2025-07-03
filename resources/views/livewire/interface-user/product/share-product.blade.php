<div>
    <!-- 1. Champ de copie du lien -->
    <!-- <div class="flex items-center space-x-2">
        <input id="shareLink" type="text" readonly 
            value="{{ $shareUrl }}"
            class="flex-1 px-3 py-2 border rounded-md text-gray-700"
        />
        <button onclick="navigator.clipboard.writeText(document.getElementById('shareLink').value)"
                class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
        Copier
        </button>
    </div> -->

  <!-- 2. Boutons de partage social -->
    <div class="flex justify-center md:justify-start gap-3 py-3">
        <p class="font-bold uppercase">Partager sur : </p>
        <ul class="flexLeft gap-3">
            <!-- Facebook -->
            <li>
            <a href="{{ $shareLinks['facebook'] }}"
                target="_blank" rel="noopener"
                class="text-blue-600 hover:text-blue-800" title="Partager sur Facebook">
                <x-icon name="facebook" fill="#1877F2" size="18" />
            </a>
            </li>
            <!-- Twitter -->
            <li>
            <a href="{{ $shareLinks['twitter'] }}"
                target="_blank" rel="noopener"
                class="text-sky-500 hover:text-sky-700" title="Partager sur Twitter">
                <x-icon name="x-twitter" fill="#000" size="18" />
            </a>
            </li>
            <!-- WhatsApp -->
            <li>
            <a href="{{ $shareLinks['whatsapp'] }}"
                target="_blank" rel="noopener"
                class="text-green-500 hover:text-green-700" title="Partager sur WhatsApp">
                <x-icon name="whatsapp" fill="#25D366" size="18" />
            </a>
            </li>
            <!-- Instagram -->
            
            <!-- Ajoutez d'autres réseaux si besoin -->
        </ul>
    </div>

    <div style="background: yellow; padding: 10px; margin: 10px;">
        <p><strong>Share URL:</strong> {{ $shareUrl }}</p>
        <p><strong>Product Name:</strong> {{ $product->name }}</p>
        <p><strong>Product Image:</strong> {{ asset('storage/'.$product->image) }}</p>
        <p><strong>Image exists:</strong> {{ file_exists(public_path('storage/'.$product->image)) ? 'OUI' : 'NON' }}</p>
    </div>
</div>


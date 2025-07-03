<div>
    <style>
        .fi-main{
            background: #f4f4f4;
        }
        .param-container {
            width: 100% ;
            min-height: 100vh;
            background: #fff;
            border: 1px solid rgb(207, 207, 206);
            box-shadow: 2px 2px 2px #bebbbb7d, -2px -2px 2px #bebbbb7d;
            border-radius: 10px;
            margin-top: 0;
        }
        .dark .param-container {
            background: #18181b;
            border: 1px solid #1d1d1d;
            box-shadow: 2px 2px 2px #070606, -2px -2px 2px #070606;
        }

        .header {
            background: #e3e3e3;
            color: #000;
            padding: 2rem;
            border-radius: 10px 10px 0 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .dark .header {
            background: #0f0f0fbd;
            color: #fff;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 2rem;
        }

        .tabs {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            border-bottom: 2px solid #f1f5f9;
            margin-bottom: 2rem;
            overflow-x: auto;
            gap: 5px;
            flex-wrap: nowrap !important;
        }

        .dark .tabs {
            border-bottom: 2px solid #5f6062;
        }

        .tab {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color:rgb(34, 34, 34);
            transition: all 0.3s ease;
            border-radius: 8px 8px 0 0;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark .tab {
            color: #d6d6d6;
        }

        .tab.active {
            color: #fbbf24;
            background: #bda05614;
            border-bottom: 3px solid #fbbf24;
        }

        .tab:hover:not(.active) {
            background: #bda05614;
            color: #fbbf24;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-section {
            background: #f4f4f4;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgb(97 95 95 / 25%);
        }

        .dark .form-section {
            background: #222222;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark .section-title {
            color: #fff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        .dark label {
            color:rgb(225, 225, 225);
        }

        .form-group input, .form-group textarea, .form-group select {
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #fff;
            width: 100%;
            padding: 0.875rem 1rem;
        }
        .dark .form-group input, .dark .form-group textarea, .dark .form-group select {
            border: 1px solid #0d0c0c;
            background: #18181b;
            color: #fff;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
            transform: translateY(-1px);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .color-input-group {
            display: flex;
            gap: 1rem;
            align-items: end;
        }

        .color-input {
            flex: 1;
        }

        .color-preview {
            width: 50px;
            height: 44px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-preview:hover {
            transform: scale(1.1);
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: block;
            padding: 2rem;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .dark .file-upload-label {
            background: #18181b;
            border-color: #4a5568;
            color: #d6d6d6;
        }

        .file-upload-label:hover {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.05);
        }

        .social-links {
            /* display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); */
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .social-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .facebook { background: #1877f2; padding: 0 10px;}
        .instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); padding: 0 10px; }
        .twitter { background: #000; padding: 0 10px;}
        .tiktok { background: #000; padding: 0 10px;}
        .snapchat { background: #ce9c2d; padding: 0 10px; }

        .save-button {
            background: linear-gradient(135deg, #ffbf24, #e0a20e);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 7px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 2rem auto 0;
            position: relative;
            overflow: hidden;
        }

        .save-button:hover {
            background: linear-gradient(135deg,rgb(146, 104, 4), #e0a20e);
            box-shadow: 3px 3px 5px #e0a20e inset;
            transition: 0.4s;
        }

        .save-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .preview-section {
            background: #f4f4f4;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            margin-top: 2rem;
            border: 1px solid rgb(97 95 95 / 25%)
        }

        .dark .preview-section {
            background: #222222;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            margin-top: 2rem;
        }

        .restaurant-preview {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin: 1rem 0;
        }

        .dark .restaurant-preview {
            background: #18181b;
            border: 1px solid rgb(97 95 95 / 25%)
        }

        .logo-preview {
            width: 80px;
            height: 80px;
            background:rgb(192, 192, 192);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #64748b;
        }

        .dark .logo-preview {
            background:rgb(40, 40, 40);
        }

        .message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .message.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .message.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .file-info {
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: #f0f9ff;
            border-radius: 6px;
            font-size: 0.875rem;
            color: #0369a1;
        }

        .dark .file-info {
            background: #1e293b;
            color: #38bdf8;
        }

        .remove-file-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            cursor: pointer;
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            .param-container {
                margin: 0;
                border-radius: 0;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .tabs {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .color-input-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .social-links {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div>
        <div class="param-container">
            <div class="header">
                <h1><i class="fas fa-utensils"></i> Réglages Restaurant</h1>
                <p>Configuration de tous les aspects du restaurant</p>
            </div>

            <div class="content">
                @if($message)
                    <div class="message {{ $messageType }}" wire:click="clearMessage">
                        {{ $message }}
                    </div>
                @endif

                <div class="tabs">
                    <button class="tab {{ $activeTab === 'general' ? 'active' : '' }}" 
                            wire:click="setActiveTab('general')">
                        <x-icon name="parametres" />
                        <span>Général</span> 
                    </button>
                    <button class="tab {{ $activeTab === 'design' ? 'active' : '' }}" 
                            wire:click="setActiveTab('design')">
                        <!-- <x-icon name="palette-couleur" fill="#ccc" /> -->
                        <span>Design</span>
                    </button>
                    <button class="tab {{ $activeTab === 'menu' ? 'active' : '' }}" 
                            wire:click="setActiveTab('menu')">
                        <i class="fas fa-book-open"></i> Menu
                    </button>
                    <button class="tab {{ $activeTab === 'social' ? 'active' : '' }}" 
                            wire:click="setActiveTab('social')">
                        <i class="fas fa-share-alt"></i> Réseaux
                    </button>
                    <button class="tab {{ $activeTab === 'facebook' ? 'active' : '' }}" 
                            wire:click="setActiveTab('facebook')"> 
                            Videos facebook
                    </button>
                    <button class="tab {{ $activeTab === 'contact' ? 'active' : '' }}" 
                            wire:click="setActiveTab('contact')">
                        <i class="fas fa-map-marker-alt"></i> Contact
                    </button>
                </div>

                <!-- Général -->
                <div class="tab-content {{ $activeTab === 'general' ? 'active' : '' }}">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle" style="color: #3b82f6;"></i>
                            Informations générales
                        </h3>
                        <div class="form-group">
                            <label for="restaurant-name">Nom du restaurant</label>
                            <input type="text" id="restaurant-name" wire:model="name" placeholder="AUTHANTIK">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tagline">Slogan / Tagline</label>
                            <input type="text" id="tagline" wire:model="slogan" placeholder="Une cuisine authentique depuis 1950">
                            @error('slogan') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" wire:model="description" placeholder="Découvrez notre cuisine traditionnelle française dans un cadre chaleureux..."></textarea>
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Design -->
                <div class="tab-content {{ $activeTab === 'design' ? 'active' : '' }}">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-image" style="color: #8b5cf6;"></i>
                            Logo et Images
                        </h3>
                        <div class="form-group">
                            <label>Logo principal</label>
                            @if($settings->logo_path)
                                <div class="file-info">
                                    <i class="fas fa-image"></i> Logo actuel: {{ basename($settings->logo_path) }}
                                    <button type="button" class="remove-file-btn" wire:click="removeLogo">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </div>
                            @endif
                            <div class="file-upload">
                                <input type="file" wire:model="logo" accept="image/*">
                                <div class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #64748b; margin-bottom: 0.5rem;"></i>
                                    <p>Cliquez pour télécharger votre logo</p>
                                    <small style="color: #64748b;">PNG, JPG jusqu'à 2MB</small>
                                </div>
                            </div>
                            @error('logo') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-palette" style="color: #ec4899;"></i>
                            Couleurs du thème
                        </h3>
                        <div class="form-group">
                            <label>Couleur principale</label>
                            <div class="color-input-group">
                                <div class="color-input">
                                    <input type="text" wire:model="primary_color" placeholder="#ff6b6b">
                                </div>
                                <input type="color" class="color-preview" wire:model="primary_color">
                            </div>
                            @error('primary_color') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Couleur secondaire</label>
                            <div class="color-input-group">
                                <div class="color-input">
                                    <input type="text" wire:model="secondary_color" placeholder="#4ecdc4">
                                </div>
                                <input type="color" class="color-preview" wire:model="secondary_color">
                            </div>
                            @error('secondary_color') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Couleur d'accent</label>
                            <div class="color-input-group">
                                <div class="color-input">
                                    <input type="text" wire:model="accent_color" placeholder="#ffd93d">
                                </div>
                                <input type="color" class="color-preview" wire:model="accent_color">
                            </div>
                            @error('accent_color') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Menu -->
                <div class="tab-content {{ $activeTab === 'menu' ? 'active' : '' }}">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-utensils" style="color: #f59e0b;"></i>
                            Configuration du menu
                        </h3>
                        <div class="form-group">
                            <label>Menu PDF</label>
                            @if($settings->menu_pdf_path)
                                <div class="file-info">
                                    <i class="fas fa-file-pdf"></i> Menu actuel: {{ basename($settings->menu_pdf_path) }}
                                    <button type="button" class="remove-file-btn" wire:click="removeMenuPdf">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </div>
                            @endif
                            <div class="file-upload">
                                <input type="file" wire:model="menu_pdf" accept=".pdf">
                                <div class="file-upload-label">
                                    <i class="fas fa-file-pdf" style="font-size: 2rem; color: #dc2626; margin-bottom: 0.5rem;"></i>
                                    <p>Téléchargez votre menu PDF</p>
                                    <small style="color: #64748b;">PDF jusqu'à 5MB</small>
                                </div>
                            </div>
                            @error('menu_pdf') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="menu-link">Lien vers le menu en ligne</label>
                            <input type="url" id="menu-link" wire:model="menu_link" placeholder="https://votre-site.com/menu">
                            @error('menu_link') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="special-offers">Offres spéciales</label>
                            <textarea id="special-offers" wire:model="special_offers" placeholder="Menu du jour à 15€&#10;Happy Hour: 17h-19h, cocktails à -30%"></textarea>
                            @error('special_offers') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Réseaux sociaux -->
                <div class="tab-content {{ $activeTab === 'social' ? 'active' : '' }}">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-hashtag" style="color: #06b6d4;"></i>
                            Liens des réseaux sociaux
                        </h3>
                        <div class="social-links">
                            <div class="social-item">
                                <div class="social-icon facebook">
                                    <x-icon name="facebook" fill="#fff" />
                                </div>
                                <input type="url" wire:model="facebook_url" placeholder="https://facebook.com/votre-restaurant">
                            </div>
                            <div class="social-item">
                                <div class="social-icon instagram">
                                    <x-icon name="instagram" fill="#fff" />
                                </div>
                                <input type="url" wire:model="instagram_url" placeholder="https://instagram.com/votre-restaurant">
                            </div>
                            <div class="social-item">
                                <div class="social-icon twitter">
                                    <x-icon name="x-twitter" fill="#fff" />
                                </div>
                                <input type="url" wire:model="twitter_url" placeholder="https://twitter.com/votre-restaurant">
                            </div>
                            <div class="social-item">
                                <div class="social-icon tiktok">
                                    <x-icon name="tiktok" fill="#fff" />
                                </div>
                                <input type="url" wire:model="tiktok_url" placeholder="https://tiktok.com/@votre-restaurant">
                            </div>
                            <div class="social-item">
                                <div class="social-icon snapchat">
                                    <x-icon name="snapchat" fill="#fff" />
                                </div>
                                <input type="url" wire:model="snapchat_url" placeholder="https://snapchat.com/@votre-restaurant">
                            </div>
                        </div>
                        @error('facebook_url') <span class="error">{{ $message }}</span> @enderror
                        @error('instagram_url') <span class="error">{{ $message }}</span> @enderror
                        @error('twitter_url') <span class="error">{{ $message }}</span> @enderror
                        @error('tiktok_url') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Videos  facebook -->
                <div class="tab-content {{ $activeTab === 'facebook' ? 'active' : '' }}">
                    <div class="form-section">
                        <h3 class="section-title">Intégrer les vidéos Facebook</h3>

                        @for($i = 0; $i < 3; $i++)
                            <div class="form-group">
                                <label for="video{{ $i }}">Vidéo {{ $i + 1 }}</label>
                                <input type="url" id="video{{ $i }}" wire:model="facebookVideos.{{ $i }}" placeholder="Lien de la vidéo Facebook">
                                @error("facebookVideos.$i") <span class="error">{{ $message }}</span> @enderror
                            </div>
                        @endfor
                    </div>

                </div>

                <!-- Contact -->
                <div class="tab-content {{ $activeTab === 'contact' ? 'active' : '' }}">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-phone" style="color: #10b981;"></i>
                            Informations de contact
                        </h3>
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" id="phone" wire:model="phone" placeholder="+224 621738183">
                            @error('phone') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" wire:model="email" placeholder="contact@restaurant.com">
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Adresse complète</label>
                            <textarea id="address" wire:model="address" placeholder="Dixinn Terasse"></textarea>
                            @error('address') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="maps-link">Lien Google Maps</label>
                            <input type="url" id="maps-link" wire:model="maps_link" placeholder="https://maps.google.com/...">
                            @error('maps_link') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-motorcycle" style="color: #f97316;"></i>
                            Livraison
                        </h3>
                        <div class="form-group">
                            <label for="delivery-zone">Zone de livraison</label>
                            <input type="text" id="delivery-zone" wire:model="delivery_zone" placeholder="Dans un rayon de 5km">
                            @error('delivery_zone') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="delivery-apps">Applications de livraison</label>
                            <textarea id="delivery-apps" wire:model="delivery_apps" placeholder="Uber Eats, Deliveroo, Just Eat"></textarea>
                            @error('delivery_apps') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Aperçu -->
                <div class="preview-section">
                    <h3 style="margin-bottom: 1rem; color: #374151;">
                        <i class="fas fa-eye"></i> Aperçu
                    </h3>
                    <div class="restaurant-preview">
                        <div class="logo-preview">
                            @if($settings->logo_path)
                                <img src="{{ $settings->logo_url }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="fas fa-utensils"></i>
                            @endif
                        </div>
                        <h2 style="margin-bottom: 0.5rem; color:rgb(216, 216, 216);">{{ $name ?: 'Nom du Restaurant' }}</h2>
                        <p style="color: #747678; font-style: italic;">{{ $slogan ?: 'Votre slogan apparaîtra ici' }}</p>
                    </div>
                </div>

                <button class="save-button" wire:click="saveSettings">
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </div>

    <script>
        // Preview des couleurs en temps réel
        document.addEventListener('livewire:updated', () => {
            const primaryColor = document.querySelector('input[wire\\:model="primary_color"]');
            const secondaryColor = document.querySelector('input[wire\\:model="secondary_color"]');
            const accentColor = document.querySelector('input[wire\\:model="accent_color"]');
            
            if (primaryColor && primaryColor.value) {
                document.documentElement.style.setProperty('--primary-color', primaryColor.value);
            }
            if (secondaryColor && secondaryColor.value) {
                document.documentElement.style.setProperty('--secondary-color', secondaryColor.value);
            }
            if (accentColor && accentColor.value) {
                document.documentElement.style.setProperty('--accent-color', accentColor.value);
            }
        });
    </script>
</div>

<section class="sectionEquipe">
  
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .sectionEquipe {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #025239 0%, #2d4a3e 25%, #4a6b5c 50%, #ce9c2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .carousel-section {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .section-header::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            border-radius: 2px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.7; transform: translateX(-50%) scaleX(1); }
            50% { opacity: 1; transform: translateX(-50%) scaleX(1.2); }
        }

        .main-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .main-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            max-width: 500px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .carousel-track {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            position: relative;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            gap: 2rem;
            padding: 0 2rem;
        }

        .member-slide {
            position: relative;
            flex-shrink: 0;
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: pointer;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .member-slide.center {
            width: 280px;
            height: 320px;
            transform: scale(1.1) translateZ(0);
            z-index: 3;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .member-slide.side {
            width: 220px;
            height: 260px;
            transform: scale(0.85) translateZ(0);
            opacity: 0.7;
            z-index: 2;
        }

        .member-slide.far {
            width: 180px;
            height: 220px;
            transform: scale(0.7) translateZ(0);
            opacity: 0.4;
            z-index: 1;
        }

        .member-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 2rem auto 1rem;
            position: relative;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .center .member-avatar {
            width: 140px;
            height: 140px;
            border-width: 4px;
        }

        .member-avatar::before {
            content: '';
            position: absolute;
            z-index: -2;
            inset: 0;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            border-radius: 50%;
            animation: rotate 4s linear infinite;
        }

        .member-avatar::after {
            content: attr(data-initials);
            position: absolute;
            /* z-index: 0; */
            inset: 3px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            z-index: -1;
        }

        .center .member-avatar::after {
            font-size: 2.2rem;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .member-info {
            text-align: center;
            padding: 0 1.5rem 2rem;
        }

        .member-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease 0.1s;
        }

        .center .member-name {
            font-size: 1.5rem;
            opacity: 1;
            transform: translateY(0);
        }

        .member-role {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease 0.2s;
        }

        .center .member-role {
            opacity: 1;
            transform: translateY(0);
        }

        .carousel-nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
        }

        .nav-button {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.5rem;
            user-select: none;
        }

        .nav-button:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            color: white;
            transform: scale(1.1);
        }

        .nav-button:active {
            transform: scale(0.95);
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: rgba(255, 255, 255, 0.9);
            transform: scale(1.3);
        }

        .cta-section {
            text-align: center;
            margin-top: 3rem;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: white;
            color: linear-gradient(135deg, #025239 0%, #2d4a3e 25%, #4a6b5c 50%, #ce9c2d 100%);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2.2rem;
            }
            
            .carousel-container {
                height: 350px;
            }
            
            .member-slide.center {
                width: 240px;
                height: 280px;
            }
            
            .member-slide.side {
                width: 180px;
                height: 220px;
            }
            
            .member-slide.far {
                display: none;
            }
        }
    </style>

    <div class="carousel-section">
        <div class="section-header">
            <h2 class="main-title">Rencontrez Notre Équipe</h2>
            <p class="main-subtitle">Les experts passionnés qui transforment chaque bouchée en expérience inoubliouable</p>
        </div>

        <div class="carousel-container">
            <div class="carousel-track" id="carouselTrack">
                @foreach($employees as $employee)
                <div class="member-slide" data-index="0">
                    <div class="member-avatar" data-initials="MR">
                    <!-- <div class="member-avatar"> -->
                    <img src="{{asset('storage/'.$employee->image)}}" alt="" class="w-full h-full object-cover rounded-full absolute z-4" loading="lazy" />

                    </div>
                    <div class="member-info">
                        <h3 class="member-name">{{$employee->name}}</h3>
                        <p class="member-role">{{$employee->fonction}}</p>
                    </div>
                </div>
                @endforeach

                <!-- <div class="member-slide center" data-index="1">
                    <div class="member-avatar" data-initials="JD"></div>
                    <div class="member-info">
                        <h3 class="member-name">Jean Dubois</h3>
                        <p class="member-role">Professeur de Technologie</p>
                    </div>
                </div> -->

                <!-- <div class="member-slide" data-index="2">
                    <div class="member-avatar" data-initials="SL"></div>
                    <div class="member-info">
                        <h3 class="member-name">Sophie Laurent</h3>
                        <p class="member-role">Responsable Design</p>
                    </div>
                </div>

                <div class="member-slide" data-index="3">
                    <div class="member-avatar" data-initials="AM"></div>
                    <div class="member-info">
                        <h3 class="member-name">Antoine Martin</h3>
                        <p class="member-role">Coordinateur Projets</p>
                    </div>
                </div>

                <div class="member-slide" data-index="4">
                    <div class="member-avatar" data-initials="CB"></div>
                    <div class="member-info">
                        <h3 class="member-name">Claire Bertrand</h3>
                        <p class="member-role">Conseillère Orientation</p>
                    </div>
                </div>

                <div class="member-slide" data-index="5">
                    <div class="member-avatar" data-initials="PR"></div>
                    <div class="member-info">
                        <h3 class="member-name">Pierre Roux</h3>
                        <p class="member-role">Professeur Business</p>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="carousel-nav">
            <button class="nav-button" id="prevBtn">‹</button>
            <button class="nav-button" id="nextBtn">›</button>
        </div>

        <div class="carousel-dots" id="dotsContainer"></div>

        <div class="cta-section">
            <a href="{{route('home.about')}}" class="cta-button">
                Découvrir toute l'équipe
                <span>→</span>
            </a>
        </div>
    </div>

    <script>
        class TeamCarousel {
            constructor() {
                this.currentIndex = 1; // Commence par le deuxième élément au centre
                this.slides = document.querySelectorAll('.member-slide');
                this.totalSlides = this.slides.length;
                this.autoPlayInterval = null;
                
                this.init();
            }

            init() {
                this.createDots();
                this.bindEvents();
                this.updateCarousel();
                this.startAutoPlay();
            }

            createDots() {
                const dotsContainer = document.getElementById('dotsContainer');
                for (let i = 0; i < this.totalSlides; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'dot';
                    if (i === this.currentIndex) dot.classList.add('active');
                    dot.addEventListener('click', () => this.goToSlide(i));
                    dotsContainer.appendChild(dot);
                }
            }

            bindEvents() {
                document.getElementById('prevBtn').addEventListener('click', () => this.prevSlide());
                document.getElementById('nextBtn').addEventListener('click', () => this.nextSlide());
                
                // Pause auto-play on hover
                const container = document.querySelector('.carousel-container');
                container.addEventListener('mouseenter', () => this.pauseAutoPlay());
                container.addEventListener('mouseleave', () => this.startAutoPlay());

                // Click on slides to navigate
                this.slides.forEach((slide, index) => {
                    slide.addEventListener('click', () => {
                        if (!slide.classList.contains('center')) {
                            this.goToSlide(index);
                        }
                    });
                });
            }

            updateCarousel() {
                this.slides.forEach((slide, index) => {
                    slide.classList.remove('center', 'side', 'far');
                    
                    const distance = Math.abs(index - this.currentIndex);
                    
                    if (index === this.currentIndex) {
                        slide.classList.add('center');
                    } else if (distance === 1) {
                        slide.classList.add('side');
                    } else {
                        slide.classList.add('far');
                    }
                });

                // Update dots
                document.querySelectorAll('.dot').forEach((dot, index) => {
                    dot.classList.toggle('active', index === this.currentIndex);
                });
            }

            nextSlide() {
                this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
                this.updateCarousel();
            }

            prevSlide() {
                this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
                this.updateCarousel();
            }

            goToSlide(index) {
                this.currentIndex = index;
                this.updateCarousel();
                this.restartAutoPlay();
            }

            startAutoPlay() {
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 4000);
            }

            pauseAutoPlay() {
                if (this.autoPlayInterval) {
                    clearInterval(this.autoPlayInterval);
                }
            }

            restartAutoPlay() {
                this.pauseAutoPlay();
                this.startAutoPlay();
            }
        }

        // Initialize carousel when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new TeamCarousel();
        });
    </script>
</section>


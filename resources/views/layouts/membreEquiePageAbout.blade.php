<div class="pageAboutEquipe">
    
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .aboutTeamMember {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg,rgb(5, 66, 5) 0%, #2d4a3e 25%,rgb(38, 27, 4) 50%,rgb(3, 66, 19) 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .team-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .team-header {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .team-header::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            border-radius: 2px;
            animation: glow 2s infinite alternate;
        }

        @keyframes glow {
            from { box-shadow: 0 0 10px rgba(255, 107, 107, 0.3); }
            to { box-shadow: 0 0 20px rgba(78, 205, 196, 0.3); }
        }

        .team-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .team-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .member-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
        }

        .member-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .member-card:hover::before {
            left: 100%;
        }

        .member-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .member-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            position: relative;
            overflow: hidden;
            border: 4px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .member-avatar img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .member-card:hover .member-avatar {
            border-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.1);
        }

        .member-avatar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            border-radius: 50%;
            animation: rotate 3s linear infinite;
            z-index: -2;
        }

        .member-avatar::after {
            content: attr(data-initials);
            position: absolute;
            inset: 4px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            z-index: -1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .member-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .member-role {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .member-description {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .member-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .skill-tag {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .member-card:hover .skill-tag {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .member-contact {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .contact-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .contact-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            color: white;
            transform: translateY(-2px);
        }

        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 30%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @media (max-width: 768px) {
            .team-title {
                font-size: 2.5rem;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .member-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
   
   <article class="aboutTeamMember">
       <div class="floating-shapes">
           <div class="shape" style="width: 100px; height: 100px; background: linear-gradient(45deg, #ff6b6b, #4ecdc4); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;"></div>
           <div class="shape" style="width: 80px; height: 80px; background: linear-gradient(45deg, #45b7d1, #96ceb4); border-radius: 50%;"></div>
           <div class="shape" style="width: 120px; height: 120px; background: linear-gradient(45deg, #f093fb, #f5576c); border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;"></div>
       </div>
   
       <section class="team-section">
           <div class="team-header">
               <h2 class="team-title">Notre Équipe</h2>
               <p class="team-subtitle">Derrière chaque plat savoureux et chaque service attentionné, se cache une équipe engagée, dynamique et passionnée. Cuisiniers, serveurs, livreurs, responsables de salle…</p>
           </div>
   
           <div class="team-grid">
                @foreach($employees as $employee)
               <div class="member-card">
                   <div class="member-avatar" data-initials="MR">
                        <img src="{{asset('storage/'.$employee->image)}}" alt="" class="" loading="lazy" />
                   </div>
                   <h3 class="member-name">{{$employee->name}}</h3>
                   <p class="member-role">{{$employee->fonction}}</p>
                   <p class="member-description">{{$employee->description ?? "Passionnée par la restauration, $employee->name transforme chaque plat en oeuvre d\'art"}}</p>
                   <div class="member-skills">
                        @if($employee->competences)
                            @foreach(json_decode($employee->competences) as $comp)
                            <span class="skill-tag">{{$comp}}</span>
                            @endforeach
                        @endif
                   </div>
                   <div class="member-contact">
                       <a href="{{$employee->facebook}}" class="contact-btn">
                            <x-icon name="facebook" fill="#4dabf7" size="18" />
                       </a>
                       <a href="{{$employee->instagram}}" class="contact-btn">
                            <x-icon name="instagram" fill="#fd7e14" size="18" />
                       </a>
                       <a href="{{$employee->snapchat}}" class="contact-btn">
                            <x-icon name="snapchat" fill="#ffd43b" size="18" />
                       </a>
                   </div>
               </div>
               @endforeach
   
               <!-- <div class="member-card">
                   <div class="member-avatar" data-initials="JD"></div>
                   <h3 class="member-name">Jean Dubois</h3>
                   <p class="member-role">Professeur de Technologie</p>
                   <p class="member-description">Expert en développement logiciel et intelligence artificielle, Jean forme la nouvelle génération de développeurs avec une approche pratique et moderne.</p>
                   <div class="member-skills">
                       <span class="skill-tag">IA</span>
                       <span class="skill-tag">Développement</span>
                       <span class="skill-tag">Mentoring</span>
                   </div>
                   <div class="member-contact">
                       <a href="#" class="contact-btn">📧</a>
                       <a href="#" class="contact-btn">🐱</a>
                   </div>
               </div>
   
               <div class="member-card">
                   <div class="member-avatar" data-initials="SL"></div>
                   <h3 class="member-name">Sophie Laurent</h3>
                   <p class="member-role">Responsable Design</p>
                   <p class="member-description">Créative visionnaire, Sophie enseigne le design thinking et accompagne les étudiants dans leurs projets créatifs les plus ambitieux.</p>
                   <div class="member-skills">
                       <span class="skill-tag">UI/UX</span>
                       <span class="skill-tag">Créativité</span>
                       <span class="skill-tag">Prototypage</span>
                   </div>
                   <div class="member-contact">
                       <a href="#" class="contact-btn">📧</a>
                       <a href="#" class="contact-btn">🎨</a>
                   </div>
               </div>
   
               <div class="member-card">
                   <div class="member-avatar" data-initials="AM"></div>
                   <h3 class="member-name">Antoine Martin</h3>
                   <p class="member-role">Coordinateur Projets</p>
                   <p class="member-description">Spécialiste en gestion de projet agile, Antoine coordonne les collaborations avec l'industrie et supervise les projets étudiants.</p>
                   <div class="member-skills">
                       <span class="skill-tag">Agile</span>
                       <span class="skill-tag">Coordination</span>
                       <span class="skill-tag">Industrie</span>
                   </div>
                   <div class="member-contact">
                       <a href="#" class="contact-btn">📧</a>
                       <a href="#" class="contact-btn">💼</a>
                   </div>
               </div>
   
               <div class="member-card">
                   <div class="member-avatar" data-initials="CB"></div>
                   <h3 class="member-name">Claire Bertrand</h3>
                   <p class="member-role">Conseillère Orientation</p>
                   <p class="member-description">Accompagnatrice bienveillante, Claire aide nos étudiants à construire leur parcours professionnel et à révéler leur potentiel unique.</p>
                   <div class="member-skills">
                       <span class="skill-tag">Coaching</span>
                       <span class="skill-tag">Orientation</span>
                       <span class="skill-tag">Développement</span>
                   </div>
                   <div class="member-contact">
                       <a href="#" class="contact-btn">📧</a>
                       <a href="#" class="contact-btn">🌟</a>
                   </div>
               </div>
   
               <div class="member-card">
                   <div class="member-avatar" data-initials="PR"></div>
                   <h3 class="member-name">Pierre Roux</h3>
                   <p class="member-role">Professeur Business</p>
                   <p class="member-description">Entrepreneur expérimenté, Pierre partage sa passion pour l'innovation business et l'entrepreneuriat avec nos futurs leaders.</p>
                   <div class="member-skills">
                       <span class="skill-tag">Business</span>
                       <span class="skill-tag">Entrepreneuriat</span>
                       <span class="skill-tag">Stratégie</span>
                   </div>
                   <div class="member-contact">
                       <a href="#" class="contact-btn">📧</a>
                       <a href="#" class="contact-btn">🚀</a>
                   </div>
               </div> -->
           </div>
       </section>
   </article>

    <script>
        // Animation d'apparition progressive des cartes
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        }, observerOptions);

        // Initialisation des animations
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.member-card');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Effet de parallaxe sur les formes flottantes
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const shapes = document.querySelectorAll('.shape');
                shapes.forEach((shape, index) => {
                    const speed = 0.5 + (index * 0.1);
                    shape.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
                });
            });
        });
    </script>
</div>
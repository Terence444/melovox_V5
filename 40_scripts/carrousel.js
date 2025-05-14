document.addEventListener('DOMContentLoaded', function() {
            // Chemins des images
            const images = [
                "../60_visuels/icon/users icons/alexia.png",
                "../60_visuels/icon/users icons/Catalia.png",
                "../60_visuels/icon/users icons/charles.png",
                "../60_visuels/icon/users icons/DJ_alfonso.png",
                "../60_visuels/icon/users icons/Lorde.png",
                "../60_visuels/icon/users icons/lil_jordan.png",
                "../60_visuels/icon/users icons/Sade.png",
                "../60_visuels/icon/users icons/Orisa.png"
            ];
            
            const carousel = document.getElementById('carousel');
            const dotsContainer = document.getElementById('carousel-dots');
            const totalImages = images.length;
            let currentIndex = 0;
            let items = [];
            let dots = [];
            
            // Création des éléments du carrousel
            function createCarouselItems() {
                // Vider le carrousel
                carousel.innerHTML = '';
                dotsContainer.innerHTML = '';
                items = [];
                dots = [];
                
                // Créer tous les éléments du carrousel
                for (let i = 0; i < totalImages; i++) {
                    const item = document.createElement('div');
                    item.className = 'carousel-item';
                    
                    const img = document.createElement('img');
                    img.src = images[i];
                    img.alt = `Image ${i+1}`;
                    
                    item.appendChild(img);
                    carousel.appendChild(item);
                    items.push(item);
                    
                    // Créer les points indicateurs
                    const dot = document.createElement('div');
                    dot.className = 'dot';
                    dot.addEventListener('click', () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                    dots.push(dot);
                }
                
                updateCarousel();
            }
            
            // Mise à jour de l'état du carrousel
            function updateCarousel() {
                // Réinitialiser les classes
                items.forEach(item => {
                    item.className = 'carousel-item';
                });
                
                dots.forEach((dot, index) => {
                    dot.className = index === currentIndex ? 'dot active' : 'dot';
                });
                
                // Définir les classes actives
                for (let i = -2; i <= 2; i++) {
                    const index = (currentIndex + i + totalImages) % totalImages;
                    items[index].classList.add(`active-${i+3}`);
                    
                    // Appliquer l'animation de fondu pour les éléments qui disparaissent/apparaissent
                    if (i === -2 || i === 2) {
                        items[index].style.transition = 'all 0.5s ease';
                    }
                }
            }
            
            // Navigation vers une diapositive spécifique
            function goToSlide(index) {
                currentIndex = index;
                updateCarousel();
            }
            
            // Navigation vers la diapositive suivante
            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalImages;
                updateCarousel();
            }
            
            // Navigation vers la diapositive précédente
            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateCarousel();
            }
            
            // Ajout des événements pour les boutons de navigation
            document.querySelector('.next-btn').addEventListener('click', nextSlide);
            document.querySelector('.prev-btn').addEventListener('click', prevSlide);
            
            // Navigation au clavier
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    nextSlide();
                } else if (e.key === 'ArrowLeft') {
                    prevSlide();
                }
            });
            
            // Initialisation du carrousel
            createCarouselItems();
            
            // Défilement automatique optionnel
            // setInterval(nextSlide, 5000);
        });
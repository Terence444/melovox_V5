<?php
// Fichier: 20_includes/cookie_banner.php
?>

<!-- Bannière de cookies pour MÉLOVOX -->
<div class="cookie-banner" id="cookieBanner">
    <div class="cookie-content">
        <div class="cookie-text">
            <h3>🍪 Nous utilisons des cookies</h3>
            <p>
                MÉLOVOX utilise des cookies pour améliorer votre expérience musicale, 
                analyser l'utilisation du site et personnaliser vos recommandations. 
                <a href="#" onclick="showCookieSettings()">En savoir plus</a>
            </p>
        </div>
        <div class="cookie-actions">
            <button class="cookie-btn decline" onclick="declineCookies()">
                Refuser
            </button>
            <button class="cookie-btn settings" onclick="showCookieSettings()">
                Paramètres
            </button>
            <button class="cookie-btn accept" onclick="acceptCookies()">
                Accepter tout
            </button>
        </div>
    </div>
</div>

<style>
/* Styles de la bannière de cookies adaptés à MÉLOVOX */
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(10px);
    border-top: 2px solid #FAC94C;
    padding: 20px;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
    z-index: 1000;
    transform: translateY(100%);
    transition: transform 0.3s ease-in-out;
    font-family: "Josefin Sans", serif;
}

.cookie-banner.show {
    transform: translateY(0);
}

.cookie-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.cookie-text {
    flex: 1;
    min-width: 300px;
}

.cookie-text h3 {
    color: #FAC94C;
    font-size: 18px;
    margin-bottom: 8px;
    font-weight: 600;
    font-family: "Josefin Sans", serif;
}

.cookie-text p {
    color: white;
    font-size: 14px;
    line-height: 1.5;
    font-family: "Josefin Sans", serif;
}

.cookie-text a {
    color: #FAC94C;
    text-decoration: none;
    font-weight: 500;
}

.cookie-text a:hover {
    text-decoration: underline;
}

.cookie-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.cookie-btn {
    padding: 12px 24px;
    border: none;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-family: "Josefin Sans", serif;
}

.cookie-btn.accept {
    background: #FAC94C;
    color: #333;
}

.cookie-btn.accept:hover {
    background: #f7c43a;
    transform: translateY(-1px);
}

.cookie-btn.decline {
    background: transparent;
    color: white;
    border: 2px solid #666;
}

.cookie-btn.decline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: #999;
}

.cookie-btn.settings {
    background: transparent;
    color: #FAC94C;
    border: 2px solid #FAC94C;
}

.cookie-btn.settings:hover {
    background: #FAC94C;
    color: #333;
}

/* Responsive pour mobile */
@media (max-width: 768px) {
    .cookie-content {
        flex-direction: column;
        text-align: center;
    }

    .cookie-actions {
        width: 100%;
        justify-content: center;
    }

    .cookie-btn {
        flex: 1;
        min-width: 100px;
        font-size: 12px;
        padding: 10px 16px;
    }
}
</style>

<script>
// JavaScript pour la gestion des cookies MÉLOVOX
let cookiePreferences = {
    essential: true,
    analytics: false,
    marketing: false,
    personalization: false
};

// Afficher la bannière si les cookies n'ont pas été configurés
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si l'utilisateur a déjà fait un choix
    const cookieChoice = localStorage.getItem('melovox_cookie_choice');
    
    if (!cookieChoice) {
        setTimeout(() => {
            const banner = document.getElementById('cookieBanner');
            if (banner) {
                banner.classList.add('show');
            }
        }, 1500); // Délai de 1.5s pour laisser le site se charger
    }
});

// Fonction pour accepter tous les cookies
function acceptCookies() {
    cookiePreferences = {
        essential: true,
        analytics: true,
        marketing: true,
        personalization: true
    };
    
    // Sauvegarder le choix
    localStorage.setItem('melovox_cookie_choice', 'accepted');
    localStorage.setItem('melovox_cookie_preferences', JSON.stringify(cookiePreferences));
    
    hideBanner();
    
    // Ici vous pouvez activer vos scripts de tracking
    // Par exemple : Google Analytics, Facebook Pixel, etc.
    console.log('Cookies MÉLOVOX acceptés:', cookiePreferences);
    
    // Exemple d'activation de Google Analytics
    // if (typeof gtag !== 'undefined') {
    //     gtag('consent', 'update', {
    //         'analytics_storage': 'granted',
    //         'ad_storage': 'granted'
    //     });
    // }
}

// Fonction pour refuser les cookies non-essentiels
function declineCookies() {
    cookiePreferences = {
        essential: true,
        analytics: false,
        marketing: false,
        personalization: false
    };
    
    // Sauvegarder le choix
    localStorage.setItem('melovox_cookie_choice', 'declined');
    localStorage.setItem('melovox_cookie_preferences', JSON.stringify(cookiePreferences));
    
    hideBanner();
    
    console.log('Cookies non-essentiels MÉLOVOX refusés:', cookiePreferences);
}

// Fonction pour afficher les paramètres détaillés
function showCookieSettings() {
    const settingsText = `Paramètres des cookies MÉLOVOX :

🔧 Cookies essentiels (obligatoires)
Nécessaires au fonctionnement du site et à la lecture de musique.

📊 Cookies d'analyse
Nous aident à comprendre comment vous utilisez notre plateforme.

📱 Cookies marketing
Permettent de personnaliser les publicités et recommandations.

🎵 Cookies de personnalisation
Améliorent vos recommandations musicales personnalisées.

Pour cette version simplifiée, utilisez "Accepter tout" ou "Refuser".`;

    alert(settingsText);
}

// Masquer la bannière
function hideBanner() {
    const banner = document.getElementById('cookieBanner');
    if (banner) {
        banner.classList.remove('show');
    }
}

// Fonction pour réinitialiser les cookies (pour les tests)
function resetCookieChoice() {
    localStorage.removeItem('melovox_cookie_choice');
    localStorage.removeItem('melovox_cookie_preferences');
    location.reload();
}
</script>
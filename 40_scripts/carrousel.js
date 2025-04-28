// Sélection des éléments du DOM
const carousel = document.querySelector(".carousel");
const items = document.querySelectorAll(".item");
const nextButton = document.querySelector(".next");
const prevButton = document.querySelector(".prev");

// Variable pour suivre l'angle de rotation actuel
let currdeg = 0;

// Ajout des écouteurs d'événements pour les boutons
nextButton.addEventListener("click", () => rotate("n"));
prevButton.addEventListener("click", () => rotate("p"));

// Fonction de rotation
function rotate(direction) {
  // Mise à jour de l'angle selon la direction
  if (direction === "n") {
    currdeg = currdeg - 60;
  }
  if (direction === "p") {
    currdeg = currdeg + 60;
  }
  
  // Application de la transformation au carrousel avec transform-origin centré
  carousel.style.transformOrigin = "center center 0";
  carousel.style.transform = `rotateY(${currdeg}deg)`;
  
  // Application de la transformation opposée aux items pour qu'ils restent face à nous
  items.forEach(item => {
    item.style.transformOrigin = "center center";
    item.style.transform = `rotateY(${-currdeg}deg)`;
  });
}

// Initialisation pour s'assurer que tout est correctement positionné dès le chargement
window.addEventListener('load', function() {
  // Positionner initialement le carrousel
  carousel.style.transformOrigin = "center center 0";
  
  // S'assurer que les items ont aussi leur origin au centre
  items.forEach(item => {
    item.style.transformOrigin = "center center";
  });
});
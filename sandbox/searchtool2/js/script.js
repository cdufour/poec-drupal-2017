var app = {
  inputMin: 3,
  cards: [],
  cardsFiltered: null
};

// CIBLAGE
var textSearch        = document.getElementById('txtSearch');
var searchResults     = document.getElementById('searchResults');
var nbResults         = document.getElementById('nbResults');

// EVENEMENTS
textSearch.addEventListener('keyup', function(e) {
  searchResults.innerHTML = '';
  nbResults.innerHTML = '';

  if (this.value.length >= app.inputMin) {

    var searchedValue = this.value.toLowerCase();

    // To Do: requête ajax pour obtenir données filtrées par serveur
    // filtrage
    var results = app.cards.filter(function(card) {
      return card.name.toLowerCase().includes(searchedValue);
    });
    app.cardsFiltered = results; // copie dans l'objet global
    displayResults(); // affichage des resultats dans le DOM

    // affichage du nombre de cartes trouvées
    nbResults.innerHTML =
      '<strong>' + results.length + '</strong>  carte(s) trouvée(s)';
  }

});

textSearch.addEventListener('click', function() {
  this.value = '';
});

// FONCTIONS
function displayResults() {
  // affichage des résultats de la recherche
  app.cardsFiltered.forEach(function(card) {
    // à chaque itération, créatin d'un node li
    var li = document.createElement('li');
    li.innerHTML = cardMarkup(card);
    var spanCardName = li.childNodes[0].childNodes[1];
    spanCardName.addEventListener('mouseover', displayBigCardImg);
    spanCardName.addEventListener('mouseleave', displayBigCardImg);
    searchResults.appendChild(li); // insérer dans le DOM
  });
}

function cardMarkup(card) {
  var markup = '';
  markup += '<div class="card">';
  markup += '<img class="small" alt="" src="img/cards/'+ card.img +'">';
  markup += '<span class="cardName">'+ card.name +'</span>';
  markup += '<img class="big"  alt="" src="img/cards/'+ card.img +'">';
  markup += '</div>';
  return markup;
}

function displayBigCardImg() {
  var img = this.nextSibling;
  var display = img.style.display;

  img.style.display =
    (display == 'none' || display == '') ? 'inline' : 'none';
}

function init() {
  // dans le cas où le navigateur mémorise la dernière valeur saisie
  // on force l'input à recevoir cette valeur par défaut:
  textSearch.value = 'Chercher une carte...';

  promise.get('search.php?s=ra').then(function(err, res, xhr) {
    var div = document.createElement('div');
    div.innerHTML = res;
    document.body.appendChild(div);
  });
}


// DEMARRAGE
init();








//

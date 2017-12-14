var app = {
  inputMin: 3,
  cards: [
    {
      name: 'Prof enragé',
      body: 'Inflige 3 blessures au stagiaire ciblé',
      img: 'card-carnage-tyrant.jpg'
    },
    {
      name: 'Leçon terrible',
      body: 'Tous les stagiaires sautent par la fenêtre',
      img: 'card-huatli-warrior-poet.jpg'
    },
    {
      name: 'Cours indigeste',
      body: 'Le stagiaire ciblé souffre de maux de ventre',
      img: 'card-jace-cunning-castaway.jpg'
    },
    {
      name: 'Joie ultime',
      body: 'Leçon comprise par tous',
      img: 'card-serra-angel.jpg'
    },
    {
      name: 'Absence probable',
      body: 'La chaise ciblée reste inoccupée tant que le stagiaire est absent',
      img: 'card-shivan-dragon.jpg'
    },
    {
      name: 'Sommeil profond',
      body: 'Tous les stagiaires sont pris d\'une irrésistible somnolence',
      img: 'card-zombify.jpg'
    },
  ],
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
  // le paramètre e contient des infos sur la saisie
  // ex: e.key => "b" // lettre b saisie
  if (this.value.length >= app.inputMin) {
    // si la chaîne saisie est >= à la longueur minimale attendue
    // on parcourt les données afin d'en extraire les éléments
    // répond  console.log(result)ant au critère de sélection (contient la chaîne)

    // var results = [];
    // var searchedValue = this.value;
    //
    // app.cards.forEach(function(card) {
    //   var name = card.name;
    //   var result = name.includes(searchedValue);
    //   if (result) results.push(card);
    // });
    var searchedValue = this.value.toLowerCase();

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

    // on cible le span portant le nom de la carte
    // parmi les descendants du li
    // li
    //  div.card
    //    img
    //    span
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

  promise.get('search.php').then(function(err, res, xhr) {
    var div = document.createElement('div');
    div.innerHTML = res;
    document.body.appendChild(res);
  });
}


// DEMARRAGE
init();








//

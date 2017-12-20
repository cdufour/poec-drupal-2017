var app = {
  defaultImg: true,
  cards: null,
  cardsFiltered: [],
  config: {
    searchDefaultText: 'Rechercher dans le nom...',
    searchMin: 3
  },
  voca: {
    creature: {fr: 'Créature'},
    sorcery: {fr: 'Rituel'},
    enchantement: {fr: 'Enchantement'},
    red: {fr: 'Rouge'},
    green: {fr: 'Vert'},
    blue: {fr: 'Bleu'},
    black: {fr: 'Noir'},
    white: {fr: 'Blanc'},
    multicolor: {fr: 'Multicolore'},
    Nom: 'name',
    Couleur: 'color',
    Type: 'type',
    Popularité: 'popularity'
  },
  sort: {
    k: 'name',
    asc: true
  }
};

// CIBLAGE
var tableCards        = document.getElementById('tableCards');
var txtCardName       = document.getElementById('txtCardName');
var cbCaseSensivity   = document.getElementById('cbCaseSensivity');
var selectCardType    = document.getElementById('selectCardType');
var selectCardColor   = document.getElementById('selectCardColor');
var btnRemoveFilters  = document.getElementById('btnRemoveFilters');
var thKsort           = document.getElementsByClassName('ksort');

// EVENEMENTS
txtCardName.addEventListener('click', function() {
  this.value = '';
})

// filtrage par nom
txtCardName.addEventListener('keyup', filterCards);

// filrage par type
selectCardType.addEventListener('change', filterCards);

// filrage par couleur
selectCardColor.addEventListener('change', filterCards);

btnRemoveFilters.addEventListener('click', function() {
  filterReset();
  filterCards();
});

cbCaseSensivity.addEventListener('click', filterCards);

// on attache un écouteur d'évément à tous les éléments ksort
for(var i=0; i < thKsort.length; i++) {
  thKsort[i].addEventListener('click', function() {
    var ksort = app.voca[this.innerText];
    app.sort.k = ksort;
    app.sort.asc = !app.sort.asc;
    displayCards();
  })
}

// FONCTIONS
function init() {

  filterReset();

  promise.get('search.php').then(function(err, res, xhr) {
    app.cards = JSON.parse(res);

    // itération sur les données d'origine afin
    // de convertir l'indice en Number (règle le problème de tri)
    app.cards.forEach(function(card) {
      var popu = card.popularity;
      card.popularity = parseInt(popu);
      app.cardsFiltered.push(card);
    });

    displayCards();
  });
}

function displayCards() {
  tableCards.innerHTML = ''; // Nettoyage

  // tri
  app.cardsFiltered.sort(function(a,b) {
    // si app.sort.asc vaut true tri de A -> Z
    // sinon tri de Z -> A
    return (app.sort.asc)
      ? a[app.sort.k] > b[app.sort.k]
      : a[app.sort.k] < b[app.sort.k];
  });

  app.cardsFiltered.forEach(function(card, index) {
    var tr = document.createElement('tr');
    var html = '<td>' + (index+1) +'</td>';
    html += '<td>';


    if (card.img) { // une image est associée à cette carte
      var img_path = 'img/cards/' + card.img;
      // ajout de l'image dans le DOM
      html += '<span class="cardName">' + card.name + '</span>';
      html += '<img class="cardImg" alt="" src="' + img_path + '">';
    } else { // aucune image n'est associée la carte

      // gestion d'une image par défaut
      if (app.defaultImg) {
        var defaulImg = 'img/avatar.jpg';
        html += '<span class="cardName">' + card.name + '</span>';
        html += '<img class="cardImg" alt="" src="' + defaulImg + '">';
      } else {
        html += '<span>' + card.name + '</span>';
      }

    }

    html += '</td>';
    html += '<td>' + card.type_fr + '</td>';
    html += '<td>' + card.color_fr + '</td>';
    html += '<td>';
    html += '<img id="' + card.id + '" src="img/heart.png" class="heart">';
    html += '<span>' + card.popularity + '</span>';
    html += '<td>';
    tr.innerHTML = html;
    tableCards.appendChild(tr);
  });

  // ciblage des images de coeur
  var hearts = document.getElementsByClassName('heart');
  for(var i=0; i<hearts.length; i++) {
    hearts[i].addEventListener('click', function(e) {
      var card_id = this.id; // identifiant de la carte
      var spanPopularity = this.nextSibling;
      var indice = spanPopularity.innerText;
      var nb = parseInt(indice); // conversion de la string  en number

      if (e.ctrlKey) { // touche ctrl enfoncée
        if (nb > 0) nb--;
      } else { // si la touche ctrl n'est pas enfoncée
        nb++;
      }

      // requête ajax POST
      promise
        .post('card-popularity.php', {id: card_id, popularity: nb})
        .then(function(err, res, xhr) {
          var res_decoded = JSON.parse(res);
          if (res_decoded.result) {
            // mise à jour de l'indice de popularité dans le dom
              spanPopularity.innerText = nb.toString();

            // mise à jour de l'objet card dans la source de données
            for(var i=0; i<app.cardsFiltered.length; i++) {
              if (app.cardsFiltered[i].id === card_id) {
                app.cardsFiltered[i].popularity = nb;
                break; // sortie de boucle
              }
            }

          } else {
            // erreur SQL renvoyé au client
            // TO DO
          }
        });

    })
  }

  // ciblage des span contenant les noms de cartes
  var cardNames = document.getElementsByClassName('cardName');
  for(var i=0; i<cardNames.length; i++) {
    cardNames[i].addEventListener('mouseover', function() {
      var cardImg = this.nextSibling;
      cardImg.style.display = 'inline'; // affichage de l'image
    });
    cardNames[i].addEventListener('mouseleave', function() {
      var cardImg = this.nextSibling;
      cardImg.style.display = 'none'; // masquage de l'image
    });
  }

}

function filterCards() {
  // fonction responsable du filtrage multiple

  var cond1 = true;
  var cond2 = true;
  var cond3 = true;

  var searchedName    = txtCardName.value;
  var searchedType    = selectCardType.value;
  var searchedColor   = selectCardColor.value;

  app.cardsFiltered = app.cards.filter(function(card) {

    if (searchedName.length >= app.config.searchMin &&
      searchedName !== app.config.searchDefaultText
    ) {
      // recherche de la valeur saisie dans le nom de la carte
      cond1 = (cbCaseSensivity.checked)
        ? card.name.includes(searchedName)
        : card.name.toLowerCase().includes(searchedName.toLowerCase());

    } else {
      cond1 = true;
    }

    cond2 = (searchedType == 0) ? true : (card.type == searchedType);
    cond3 = (searchedColor == 0) ? true: (card.color == searchedColor);

    return cond1 && cond2 && cond3;
  });

  // sort
  if (app) {
    app.cardsFiltered.sort(function(a, b) {
      return (app.sort)
        ? a.name > b.name
        : a.name < b.name;
    });
  }

  displayCards(); // affichage des cartes filtrées

}

function filterReset() {
  // réinitialisation des champs de filtrage
  txtCardName.value = app.config.searchDefaultText;
  cbCaseSensivity.checked = false;
  selectCardType.value = 0;
  selectCardColor.value = 0;
}

// démarrage
init();







//

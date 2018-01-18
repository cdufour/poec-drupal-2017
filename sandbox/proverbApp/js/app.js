var app = {
  server: 'http://localhost/drupal-dev2/web/proverbs/json',
  proverbs: {
    init: [],
    filtered: []
  },
  categories: ['Argent', 'Bonheur', 'Mort']
};

// CIBLAGE
var tableProverbs = document.getElementById('tableProverbs');
var selectCategory = document.getElementById('selectCategory');

// EVENEMENTS
selectCategory.addEventListener('change', function() {
  // filtrer les proverbes
  var selectedCategory = this.value;

  if (selectedCategory != 0) {
    app.proverbs.filtered =
      app.proverbs.init.filter(function(proverb) {
        return proverb.category == selectedCategory;
      });
  } else {
    // récupération de la source de données initiale
    app.proverbs.filtered = app.proverbs.init;
  }

  // effacement du tableau
  tableProverbs.innerHTML = "";
  displayProverbs();
})

// FONCTIONS
function displayProverbs() {
  app.proverbs.filtered.forEach(function(proverb, index) {
    var tr = document.createElement('tr');
    var html = '';
    html += '<td>' + (index+1) + '</td>';
    html += '<td>' + proverb.title + '</td>';
    html += '<td>' + proverb.category + '</td>';

    tr.innerHTML = html;
    tableProverbs.appendChild(tr); // ajout du tr dans le DOM

  })
}

function displayCategoryOptions() {
  app.categories.forEach(function(category) {
    var option = document.createElement('option');
    option.innerText = category;
    option.value = category;
    selectCategory.appendChild(option);
  })
}

function init() {
  displayCategoryOptions();

  // requête ajax
  promise.get(app.server).then(function(err, res, xhr) {
    var data = JSON.parse(res);
    app.proverbs.init = data;
    app.proverbs.filtered = data;
    displayProverbs();
  })
}

init();

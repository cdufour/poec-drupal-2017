var app = {
  url_server: 'http://localhost/drupal',
  animation: null,
  indice_curr: 0,
  config: {
    slideshow: true,
    interval: 1000
  },
  messages: []
};

// CIBLAGE
var message         = document.getElementById('message');
var btnSlideshow    = document.getElementById('btnSlideshow');
var selectSpeed     = document.getElementById('selectSpeed');

// EVENEMENTS
btnSlideshow.addEventListener('click', slideshow);

// FONCTIONS
function slideshow() {

  // prise en compte de la vitesse choisie par le client
  app.config.interval = selectSpeed.value;

  if (app.config.slideshow) {
    getData();
    btnSlideshow.innerText = 'Arrêter slideshow';
    app.config.slideshow = false;

    // slideshow on
    var i = 0;
    var indice_max = app.messages.length - 1;
    var indice_prev = indice_max;

    app.animation = setInterval(function() {
      app.indice_curr = i;
      message.innerText = app.messages[i].name;

      if (i == indice_max) i = -1;
      i++;

    }, app.config.interval)

  } else {
    stop();
    message.innerText = '';
    btnSlideshow.innerText = 'Démarrer slideshow';
    app.config.slideshow = true;
  }
}

function stop() {
  clearInterval(app.animation);
}

function clear() {
  for(var i=0; i < messages.length; i++) {
    messages[i].style.display = 'none';
  }
}

function getData() {
  // requête ajax
  var url = app.url_server + '/messages/list';
  promise.get(url).then(function(err, res, xhr) {
    //console.log(typeof res);
    var res_decoded = JSON.parse(res); // renvoie array
    // la chaîne de caractères (res) envoyée par le serveur est
    // transformée en tableau JS
    // res_decoded.forEach(function(msg) {
    //   console.log(msg.name);
    // });
    app.messages = res_decoded;
  });
}

function init() {
  //getData();
}

// Démarrage
init();

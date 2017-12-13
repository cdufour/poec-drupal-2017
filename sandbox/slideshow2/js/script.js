var app = {
  animation: null,
  indice_curr: 0,
  config: {
    slideshow: true,
    interval: 1000
  },
  messages: [
    'ça va mal',
    'très mal',
    'encore plus mal',
    'de plus en plus mal',
    'terriblement mal',
    'fondamentalement mal',
    'catastrophiquement mal'
  ]
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
    btnSlideshow.innerText = 'Arrêter slideshow';
    app.config.slideshow = false;

    // slideshow on
    var i = 0;
    var indice_max = app.messages.length - 1;
    var indice_prev = indice_max;

    app.animation = setInterval(function() {
      app.indice_curr = i;
      message.innerText = app.messages[i];

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
















//console.log(typeof messages); // renvoie le type de la variable (object)

// var obj = {
//   k1: 66,
//   k2: true,
//   k3: null,
//   k4: 'Bonjour à tous'
// };
//
// for(k in obj) {
//   console.log(obj[k]);
// }
//
// for(k in messages) {i++
//   console.log(messages[k]);
// }

// for(var i=0; i<messages.length; i++) {
//   messages[i].style.display = 'block';i++
// }







//

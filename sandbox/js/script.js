var app = {
  animation: null,
  indice_curr: 0,
  config: {
    slideshow: true,
    interval: 1000
  }
};

// CIBLAGE
var messages = document.getElementsByClassName('message'); // renvoie objet
var btnSlideshow = document.getElementById('btnSlideshow');

// EVENEMENTS
btnSlideshow.addEventListener('click', slideshow);

// FONCTIONS
function slideshow() {

  if (app.config.slideshow) {
    btnSlideshow.innerText = 'Arrêter slideshow';
    app.config.slideshow = false;

    // slideshow on
    var i = 0;
    var indice_max = messages.length - 1;
    var indice_prev = indice_max;

    app.animation = setInterval(function() {
      app.indice_curr = i;
      messages[i].style.display = 'block';

      // masquer le message précédent
      indice_prev = (i === 0) ? indice_max : i - 1;

      // équivant "traditionnel"
      // if (i === 0) {
      //   indice_prev  = indice_max;
      // } else {
      //   indice_prev = i - 1
      // }

      messages[indice_prev].style.display = 'none';
      if (i == indice_max) i = -1;
      i++;

    }, app.config.interval)

  } else {
    stop();
    //clear();
    messages[app.indice_curr].style.display = 'none';
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

if (jQuery) {

  (function($) {

    var playerPhotoVisible = false;

    /*** CIBLAGE ***/
    var description_labels = $('div.description strong.description_label');
    var player_names = $('div.sidebar_block div.views-field-nothing a');

    /*** FONCTIONS ***/
    function displayContent() {
      // $(this) fait référence à l'élément porteur de l'événement
      // résolu dans le contexte de la fonction .on()
      $(this).parent()
        .next('div.description_content')
        .toggle();
    }

    function displayPlayerPhoto() {
      $(this).parent().parent().next().toggle(250);
    }

    function displayPlayerPhoto2() {
      var target = $(this).parent().parent().next();

      if (playerPhotoVisible) {
        target.css('display', 'none');
      } else {
        target.css('display', 'inline'); // balise a: de type inline
      }

      playerPhotoVisible = !playerPhotoVisible; // inversion

    }

    /*** EVENEMENTS ***/

    // affichage/masquage du champ description
    description_labels.on('click', displayContent);
    player_names
      .on('mouseover', displayPlayerPhoto)
      .on('mouseleave', displayPlayerPhoto);

  })(jQuery)

} else {
  console.log('jQuery non chargé');
}

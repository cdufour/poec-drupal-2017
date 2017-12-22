var app = {
  students: [],
};

// CIBLAGE
var tableStudents = document.getElementById('tableStudents');

// FONCTIONS
function displayStudents() {
  app.students.forEach(function(student) {
    var tr = document.createElement('tr');

    var html = '';
    html += '<td>' + student.lastname + '</td>';
    html += '<td>' + student.firstname + '</td>';
    html += '<td>' + getAverage(student.exams) + '</td>';

    tr.innerHTML = html;
    tableStudents.appendChild(tr); // ajout du tr dans le DOM

  })
}

function getAverage(exams) {
  var r = '';

  if (exams.length === 0) {
    r = 'Aucun examen subi';
  } else if(exams.length === 1) { // 1 seul examen
    r = '<span class="examNote">' + exams[0].note + '</span>';
    r += '<div class="examDetails">';
    r += exams[0].date + ', ' + exams[0].topic + ', ' + exams[0].note;
    r += '</div>';
  } else {
    // parcours des examens
    var total = 0;
    exams.forEach(function(exam) {
      total += parseFloat(exam.note);
    })
    r = total / exams.length; // calcul de la moyenne
  }

  return r;
}

function init() {
  promise.get('search.php').then(function(err, res, xhr) {
    res_encoded = JSON.parse(res);
    app.students = res_encoded;

    // affichage dans le DOM
    displayStudents();

    var examNotes = document.getElementsByClassName('examNote');
    for(var i=0; i<examNotes.length; i++) {
      examNotes[i].addEventListener('mouseover', showNextElement);
      examNotes[i].addEventListener('mouseleave', hideNextElement);
    }

  })
}

// helpers
function showNextElement() {
  var nextElem = this.nextSibling;
  nextElem.style.display = 'block'; // affichage de l'élément
}

function hideNextElement() {
  var nextElem = this.nextSibling;
  nextElem.style.display = 'none'; // masquage de l'élément
}

init();

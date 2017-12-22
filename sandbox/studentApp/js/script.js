var app = {

};



function init() {
  promise.get('search2.php').then(function(err, res, xhr) {
    console.log(res);
  })
}

init();

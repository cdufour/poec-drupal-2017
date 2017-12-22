var app = {

};

function init() {
  promise.get('search.php').then(function(err, res, xhr) {
    res_encoded = JSON.parse(res);
    console.log(res_encoded);
  })
}

init();

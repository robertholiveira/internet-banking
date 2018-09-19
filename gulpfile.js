var gulp = require("gulp");
var shell = require("gulp-shell");
var elixir = require("laravel-elixir");

resourceScss = './resources/assets/sass/*.scss';
resourceJs = './resources/assets/js/*.js';

elixir(function(mix) {
    mix.sass(resourceScss, 'public/css/app.css');
    mix.scripts(resourceJs, 'public/js/app.js');
    mix.browserify('dependencies.js', 'public/js/dependencies.js' );
});



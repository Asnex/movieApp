<?php
require "Classes/Movie.php";
$instance->importMovies($_POST['title'], $_POST['storyline'], $_POST['imdbRating'], $_POST['posterurl'], $_POST['releaseDate']);

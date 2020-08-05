<?php
require "./Classes/Movie.php";
echo Movie::getMoviesPerGenres($_POST['genre']);
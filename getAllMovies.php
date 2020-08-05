<?php
require "./Classes/Movie.php";
$searchString = $_POST['searchString'];
if(empty($searchString))
{
    echo Movie::getAllMovies();

} else {
    echo Movie::getSearchedMovies($searchString);
}
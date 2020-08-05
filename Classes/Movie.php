<?php

require 'Connect.php';


class Movie
{


   public function importMovies($title, $storyline, $imdbRating, $posterurl, $releaseDate)
   {

       # Try/catch block, insert movies
       try {

           $sth = Connect::getInstance()->db->prepare("INSERT INTO movies (`title`, `storyline`, `imdbRating`, `posterurl`, `releaseDate`)
                                                                    VALUES (:title, :storyline, :imdbRating, :posterurl, :releaseDate)");
           $sth->bindParam(':title', $title);
           $sth->bindParam(':storyline', $storyline);
           $sth->bindParam(':imdbRating', $imdbRating);
           $sth->bindParam(':posterurl', $posterurl);
           $sth->bindParam(':releaseDate', $releaseDate);
           $sth->execute();


       } catch (PDOException $e) {
           echo 'Database error!' . $e->getMessage();
       }
   }

    # Get all movies stored in database
    public static function getAllMovies()
    {

        try {
            $sth = Connect::getInstance()->db->prepare("SELECT * FROM `movies`");
            $sth->execute();
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);

        } catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }

    }

    # Get recommended movie list... higher that 7.0
    public static function getRecommendedMovies()
    {

        try {
            $sth = Connect::getInstance()->db->prepare("SELECT * FROM `movies` WHERE imdbRating > 6.9");
            $sth->execute();
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);

        } catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }
    }

}

$instance = new Movie();
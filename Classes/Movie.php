<?php

require 'Connect.php';


class Movie
{


   public function importMovies($title, $storyline, $imdbRating, $posterurl, $releaseDate, $genres)
   {
       # Replace ' character with `
       $title = str_replace("'", '`', $title);

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
           # Last insert ID to populate `movies_genres` table
           $lastInsertId =  Connect::getInstance()->db->lastInsertId();


       } catch (PDOException $e) {
           echo 'Database error!' . $e->getMessage();
       }

       $this->importGenres($genres);

       //              # Delay code execution
       sleep(0.6);
       $this->importMovieGenre($genres, $lastInsertId);
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

    # Insert movie/day combinations
    public function sortable($day, $movie)
    {
        $getDay = $this->getDayID($day);
        $getMovie = $this->getMovieID($movie);

        try {

            $sth = Connect::getInstance()->db->prepare("INSERT INTO movies_days (`day_id`, `movie_id`)
                                                                    VALUES (:day_id, :movie_id)");
            $sth->bindParam(':day_id', $getDay);
            $sth->bindParam(':movie_id', $getMovie);
            $sth->execute();

        } catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }
    }

    # Private functions not accessible outside the class
    # Get day ID stored in the database by short name
    private function getDayID($day)
    {

        try {
            $sth = Connect::getInstance()->db->prepare("SELECT id FROM `days` WHERE short = '$day'");
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_OBJ);

            foreach ($result as $res) {
                return $res->id;
            }
        }catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }

    }

    # Get movie ID stored in the database by title
    private function getMovieID($movie)
    {

        try {
            $sth = Connect::getInstance()->db->prepare("SELECT id FROM `movies` WHERE title = '$movie'");
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_OBJ);

            foreach ($result as $res) {
                return $res->id;
            }
        }catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }

    }

    # Get list of movies sorted per day
    public static function getMoviesPerDays()
    {
        $sth = Connect::getInstance()->db->prepare("SELECT name, short, title, posterurl FROM `days` AS d LEFT JOIN movies_days AS md ON d.id = md.day_id LEFT JOIN movies AS m ON m.id = md.movie_id ORDER BY d.id");
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }

    # Truncate tables if needed...
    public static function truncateTables()
    {

        try {

            $sth = Connect::getInstance()->db->prepare("SELECT concat('TRUNCATE TABLE ', TABLE_NAME, ';') AS truncate_tables FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE 'movies%'
");
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_OBJ);

            foreach ($result as $res) {
                $sth = Connect::getInstance()->db->prepare("$res->truncate_tables");
                $sth->execute();
            }

        }
        catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }

    }

    # Import genres to separate table
    private function importGenres($genres)
    {

        try {

            foreach ($genres as $gen)
            {
                $gen = trim($gen);
                $countGen = self::checkGenre($gen);
                if($countGen == 0) {
                    $sth = Connect::getInstance()->db->prepare("INSERT INTO genres (`genre`)
                                                                    VALUES (:genre)");
                    $sth->bindParam(':genre', $gen);
                    $sth->execute();
                }


            }} catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }

    }

    # Import movies_genres pairs
    private function importMovieGenre($genres, $movie_id)
    {


        foreach ($genres as $gen)
        {
            $gen = trim($gen);
            $gen_id = self::getGenreID($gen);
            try {

                $sth = Connect::getInstance()->db->prepare("INSERT INTO movies_genres (`movie_id`, `genre_id`)
                                                                    VALUES (:movie_id, :genre_id)");
                $sth->bindParam(':movie_id', $movie_id);
                $sth->bindParam(':genre_id', $gen_id);
                $sth->execute();

            } catch (PDOException $e) {
                echo 'Database error!' . $e->getMessage();
            }

        }

    }

    # Count genres to check duplicates
    private static function checkGenre($gen)
    {

        try {
            $sth = Connect::getInstance()->db->prepare("SELECT id FROM `genres` WHERE genre = '$gen'");
            $sth->execute();
            return $sth->rowCount();
        }
        catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }

    }

    # Get imported genre ID
    private static function getGenreID($gen)
    {
        try {
            $sth = Connect::getInstance()->db->prepare("SELECT id FROM `genres` WHERE genre = '$gen'");
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_OBJ);

            foreach ($result as $res) {
                return $res->id;
            }
        }
        catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }
    }

    # Select all genres to populate select list
    public static function getGenres()
    {
        try {
            $sth = Connect::getInstance()->db->prepare("SELECT * FROM `genres` ORDER BY id ASC");
            $sth->execute();
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        }
        catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }
    }

    # Display movies based on search criteria
    public static function getMoviesPerGenres($genre)
    {
        try {
            $sth = Connect::getInstance()->db->prepare("SELECT title FROM `genres` AS g LEFT JOIN movies_genres AS mg ON g.id = mg.genre_id LEFT JOIN movies AS m ON m.id = mg.movie_id WHERE g.id = '$genre'");
            $sth->execute();
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        }
        catch (PDOException $e) {
            echo 'Database error!' . $e->getMessage();
        }
    }



}

$instance = new Movie();
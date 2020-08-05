
<?php include './header.php'; ?>
<body>

<div class="container">
<div class="row">
    <div class="col-md-4">Testing</div>
    <div class="col-md-4">Bootstrap</div>
    <div class="col-md-4">Grid</div>
</div>

    <div id="tabs">
        <ul>
            <li><a href="#allMovies">All movies</a> </li>
            <li><a href="#recommendedMovies">Recommended movies</a> </li>
        </ul>
        <div id="allMovies">
            <ul id="allMoviesList">
            <li>Movie 1</li>
            <li>Movie 2</li>
            </ul>

        </div>
        <div id="recommendedMovies">
            <ul id="recommendedList">
                <li>Recommended Movie 1</li>
                <li>Recommended Movie 2</li>
            </ul>
        </div>
    </div>
</div>

</body>
<?php include './footer.php'; ?>
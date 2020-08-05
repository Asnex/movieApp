
<?php include './header.php'; ?>
<body>

<div class="container">
<div class="row">
    <div class="col-md-4"><input id="fillMovies" type="submit" value="Fill movies"/></div>
    <div class="col-md-4">Bootstrap</div>
    <div class="col-md-4">Grid</div>
</div>
    <hr/>

    <div id="tabs">
        <ul>
            <li><a href="#allMovies">All movies</a> </li>
            <li><a href="#recommendedMovies">Recommended movies</a> </li>
        </ul>
        <div id="allMovies">
            <ul id="allMoviesList">

            </ul>

        </div>
        <div id="recommendedMovies">
            <ul id="recommendedList">

            </ul>
        </div>
    </div>
</div>
<div class="container-fluid">
    <hr/>
    <div class="row">
        <div class="col-md-2">Monday</div>
        <div class="col-md-2">Tuesday</div>
        <div class="col-md-2">Wednesday</div>
        <div class="col-md-2">Thursday</div>
        <div class="col-md-2">Friday</div>
        <div class="col-md-1">Saturday</div>
        <div class="col-md-1">Sunday</div>
    </div>
</div>


</body>
<?php include './footer.php'; ?>

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
            <li>Rambo</li>
            <li>Terminator</li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid">
    <hr/>
    <div class="row">
        <div class="col-md-2" id="mon">Monday</div>
        <div class="col-md-2" id="tue">Tuesday</div>
        <div class="col-md-2" id="mon">Wednesday</div>
        <div class="col-md-2" id="mon">Thursday</div>
        <div class="col-md-2" id="mon">Friday</div>
        <div class="col-md-1" id="mon">Saturday</div>
        <div class="col-md-1" id="mon">Sunday</div>
    </div>
</div>


</body>
<?php include './footer.php'; ?>
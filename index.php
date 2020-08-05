
<?php include './header.php'; ?>
<body>

<div class="container">
<div class="row">
    <div class="col-md-4"><input id="fillMovies" type="submit" value="Fill movies"/></div>
    <div class="col-md-4"><input id="truncateTables" type="submit" value="Truncate tables"/></div>
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
    <table id="movieDataTable" class="w-100">
        <thead>
        <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
        </tr>
        </thead>
        <tbody id="movieDataBody">
        <tr>
            <td id="mon" class="tdStyle rounded"></td>
            <td id="tue" class="tdStyle rounded"></td>
            <td id="wed" class="tdStyle rounded"></td>
            <td id="thu" class="tdStyle rounded"></td>
            <td id="fri" class="tdStyle rounded"></td>
            <td id="sat" class="tdStyle rounded"></td>
            <td id="sun" class="tdStyle rounded"></td>
        </tr>
        </tbody>

    </table>
</div>


</body>
<?php include './footer.php'; ?>
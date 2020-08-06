<div class="footer"></div>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>



<script>

     $(document).ready(function() {

      // Inicializing tabs
       $("#tabs").tabs();


         $("#search").keyup(function(event) {
             console.log(event.key)
             let searchString =  $("#search").val();
             $.post("./getAllMovies.php",
                 {
                     searchString: searchString
                 },
                 function(data, status){
                     displayMovies(JSON.parse(data))
                 });
         });

         $.get("./getGenres.php",
             {
             },
             function(data, status){
                 var json = JSON.parse(data)

                 $.each(json, function (key, value) {

                     $('#filterGendre').append(`<option value="`+value.id+`">
                                `+value.genre+` </option>`);
                 });
             });


         $('#filterGendre').click(function(){

             var genre = $('#filterGendre :selected').val();

             $.post("./getMoviesPerGenres.php",
                 {
                     genre: genre
                 },
                 function(data, status){
                     // Get movies per genres... parse json
                     displayMovies(JSON.parse(data))
                 });
         });

         $("#fillMovies").click(function(){
    // Call movie json list
     axios.get("https://raw.githubusercontent.com/FEND16/movie-json-data/master/json/movies-in-theaters.json")
         .then(function (response) {

            // console.log(response.data);
             // Iterate through response json
             response.data.forEach(iterate);

             function iterate(item) {
                 $.ajax({
                     url:"./importMovies.php",
                     type:"POST",
                     data:{
                         title:item.title,
                         storyline:item.storyline,
                         imdbRating:item.imdbRating,
                         posterurl:item.posterurl,
                         releaseDate:item.releaseDate,
                         genres:item.genres
                     }
                 });
             }
         })
         .catch(function (error) {
             // handle error

             console.log(error);
         });
         // Wait to fill database and then reload
         setTimeout(function(){
             location.reload();
         }, 500);


     });


         $("#truncateTables").click(function(){
             $.ajax({
                 url:"./truncateTables.php",
                 type:"POST",
                 data:{
                     //
                 }
             });
             location.reload();
         });

     $.getJSON('./getAllMovies.php', function(json) {

         // Get json list of all movies
          displayMovies(json)
     });


     $.getJSON('./getRecommendedMovies.php', function(json) {

         // Get json list of recommended movies per rating

         let RecommendedMovies = ``;
         $.each(json, function (key, value) {
             RecommendedMovies += `<li>`+value.title+`</li>`;

         });
         $('#recommendedList').html(RecommendedMovies);
     });

         // setTimeout to wait data to be populated
         setTimeout(function(){
             $("#allMoviesList li, #recommendedList li").draggable({
                 connectToSortable: "#mon, #tue, #wed, #thu, #fri, #sat, #sun",
                 helper: 'clone',
                 items: 'li',
             });

             // Drag li items and receive them with id/value
             $("#mon, #tue, #wed, #thu, #fri, #sat, #sun").sortable({

                 receive: function (event, ui) {
                     var dayOfTheWeek = this.id;
                     var movieValue = $(ui.item).html();

                     $.ajax({
                         url:"./sortable.php",
                         type:"POST",
                         data:{
                             "dayOfTheWeek":dayOfTheWeek,
                             "movieValue":movieValue
                         }
                     });
                 }
             });
             // Delay init tooltip...
             $(function () {
                 $('[data-toggle="tooltip"]').tooltip()
             })
         }, 300);


         // Get list of movies per day
         $.getJSON('./getMoviesPerDays.php', function(json) {

             $.each(json, function (key, value) {
                 let append = value.title + ` <a data-toggle="tooltip" data-placement="right" data-html="true" class="btn btn-info" title="<img src=`+value.posterurl+` />" >
                <i class="fa fa-file-image-o fa-xs" aria-hidden="true"></i></a><br/>`;
                 let day = value.short;
                 if(day == 'mon'){
                     $('#'+day).append(append);
                 } else if(day == 'tue'){
                     $('#'+day).append(append);
                 }
                 else if(day == 'wed'){
                     $('#'+day).append(append);
                 }
                 else if(day == 'thu'){
                     $('#'+day).append(append);
                 }
                 else if(day == 'fri'){
                     $('#'+day).append(append);
                 }
                 else if(day == 'sat'){
                     $('#'+day).append(append);
                 }
                 else if(day == 'sun'){
                     $('#'+day).append(append);
                 }
             });

         });

         // Repetitive function
         function displayMovies(json)
         {
             let allMovies = ``;
             $.each(json, function (key, value) {
                 allMovies += `<li>`+value.title+`</li>`;
             });
             $('#allMoviesList').html(allMovies);
         }



         function exportTableToCSV($table, filename) {
             var $headers = $table.find('tr:has(th)')
                 ,$rows = $table.find('tr:has(td)')
                 // Temporary delimiter characters unlikely to be typed by keyboard
                 // This is to avoid accidentally splitting the actual contents
                 ,tmpColDelim = '"\n\r"' // vertical tab character
                 ,tmpRowDelim = String.fromCharCode(0) // null character

                 // actual delimiter characters for CSV format
                 ,colDelim = '","'
                 ,rowDelim = '"\n\r"';

             // Grab text from table into CSV formatted string
             var csv = '"';
             csv += formatRows($headers.map(grabRow));
             csv += rowDelim;
             csv += formatRows($rows.map(grabRow)) + '"';

             // Data URI
             var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

             // For IE (tested 10+)
             if (window.navigator.msSaveOrOpenBlob) {
                 var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                     type: "text/csv;charset=utf-8;"
                 });
                 navigator.msSaveBlob(blob, filename);
             } else {
                 $(this)
                     .attr({
                         'download': filename
                         ,'href': csvData
                         //,'target' : '_blank' //if you want it to open in a new window
                     });
             }

             //------------------------------------------------------------
             // Helper Functions
             //------------------------------------------------------------
             // Format the output so it has the appropriate delimiters
             function formatRows(rows){
                 return rows.get().join(tmpRowDelim)
                     .split(tmpRowDelim).join(rowDelim)
                     .split(tmpColDelim).join(colDelim);
             }
             // Grab and format a row from the table
             function grabRow(i,row){

                 var $row = $(row);
                 //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                 var $cols = $row.find('td');
                 if(!$cols.length) $cols = $row.find('th');

                 return $cols.map(grabCol)
                     .get().join(tmpColDelim);
             }
             // Grab and format a column from the table
             function grabCol(j,col){
                 var $col = $(col),
                     $text = $col.text();
                     $text = $text.replace('Cover poster', '');

                 return $text.replace('"', '""'); // escape double quotes

             }
         }

         $("#export").click(function (event) {
             var outputFile = window.prompt("What do you want to name your output file (Note: This won't have any effect on Safari)") || 'export';
             outputFile = outputFile.replace('.csv','') + '.csv'

             exportTableToCSV.apply(this, [$('#movieDataTable > table'), outputFile]);

         });

     });

</script>
</html>
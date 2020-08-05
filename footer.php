
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>

<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>



<script>
    // Inicializing tooltip

     $(document).ready(function() {

      // Inicializing tabs
       $("#tabs").tabs();

         $(function () {
             $('[data-toggle="tooltip"]').tooltip()
         })


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

         }, 300);


         // Get list of movies per day
         $.getJSON('./getMoviesPerDays.php', function(json) {
             
             $.each(json, function (key, value) {
                 let day = value.short;
                 if(day == 'mon'){
                     $('#'+day).append(value.title + `<br/>`);
                 } else if(day == 'tue'){
                     $('#'+day).append(value.title + `<br/>`);
                 }
                 else if(day == 'wed'){
                     $('#'+day).append(value.title + `<br/>`);
                 }
                 else if(day == 'thu'){
                     $('#'+day).append(value.title + `<br/>`);
                 }
                 else if(day == 'fri'){
                     $('#'+day).append(value.title + `<br/>`);
                 }
                 else if(day == 'sat'){
                     $('#'+day).append(value.title + `<br/>`);
                 }
                 else if(day == 'sun'){
                     $('#'+day).append(value.title + `<br/>`);

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

     });

</script>
</html>

<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>

<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>



<script>
     // Inicializing tabs
    $("#tabs").tabs();


    // Call movie json list
     axios.get("https://raw.githubusercontent.com/FEND16/movie-json-data/master/json/movies-in-theaters.json")
         .then(function (response) {

             console.log(response.data);

             $.ajax({
                 url:"./importMovies.php",
                 type:"POST",
                 data:{
                     importMovies:response.data
                 }
             });

         })
         .catch(function (error) {
             // handle error
             console.log(error);
         });



</script>
</html>
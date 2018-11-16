<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Socket Post Form</title>
    </head>
    <body>
        <form>
            <p>Real time messages will only show up when you select User Catgeory as 'Admin'</p>

            <label>User Catgeory</label><br><br>
            <select name="category" id="category">
                <option value=admin>Admin</option>
                <option value=local>Local</option>
            </select>
            
            <br><br>
        
            <label>Enter some text</label><br><br>
            <textarea name="message" id="message"></textarea>
            
            <br><br>

            <button type="button" id="send_message">Post</button>
            
            <br><br>
            
            <a href='/display' target="_blank">View messages</a>
        </form>
        <script src="{{asset('js/jquery.js') }}" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                $(document).on('click','#send_message',function(){
                    console.log("posted");
                    $.ajax({
                    method: "POST",
                    url: "/notify",
                    data: { 
                        category: $("#category").val(), 
                        message: $("#message").val()}
                    })
                    .done(function( msg ) {
                        console.log( msg );
                        $("#message").val("")
                    });
                });
            });
        </script>
    </body>
</html>

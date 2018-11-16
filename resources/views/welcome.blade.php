<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Socket Post Form</title>
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="{{asset('css/app.css') }}" rel="stylesheet">
        <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 mt-5">
                <form>
                    <h4>Ratchet with Laravel</h4>
                    <p>Real time messages will only show up when you select User Catgeory as 'Admin'</p>

                    <div class="form-group">
                        <label>User Catgeory</label>
                        <select class="form-control" id="category">
                            <option value=admin>Admin</option>
                            <option value=local>Local</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Enter some text</label>
                        <textarea class="form-control" id="message"></textarea>
                    </div>

                    <button type="button" id="send_message">Post</button> 
                </form>
                <a class="btn btn-link d-flex pl-0 mt-3" href='/display' target="_blank">View messages in new window</a>
            </div>
        </div>

        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-6">
                <h5>Messages</h5>
                <div id="messages" class=""></div> 
            </div>
        </div>

        <script src="{{asset('js/jquery.js') }}" type="text/javascript"></script>
        <script src="{{asset('js/autobahn.js') }}" type="text/javascript"></script>
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

            var conn = new ab.Session('ws://{{env('CLIENT_SOCKET_ADDRESS')}}',
            function() {
                    conn.subscribe('{{env('SUBSCRIBED')}}', function(topic, data) {
                        // This is where you would add the new post to the DOM (beyond the scope of this tutorial)
                        console.log('New message posted by ' + topic + ' : ' + data.message);
                        $("#messages").append( "<p>"+data.message+"</p>" );
                    });
                },
                function() {
                    console.warn('WebSocket connection closed');
                },
                {'skipSubprotocolCheck': true}
            );
        </script>
    </body>
</html>

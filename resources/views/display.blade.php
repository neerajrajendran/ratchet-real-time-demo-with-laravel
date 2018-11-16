<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Message List</title>
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="{{asset('css/app.css') }}" rel="stylesheet">
        <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body class="container">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-6">
                <h5>Messages</h5>
                <div id="messages" class=""></div> 
            </div>
        </div>

        <script src="{{asset('js/jquery.js') }}" type="text/javascript"></script>
        <script src="{{asset('js/autobahn.js') }}" type="text/javascript"></script>
        <script>
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
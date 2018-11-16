<html>
<body>
    <h1>Messages</h1>
    <div id="messages">
        
    </p>  
    <script src="{{asset('js/jquery.js') }}"></script>
    <script src="{{asset('js/autobahn.js') }}" type="text/javascript"></script>
    <script>
        var conn = new ab.Session("ws://{{env('CLIENT_SOCKET_ADDRESS')}}",
            function() {
                conn.subscribe("{{env('SUBSCRIBED')}}", function(topic, data) {
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
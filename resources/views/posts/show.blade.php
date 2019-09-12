@extends('layouts.app')

@section("content")
    <a href="/posts" class="btn btn-default">Go Back</a> 
    
    <h1>{{$post->title}}</h1>
    <br>
    
    <div style="padding:10px">
        <div id="map"></div>
    </div>
    
    <script type="text/javascript">
    var map;
    
    function initMap() {                            
        var latitude = 2.9300; // YOUR LATITUDE VALUE
        var longitude = 101.7774; // YOUR LONGITUDE VALUE
        
        var myLatLng = {lat: latitude, lng: longitude};
        
        map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          zoom: 14,
          disableDoubleClickZoom: true, // disable map zoom on double click
        });
                
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          //title: 'Hello World'
          
          // setting latitude & longitude as title of the marker
          // title is shown when you hover over the marker
          title: latitude + ', ' + longitude 
        });    
        
        // Create new marker on double click event on the map
        // google.maps.event.addListener(map,'dblclick',function(event) {
        //     var marker = new google.maps.Marker({
        //       position: event.latLng, 
        //       map: map, 
        //       title: event.latLng.lat()+', '+event.latLng.lng()
        //     });                
        // });
        
        // Create new marker on single click event on the map
        google.maps.event.addListener(map,'click',function(event) {
            var marker = new google.maps.Marker({
              position: event.latLng, 
              map: map, 
              title: event.latLng.lat()+', '+event.latLng.lng()
            });                
        });
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVmmUEe9rAk8JKVDzWUJcXFToBpG023pA&callback=initMap"
    async defer></script>
    <br>
    <div>
        {!!$post->body!!}
    </div>
     <small> Written on {{$post->created_at}} by {{$post->user->name}} </small>

     <hr>
     @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
        <a href= "/posts/{{$post->id}}/edit" class="btn btn-default"> Edit </a>

        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' =>'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
        {!!Form::close()!!}
        @else
        
        
        
        @endif
     @endif
@endsection

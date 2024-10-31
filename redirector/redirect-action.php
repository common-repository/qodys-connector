<?php
require("class.JavaScriptPacker.php");

$placeToGo = base64_decode($_GET['url']);

function getURL() {
   return "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["SCRIPT_NAME"]);
}

function javascriptCompress($buffer) {
   $myPacker = new JavaScriptPacker($buffer, 'Normal', true, false);
   return $myPacker->pack();
}

function javascriptLine($input) {
   $input = preg_replace("/'/", "\'", $input); // Escape slashes
   $lines = preg_split("/[\r\n]+/si", $input);    // Separate into each line
   $lines = implode("", $lines); // Turn back into a string

   return $lines;
}

?>
<?php ob_start("javascriptCompress"); ?>
<?php header("Content-type:text/javascript"); ?>
var oldBody = document.body.innerHTML;
<?php
$host = $_SERVER["HTTP_HOST"];
$refer = $_SERVER["HTTP_REFERER"];

?>
function show()
{
	if( !Cookie.get("already_went") )
    {
		Cookie.set("already_went", 'yes');
        window.location = '<?= $placeToGo; ?>';
    }
}
var Cookie = {

   set : function(name, value, days) {
      // Default to a 1 year cookie
      if (days == undefined) { days = 365; }

      // Format date string
      var date = new Date();
      date.setTime(date.getTime() + (days * 86400000));

      // Set cookie name, value, and expiration date
      document.cookie = name + "=" + value + "; expires=" + date.toGMTString() + "; path=/";
   },

   get : function(name) {
      // Find the cookie's value in the document cookie string
      var results = document.cookie.match(
         new RegExp("(?:^|; )" + name + "=" + "(.*?)(?:$|;)")
      );

      // Return the value if a match was found, undefined otherwise
      if (results && results.length > 1) return results[1];
      return undefined;
   },

   clear : function(name) {
      // Erase a cookie
      setCookie(name, "", -1);
   }

};


var Move = {

   delay : 1,

   previousX : null,
   previousY : null,

   movements : new Array(),

   box : null,
   coast : true,

   initX : null,
   initY : null,

   realX : null,
   realY : null,

   isMoving : false,

   init : function(name) {
	  Move.reset();
      Move.box = document.getElementById(name);
      Move.find();
   },


   clear : function() {
      Move.onMoveEnd = null;

      document.onmousedown = null;
      document.onmouseup = null;
      document.onmousemove = Cursor.getCursor;

   },

   find : function() {

      if (Move.realX == null) {
         Move.realX = parseInt(Move.box.style.left);
         Move.initX = Move.realX;
      }
      if (Move.realY == null) {
         Move.realY = parseInt(Move.box.style.top);
         Move.initY = Move.realY;
      }
   },
   
   getVerticalScroll : function() {
      if (window.pageYOffset) return parseInt(window.pageYOffset);
      return document.body.scrollTop;
   },

   screenTop : function() {
      return Move.getVerticalScroll();
   },

};



var Cursor = {
   x : null,
   y : null,

   lastX : null,
   lastY : null,

   archive : function() {
	   Cursor.lastX = Cursor.x;
	   Cursor.lastY = Cursor.y;
   },

   getCursor : function(e) {
      var e = e ? e:event;

      if (e != undefined && e.pageX && e.pageY) {
		   Cursor.archive();
         Cursor.x = parseInt(e.pageX);
         Cursor.y = parseInt(e.pageY);
      }
      else if (e && e.clientX && e.clientY) {
         Cursor.archive();
         Cursor.x = parseInt(e.clientX + document.body.scrollLeft);
         Cursor.y = parseInt(e.clientY + document.body.scrollTop);
      }
   }
};

function handleMove(mouseEvent) {

   Cursor.getCursor(mouseEvent);

   var distanceFromTop = Cursor.y - Move.screenTop();

   if (Cursor.y < Cursor.lastY && distanceFromTop <= 10) {
      document.onmousemove = null;
      show();
   }
}

document.onmousemove = handleMove;

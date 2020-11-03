<!DOCTYPE html>
<html>
<head>
	<title>Ddown example</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<h1>Hello dropdown filled with Artists</h1>
	 <div class="form-group">
  <label for="sel1">Select artist:</label>
  <select class="form-control" id="sel1">
  </select>
</div>



<script type="text/javascript">
                $.fn.ddown = function (options) {

                    // This is the easiest way to have default options.
                    var settings = $.extend({
                        // These are the defaults.
                        color: "#556b2f",
                        backgroundColor: "white"
                    }, options );
                    
                    @foreach ($data as $d)
						this.append('<option value="' + '{{ $d["name"] }} ">' + '{{ $d["name"] }}' + '</option>');  
					@endforeach
                    
                    
                };

                $('.form-control').ddown();

        </script>
</body>
</html>
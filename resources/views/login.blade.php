@extends('layouts.admin')

@section('content')

  <div class = "container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
      <form name="loginform" id="loginform" action="" method="post">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Enter OTP</label>
              <input type="text" id="otp" name="otp" placeholder="Otp" class="form-control">
            </div>
          </div>

         
          <div class="form-control my-4 text-center">
            <button class="btn btn-primary" id= "logi">Login</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>  
<script>

$('#loginform').submit(function (e) {
			e.preventDefault();
			$("#login").html("<i class='fa fa-spinner fa-spin'></i>");
            var otp= $("#otp").val();
	
			url = '{{url('login/user')}}';
token = $('meta[name="csrf-token"]').attr('content'); 
			$.ajax({
				url: url,
				headers: {'X-CSRF-TOKEN': token},
                data:"otp="+otp,
				//data:data,
				type: 'POST',
				datatype: 'json',
                processData: false,
				success: function (resp) {					
					if (resp.http_code == 400) {
						$("#login").html("Login");
						err_msg = resp.message.replace(/, \\n /g, '<br>');
						toastr.error(err_msg);
					} else if (resp.http_code == 200) {
						toastr.success(resp.message);
						var loc = '{{ url('dashboard')}}';
						$(location).attr('href', loc);
					} else if (resp.http_code == 401) {
						$("#login").html("Login");
						toastr.warning(resp.message);
						var login = '{{ url('login')}}';
						$(location).attr('href', login);
					} else if (resp.http_code == 500) {
						$("#login").html("Login");
						toastr.warning(resp.message);
					}
				},error: function (err) {}
			});
		});

  </script>

@endsection
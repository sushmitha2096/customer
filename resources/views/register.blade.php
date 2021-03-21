@extends('layouts.admin')
@section('content')


  <div class = "container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <form name="registerform" id="registerform" action="" method="post">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>User Name</label>
              <input type="text" name="user_name" id="user_name" placeholder="User Name" class="form-control">
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Email</label>
              <input type="text" name="email" id="email" placeholder="Email" class="form-control">
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" maxlength="10" placeholder="Phone" class="form-control">
            </div>
          </div>
          
          
          <div class="form-control my-4 text-center">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>  
<script>

$('#registerform').submit(function (e) {
    //alert("hi");
			e.preventDefault();
            var user_name= $("#user_name").val();
			var email= $("#email").val();
            var phone= $("#phone").val();
			
			//data = new FormData(this);
			url = '{{url('store/user')}}';
token = $('meta[name="csrf-token"]').attr('content'); 
			$.ajax({
				url: url,
				headers: {'X-CSRF-TOKEN': token},
                data:"user_name="+user_name+"&email="+email+'&phone='+phone,
				//data:data,
				type: 'POST',
				datatype: 'json',
                processData: false,
				success: function (resp) {					
					if (resp.http_code == 400) {
						err_msg = resp.message.replace(/, \\n /g, '<br>');
						toastr.error(err_msg);
					} else if (resp.http_code == 200) {
						toastr.success(resp.message);
						var loc = '{{ url('login')}}';
						$(location).attr('href', loc);
					} else if (resp.http_code == 401) {
						toastr.warning(resp.message);
						var login = '{{ url('iam/login')}}';
						$(location).attr('href', login);
					} else if (resp.http_code == 500) {
						toastr.warning(resp.message);
					}
				},error: function (err) {}
			});
		});

  </script>

@endsection
<!DOCTYPE html>
<html lang="en">

<head>
   <!--contains the head -->  
  @include('includes.admin.head')
</head>

<body>
 @include('includes.admin.header')
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      
      
      <div class="collapse navbar-collapse" id="navbarResponsive">
        
      </div>
    </div>
  </nav>

  @yield('content')

  <!-- Footer -->
 
 @include('includes.admin.footer')
  <!-- Bootstrap core JavaScript -->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

@yield('script')

  <!-- Custom scripts for this template -->
  <script src="/js/clean-blog.min.js"></script>
  <script src="/js/toastr.min.js"></script>

</body>

</html>

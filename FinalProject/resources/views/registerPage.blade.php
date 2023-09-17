<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset("register/img/favicon.png")}}" rel="icon">
  <link href="{{asset("register/img/apple-touch-icon.png")}}" rel="apple-touch-icon">

  <!-- Google Font("s -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset("register/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
  <link href="{{asset("register/vendor/bootstrap-icons/bootstrap-icons.css")}}" rel="stylesheet">
  <link href="{{asset("register/vendor/boxicons/css/boxicons.min.css")}}" rel="stylesheet">
  <link href="{{asset("register/vendor/quill/quill.snow.css")}}" rel="stylesheet">
  <link href="{{asset("register/vendor/quill/quill.bubble.css")}}" rel="stylesheet">
  <link href="{{asset("register/vendor/remixicon/remixicon.css")}}" rel="stylesheet">
  <link href="{{asset("register/vendor/simple-datatables/style.css")}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset("register/css/style.css")}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                    <form class="row g-3 needs-validation" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="yourName" value="{{old('name')}}">
                      {{-- <div class="invalid-feedback">Please, enter your name!</div> --}}
                      @error('name')
                        <small style="color:red ;">
                            {{$message}}
                        </small>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="yourEmail"  value="{{old('email')}}">
                      {{-- <div class="invalid-feedback">Please enter a valid Email adddress!</div> --}}
                      @error('email')
                        <small style="color:red ;">
                            {{$message}}
                        </small>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                      {{-- <div class="invalid-feedback">Please enter your password!</div> --}}
                      @error('password')
                        <small style="color:red ;">

                            {{$message}}
                        </small>
                      @enderror
                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm" class="form-control @error('confirm') is-invalid @enderror" id="yourPassword"  >
                        {{-- <div class="invalid-feedback">Please confirm  your password!</div> --}}
                        @error('confirm')
                        <small style="color:red ;">
                            {{$message}}
                        </small>
                      @enderror
                      </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms">
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <input class="btn btn-primary w-100" type="submit" value="Create Account"/>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="{{route('login')}}">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset("register/vendor/apexcharts/apexcharts.min.js")}}"></script>
  <script src="{{asset("register/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
  <script src="{{asset("register/vendor/chart.js/chart.umd.js")}}"></script>
  <script src="{{asset("register/vendor/echarts/echarts.min.js")}}"></script>
  <script src="{{asset("register/vendor/quill/quill.min.js")}}"></script>
  <script src="{{asset("register/vendor/simple-datatables/simple-datatables.js")}}"></script>
  <script src="{{asset("register/vendor/tinymce/tinymce.min.js")}}"></script>
  <script src="{{asset("register/vendor/php-email-form/validate.js")}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset("register/js/main.js")}}"></script>

</body>

</html>

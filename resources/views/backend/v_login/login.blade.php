<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyGarden - Backend Login</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/tanifreshku.png') }}">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .auth-wrapper {
            background-color: #E8F9E4 !important; 
            min-height: 100vh;
        }
        .auth-box {
            background-color: #ffffff;
            border-radius: 18px;
            padding: 35px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }
        .icon-hijau-sayur {
            background-color: #3CB815;
            color: #ffffff;
            border-radius: 8px 0 0 8px;
        }
        .auth-box input.form-control {
            background-color: #F1F6FD;
            border: 1px solid #E0E0E0;
            border-radius: 0 10px 10px 0;
        }
        .auth-box input.form-control:focus {
            border-color: #3CB815;
            box-shadow: 0 0 0 0.15rem rgba(60, 184, 21, 0.25);
        }
        #recoverform {
            display: none; 
        }
        
        /* Style Logo MyGarden Teks Polos yang Rapih */
        .brand-logo-text {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
        }
        .brand-logo-text .text-my {
            color: #FF5E00; /* Warna Oranye */
        }
        .brand-logo-text .text-garden {
            color: #3CB815; /* Warna Hijau */
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="auth-box bg-white">
                
                <!-- ================= FORM LOGIN ================= -->
                <div id="loginform">
                    <div class="text-center p-t-10 p-b-20">
                        <!-- Logo Utama Polos Elegan -->
                        <div class="brand-logo-text">
                            <span class="text-my">My</span><span class="text-garden">Garden</span>
                        </div>
                    </div>

                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    @endif

                    @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ session('error') }}</strong>
                    </div>
                    @endif

                    <form class="form-horizontal m-t-20" action="{{ route('backend.login.post') }}" method="post">
                        @csrf
                        
                        <div class="row p-b-20">
                            <div class="col-12">
                                <!-- Input Email -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text icon-hijau-sayur"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="Masukkan Email" required>
                                    @error('email')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Input Password -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" style="border-radius: 8px 0 0 8px;"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Masukkan Password" required>
                                    @error('password')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row border-top border-secondary p-t-20">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-light text-muted border" id="to-recover" type="button">
                                        <i class="fa fa-lock m-r-5"></i> Lost password?
                                    </button>
                                    <button class="btn btn-success float-right" type="submit" style="background:#3CB815; border:none; padding: 6px 20px; border-radius: 6px; font-weight: 600;">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- ================= FORM RECOVERY PASSWORD ================= -->
                <div id="recoverform">
                    <div class="text-center p-b-20">
                        <div class="brand-logo-text mb-2">
                            <span class="text-my">My</span><span class="text-garden">Garden</span>
                        </div>
                    </div>
                    <form action="#">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white" style="border-radius: 8px 0 0 8px;"><i class="ti-email"></i></span>
                            </div>
                            <input type="email" class="form-control form-control-lg" placeholder="Email Address" required>
                        </div>
                        <div class="row m-t-20 p-t-20 border-top border-secondary">
                            <div class="col-12">
                                <button class="btn btn-secondary" id="to-login" type="button">Back To Login</button>
                                <button class="btn btn-info float-right" type="button" style="background: #FF5E00; border: none;">Recover</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".preloader").fadeOut();

            $('#to-recover').on("click", function() {
                $('#loginform').hide();
                $('#recoverform').fadeIn();
            });

            $('#to-login').on('click', function() {
                $('#recoverform').hide();
                $('#loginform').fadeIn();
            });
        });
    </script>
</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | Lexa - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <h3 class="text-center mt-5 mb-4">
                                <a href="#" class="d-block auth-logo">
                                    <img src="assets/images/logo-dark.png" alt="" height="30" class="auth-logo-dark">
                                    <img src="assets/images/logo-light.png" alt="" height="30" class="auth-logo-light">
                                </a>
                            </h3>
                            <div class="p-3">
                                <h4 class="text-muted font-size-18 mb-1 text-center">Free Register</h4>
                                <p class="text-muted text-center">Get your free Lexa account now.</p>
                                <form class="form-horizontal mt-4" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="useremail">Email</label>
                                        <input type="email" class="form-control" id="useremail" name="email" placeholder="Enter email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username">Nombre</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password-confirm">Confirm Password</label>
                                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname">Apellido</label>
                                        <input type="text" class="form-control" id="lastname" name="apellido" placeholder="Enter last name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="identification-number">Número de Identificación</label>
                                        <input type="text" class="form-control" id="identification-number" name="numero_identificacion" placeholder="Enter identification number" required>
                                    </div>
                                    <input type="hidden" name="idtipo_usuario" value="3">
                                    <div class="mb-3 row mt-4">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
                                        </div>
                                    </div>
                                    <div class="mb-0 row">
                                        <div class="col-12 mt-4">
                                            <p class="text-muted mb-0 font-size-14">By registering you agree to the Lexa <a href="#" class="text-primary">Terms of Use</a></p>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Already have an account ? <a href="{{ route('login') }}" class="text-primary"> Login </a> </p>
                        © <script>document.write(new Date().getFullYear())</script> Lexa <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>

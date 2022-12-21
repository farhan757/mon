@extends('layouts.masterauth')

@section('titlebar', 'Login')

@section('content-auth')
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form class="row g-3" action="">
                        <div class="card-group d-block d-md-flex row">
                            <div class="card col-md-7 p-4 mb-0">
                                <div class="card-body">
                                    <h1>Login</h1>
                                    <p class="text-medium-emphasis">Sign In to your account</p>
                                    <div class="input-group mb-3"><span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                            </svg></span>
                                        <input class="form-control invalid" type="text" placeholder="Username"
                                            id="username" name="username" required autofocus autocomplete="off">
                                        <div class="invalid-feedback">Please provide a valid city.</div>
                                    </div>
                                    <div class="input-group mb-4"><span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                                            </svg></span>
                                        <input class="form-control" type="password" placeholder="Password" id="password"
                                            name="password" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" id="btn-login" class="btn btn-primary px-5"
                                                onclick="login()">.:Login:.</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-5 text-white bg-danger py-5">
                                <div class="card-body text-center">
                                    <div>
                                        <h2>GMP | Integrity</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua.</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function login() {
            var username = $("#username").val();
            var password = $("#password").val();

            if (username == "" && password == "") {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Required!',
                    text: "username dan password kosong",
                    showCancelButton: false,
                    showConfirmButton: true
                })
            }

            if (username == "") {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Required!',
                    text: "username kosong",
                    showCancelButton: false,
                    showConfirmButton: true
                })
            }

            if (password == "") {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Required!',
                    text: "password kosong",
                    showCancelButton: false,
                    showConfirmButton: true
                })
            }

            $("#btn-login").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...');
            $("#btn-login").prop('disabled', true);

            $.ajax({
                url: "{{ route('login') }}",
                type: "POST",
                dataType: "JSON",
                cache: false,
                data: {
                    username: username,
                    password: password,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Login Berhasil!',
                            text: 'Anda akan di arahkan ke Dashboard',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                        .then(function() {
                            window.location.href = "{{ route('home') }}";
                        })
                },
                error: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        text: response.responseJSON.message,
                        showCancelButton: false,
                        showConfirmButton: true
                    }).then(function() {
                        $("#btn-login").html('.:Login:.');
                        $("#btn-login").prop('disabled', false);

                        $("#username").val('');
                        $("#password").val('');
                    })
                }
            });
        }
    </script>
@endsection

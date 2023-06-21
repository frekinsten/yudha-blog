<div class="modal fade" id="modalLoginRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-primary nav-justified mb-0" role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="#login" aria-controls="login" role="tab" data-toggle="tab" class="nav-link active">
                        Login
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#register" aria-controls="register" role="tab" data-toggle="tab" class="nav-link">
                        Register
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="login">
                    <form id="formLogin" method="post">
                        <div class="modal-body">
                            <ul id="errLogin" class="pl-0" style="list-style-type: disc;"></ul>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 px-0">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                    placeholder="Email..." />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 px-0">
                                <label for="inputPassword">Password</label>
                                <button id="toggle-password" type="button"
                                    class="float-right border-0 bg-transparent pt-1 pb-0"
                                    aria-label="Show password as plain text. Warning: this will display your password on the screen.">
                                    Show password
                                </button>
                                <input type="password" class="form-control" id="inputPassword" name="password"
                                    placeholder="Password..." />
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-info">Masuk</button>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="register">
                    <form id="formRegister" method="post">
                        <div class="modal-body">
                            <ul id="errRegister" class="pl-0" style="list-style-type: disc;"></ul>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 px-0">
                                <label for="inputName">Nama</label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                    placeholder="Name..." />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 px-0">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                    placeholder="Email..." />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 px-0">
                                <label for="passwordRegister">Password</label>
                                <button id="toggle-password-register" type="button"
                                    class="float-right border-0 bg-transparent pt-1 pb-0"
                                    aria-label="Show password as plain text. Warning: this will display your password on the screen.">
                                    Show password
                                </button>
                                <input type="password" class="form-control" id="passwordRegister" name="password"
                                    autocomplete="current-password" placeholder="Password..." />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3 px-0">
                                <label for="password-confirmation">
                                    Ulangi Password
                                </label>
                                <input type="password" id="password-confirmation" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="Ulangi password..." />
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-info">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const passwordInput = document.getElementById('inputPassword');
        const passwordRegister = document.getElementById('passwordRegister');
        const passwordConfirmationInput = document.getElementById('password-confirmation');

        const togglePasswordButton = document.getElementById('toggle-password');
        const togglePasswordRegisterButton = document.getElementById('toggle-password-register');

        togglePasswordButton.addEventListener('click', togglePassword);
        togglePasswordRegisterButton.addEventListener('click', togglePasswordRegister);

        function togglePassword() {
            if (passwordInput.type === 'password' || passwordRegister.type === 'password') {
                passwordInput.type = 'text';
                passwordRegister.type = 'text';
                togglePasswordButton.textContent = 'Hide password';
                togglePasswordButton.setAttribute('aria-label', 'Hide password.');
            } else {
                passwordInput.type = 'password';
                passwordRegister.type = 'password';
                togglePasswordButton.textContent = 'Show password';
                togglePasswordButton.setAttribute('aria-label',
                    'Show password as plain text. Warning: this will display your password on the screen.');
            }
        }

        function togglePasswordRegister() {
            if (passwordRegister.type === 'password' || passwordConfirmationInput.type === 'password') {
                passwordRegister.type = 'text';
                passwordConfirmationInput.type = 'text';
                togglePasswordRegisterButton.textContent = 'Hide password';
                togglePasswordRegisterButton.setAttribute('aria-label', 'Hide password.');
            } else {
                passwordRegister.type = 'password';
                passwordConfirmationInput.type = 'password';
                togglePasswordRegisterButton.textContent = 'Show password';
                togglePasswordRegisterButton.setAttribute('aria-label',
                    'Show password as plain text. Warning: this will display your password on the screen.');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            let searchParams = new URLSearchParams(location.search);
            if (searchParams.has('open-modal')) {
                $('#modalLoginRegister').modal('show');
            }

            $('#formLogin').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: '{{ url('auth/login') }}',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function() {
                        window.location.assign("{{ url('/') }}");
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 422) {
                            let html = '<div class="alert alert-danger py-2">';
                            $.each(jqXHR.responseJSON.errors, function(_, val) {
                                html += `<li>${val}</li>`;
                            });
                            html += '</div>';

                            setTimeout(function() {
                                $('.alert').fadeTo(200, 0).slideUp(500, () =>
                                    $(this).remove()
                                );
                            }, 5000);

                            $('#errLogin').html(html);
                        }
                        if (jqXHR.status === 401) {
                            let respText = $.parseJSON(jqXHR.responseText);
                            let html = `
                                <div class="alert alert-danger p-2">
                                    <p class="mb-0">${respText.error}</p>
                                </div>
                            `;

                            setTimeout(function() {
                                $('.alert').fadeTo(200, 0).slideUp(500, () =>
                                    $(this).remove()
                                );
                            }, 5000);

                            $('#errLogin').html(html);
                        }
                    }
                });
            });

            $('#formRegister').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: '{{ url('auth/register') }}',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function() {
                        window.location.assign("{{ url('posts?open-modal=true') }}");
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            let html = '<div class="alert alert-danger py-2">';
                            $.each(response.responseJSON.errors, function(_, val) {
                                html += `<li>${val}</li>`;
                            });
                            html += '</div>';

                            setTimeout(function() {
                                $('.alert').fadeTo(200, 0).slideUp(500, () =>
                                    $(this).remove()
                                );
                            }, 5000);

                            $('#errRegister').html(html);
                        }
                    }
                });
            });
        })
    </script>
@endpush

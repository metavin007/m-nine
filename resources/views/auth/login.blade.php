<x-guest-layout>
    <div class="row h-100">   
        <div class="col-lg-4 text-center" style="background-color: #f2f7ff;">

        </div>
        <div class="col-lg-4 text-center">
            <div id="auth-left">
                <!--                <div class="mb-4">
                                    <a href="#"><img src="{{ asset('assets/logo/logopng.jpg') }}" alt="Logo"></a>
                                </div>-->
                <h1 class="auth-title text-center">M-NINE</h1>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control form-control-lg" placeholder="Username" type="email" name="email" required autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control form-control-lg" placeholder="Password"  type="password" name="password" required autocomplete="current-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4 text-center" style="background-color: #f2f7ff;">

        </div>
    </div>

</x-guest-layout>

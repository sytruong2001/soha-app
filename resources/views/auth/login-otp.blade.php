<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        @if ($info_phone == null)
            <form method="POST" action="{{ url('login-otp') }}">
                @csrf
                <div>Vui lòng nhập số điện thoại của bạn để nhận mã OTP</div>
                <div>
                    <x-label for="email" :value="__('Phone')" />
                    <x-input id="phone" class="block mt-1 w-full" type="number" name="phone" required autofocus />
                    <span class="text-danger error-text phone_error"></span>
                </div>

                <!-- OTP -->
                <div class="mt-4 otp">
                    <x-label for="password" :value="__('OTP')" />

                    <x-input id="otp" class="block mt-1 w-full" type="number" name="otp" />
                    <x-input type="number" id="id" name="id" value="{{ $id }}" hidden />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <!-- @if (Route::has('password.request'))
<a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
@endif -->

                    <x-button class="ml-3 otp" type="submit">
                        {{ __('Login') }}
                    </x-button>
                </div>
            </form>
            <div class="flex items-center justify-end mt-4 send-otp">
                <x-button class="ml-3" onclick="sendOtp()">
                    {{ __('Send OTP') }}
                </x-button>
            </div>
        @else
            <form method="POST" action="{{ url('login-otp') }}">
                @csrf
                <div>Nhập mã OTP được gửi đến số {{ $info->phone }}</div>
                <div class="mt-4">
                    <x-label for="password" :value="__('OTP')" />

                    <x-input id="otp" class="block mt-1 w-full" type="number" name="otp" />
                </div>
                <x-input type="number" name="id" value="{{ $info->user_id }}" hidden />
                <div class="flex items-center justify-end mt-4">
                    <!-- @if (Route::has('password.request'))
<a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
@endif -->

                    <x-button class="ml-3" type="submit">
                        {{ __('Login') }}
                    </x-button>
                </div>
        @endif
        </form>

    </x-auth-card>

</x-guest-layout>
<script>
    $('.otp').hide();
    const base_api = location.origin + '/api';
    var url = base_api + '/login';

    function sendOtp() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // alert($('#phone').val());
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                'phone': $('#phone').val(),
                'id': $('#id').val(),
            },
            beforeSend: function(error) {
                $(document).find('span.error-text').text('');
            },
            success: function(data) {
                // alert(data);
                if (data.status == 0) {
                    $.each(data.error, function(prefix, val) {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    $('.otp').show();
                    $('.send-otp').hide();
                }
            },
            error: function() {
                console.log('error');
            }
        });
    }
</script>

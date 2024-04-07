@if (App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first() != null &&
    App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first()->activated == 1)
    @if (helper::appdata('')->recaptcha_version == 'v2')
        <div class="col-12">
            <div class="g-recaptcha" data-sitekey="{{ helper::appdata('')->google_recaptcha_site_key }}"></div>
            @if ($errors->has('g-recaptcha-response'))
                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
            @endif
        </div>
    @endif

    @if (helper::appdata('')->recaptcha_version == 'v3')
        <div class="col-12">
            {!! RecaptchaV3::field('contact') !!}
            @if ($errors->has('g-recaptcha-response'))
                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
            @endif
        </div>
    @endif
@endif

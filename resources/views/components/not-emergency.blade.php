<div {{ $attributes->merge(['class' => 'ae-note']) }} role="note">
    <x-icon name="ambulance" class="h-6 w-6" />
    <p><strong>This form is not for emergencies.</strong> If you or someone with you is unwell now, come straight to our 24-hour emergency room or call <a href="tel:{{ ccmc('ambulance') }}" class="font-bold underline">{{ ccmc('ambulance') }}</a> for an ambulance. You can also call us on <a href="{{ tel_href(main_phone()) }}" class="font-bold underline whitespace-nowrap">{{ format_phone(main_phone()) }}</a>, day or night.</p>
</div>

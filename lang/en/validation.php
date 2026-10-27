<?php

// Merged over the framework's own validation messages: plain-words versions for the public forms.
return [
    'custom' => [
        'phone' => ['regex' => 'Enter a phone number with at least 7 digits.'],
        'email' => ['required_if' => 'Add your email address, or choose another way for us to reach you.'],
    ],
    'attributes' => [
        'contact_pref' => 'best way to reach you',
    ],
];

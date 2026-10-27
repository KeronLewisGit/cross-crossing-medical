<?php

/*
 * Every fact the site shows about Cross Crossing Medical Centre, in one place.
 * Read with ccmc('key'). Sources are noted per block; anything marked
 * "confirm" is listed in README.md under "Before launch: confirm with the client".
 * Never add doctors' names, prices, statistics, testimonials, accreditations or insurers
 * unless the centre supplies them.
 */
return [

    'name' => 'Cross Crossing Medical Centre',
    'short_name' => 'CCMC',

    // true on the temporary preview domain: banner + noindex. Remove at launch.
    'preview' => (bool) env('CCMC_PREVIEW', false),

    // Source: sites.google.com/site/ccmctt (Contact page) and the UK FCDO list of medical providers in T&T (updated 10 Nov 2021).
    'phones' => array_values(array_filter(array_map('trim', explode(',', (string) env('CCMC_PHONES', '868-652-4411,868-652-4412'))))),
    'fax' => env('CCMC_FAX', '868-652-4413'),
    'email' => env('CCMC_EMAIL', 'mail@ccmctt.com'),
    'facebook' => 'https://www.facebook.com/ccmctt',

    // T&T emergency ambulance number (FCDO travel advice: "dial 811 and ask for an ambulance").
    'ambulance' => '811',

    // Source: FCDO list ("Oliver Avenue, Cross Crossing, San Fernando"); "near Halliburton" from the centre's own welcome text.
    // Map pin from the Location page of the Google Site.
    'address' => [
        'street' => 'Oliver Avenue',
        'area' => 'Cross Crossing',
        'city' => 'San Fernando',
        'country' => 'Trinidad and Tobago',
        'country_code' => 'TT',
        'landmark' => 'near Halliburton, in the suburban area of San Fernando',
    ],
    'geo' => ['lat' => 10.26146, 'lng' => -61.462408],
    'map_url' => 'https://www.google.com/maps/search/?api=1&query=10.26146%2C-61.462408',

    // "We are open 24 hour a day / 7 days a week / 365 days a year" (welcome text).
    // Clinic and test sessions are booked by phone today; their days are not published (confirm).
    'open_247' => true,

    // Who gets "new request" emails, comma separated. Careers go to the HR address when set.
    'notify' => env('CCMC_NOTIFY_EMAIL', ''),
    'notify_hr' => env('CCMC_NOTIFY_HR_EMAIL', ''),

    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    // Visiting (holiday) dialysis is not mentioned anywhere CCMC publishes. Off until the unit confirms it.
    'dialysis_visitors' => (bool) env('CCMC_DIALYSIS_VISITORS', false),

    /*
     * Departments, from the Google Site's Facilities and Services pages. "code" is the
     * ward-sign code shown on the room-plate cards. "photo" is a key in 'photos'.
     */
    'departments' => [
        'accident-emergency' => [
            'code' => 'A&E',
            'name' => 'Accident and Emergency',
            'short' => '24-hour emergency room, open every day of the year.',
            'photo' => 'emergency-sign',
            'photo2' => 'emergency',
            'body' => [
                'Our emergency room is open 24 hours a day, 7 days a week, 365 days a year, staffed by physicians and a full nursing team.',
                'You do not need an appointment for the emergency room. Come straight in, or call ahead on the main line so the team knows you are on your way.',
                'Emergency dental care is also available through the emergency room, at any hour.',
            ],
            'points' => ['24-hour emergency room', 'Physicians and full nursing staff on site day and night', 'Emergency dental care through the emergency room', 'Lab, X-ray and the cardiac care unit under the same roof'],
            'emergency' => true,
        ],
        'cardiac' => [
            'code' => 'CCU',
            'name' => 'Cardiac care',
            'short' => 'Cardiac care unit, echocardiograms, ECGs, stress tests and Holter monitoring.',
            'photo' => 'cardiac',
            'photo2' => 'hospital-sign',
            'body' => [
                'The cardiac care unit is complete with cardiac monitoring and resuscitation equipment, and is staffed by 24-hour nursing and physician services.',
                'Heart tests are done on site: echocardiograms, electrocardiograms (ECG), stress testing and Holter monitors.',
                'We also offer a full inpatient unit for all other medical admissions.',
            ],
            'points' => ['Cardiac care unit with monitoring and resuscitation equipment', 'Echocardiogram', 'Electrocardiogram (ECG)', 'Stress testing', 'Holter monitors', 'Full inpatient unit for other medical admissions'],
            'bookable' => true,
        ],
        'dialysis' => [
            'code' => 'RD',
            'name' => 'Renal Centre & Dialysis Unit',
            'short' => 'A dedicated dialysis unit. New patients start with an examination and review.',
            'photo' => 'renal-sign',
            'photo2' => 'dialysis',
            'body' => [
                'We have a dedicated dialysis unit: the Renal Centre and Dialysis Unit.',
                'New to the unit? The first step is an initial dialysis examination and review by our physicians. Send an enquiry below and the unit will call you to arrange it.',
            ],
            'points' => ['Dedicated dialysis unit', 'Initial dialysis examination and review by our physicians for new patients', 'Lab and cardiac services in the same building'],
        ],
        'laboratory' => [
            'code' => 'LAB',
            'name' => 'Laboratory',
            'short' => 'Full laboratory services on site.',
            'photo' => 'laboratory',
            'photo2' => 'lab-coat',
            'body' => [
                'The centre has a full laboratory on site, so tests ordered by our physicians and the emergency room are processed under the same roof.',
                'Results are never shown on this website. When your results are ready, the centre will let you know how to collect them.',
            ],
            'points' => ['Full laboratory services on site', 'Results never shown on the website'],
            'bookable' => true,
        ],
        'imaging' => [
            'code' => 'XR',
            'name' => 'X-ray and bone density',
            'short' => 'X-ray facilities and bone density (DEXA) scans with body composition.',
            'photo' => 'imaging',
            'photo2' => 'dexa-report',
            'body' => [
                'X-ray facilities are on site, alongside bone density (DEXA) scanning.',
                'A DEXA scan can also measure total body composition. After the scan the report is printed straight away and your doctor will discuss the results with you.',
            ],
            'points' => ['X-ray facilities', 'Bone density (DEXA) scans', 'Total body composition analysis by DEXA'],
            'bookable' => true,
        ],
        'surgery' => [
            'code' => 'OR',
            'name' => 'Surgical suites',
            'short' => 'Surgical suites and minor outpatient surgery.',
            'photo' => 'surgery',
            'photo2' => 'ward',
            'body' => [
                'The centre has its own surgical suites and handles minor outpatient surgeries.',
                'Surgery is arranged through one of our physicians. Request a clinic appointment to start.',
            ],
            'points' => ['Surgical suites', 'Minor outpatient surgery', 'Orthopaedic surgery and urology clinics'],
        ],
        'sleep-lung' => [
            'code' => 'PFT',
            'name' => 'Sleep and lung tests',
            'short' => 'Sleep studies at home and lung function testing.',
            'photo' => 'consultation',
            'body' => [
                'Sleep studies are done as an in-home study, so you sleep in your own bed.',
                'Lung function testing is done at the centre.',
            ],
            'points' => ['Sleep studies (in-home study)', 'Lung function testing'],
            'bookable' => true,
        ],
        'vaccinations' => [
            'code' => 'VAX',
            'name' => 'Vaccinations',
            'short' => 'Complete vaccines for the whole family.',
            'photo' => 'vaccination',
            'body' => [
                'We offer complete vaccines for the whole family, from babies to adults.',
                'Immunisations teach your body how to defend itself against germs such as viruses and bacteria, so that you either do not become ill or have a milder infection.',
            ],
            'points' => ['Vaccines for babies, children and adults', 'Call to check which vaccines are in stock before you come'],
            'bookable' => true,
        ],
        'dental' => [
            'code' => 'DEN',
            'name' => 'Dental',
            'short' => 'Easy Smile Dental Centre, plus 24-hour emergency dental care.',
            'photo' => 'dental',
            'body' => [
                'Dental appointments are with Easy Smile Dental Centre, which books its own appointments by phone.',
                'Emergency dental care is available 24 hours a day through our emergency room.',
            ],
            'points' => ['Easy Smile Dental Centre', '24-hour emergency dental care through the emergency room'],
            'phones' => ['868-721-5846', '868-382-5846'],
            'partner' => 'Easy Smile Dental Centre',
        ],
    ],

    /*
     * Specialist clinics, from the Physicians page ("We have many specialist physicians
     * for most medical needs…") and the welcome text (paediatric and women's healthcare).
     * No physician names are published, so none are shown.
     */
    'clinics' => [
        'family-practice' => 'Family practice',
        'internal-medicine' => 'Internal medicine',
        'cardiology' => 'Cardiology',
        'endocrinology' => 'Endocrinology (diabetes, thyroid, hormones)',
        'rheumatology' => 'Rheumatology (arthritis, joints)',
        'orthopaedic-surgery' => 'Orthopaedic surgery',
        'urology' => 'Urology',
        'psychiatry' => 'Psychiatry',
        'occupational-health' => 'Occupational health',
        'paediatrics' => 'Paediatric care',
        'womens-health' => "Women's healthcare",
    ],

    // Tests and procedures from the Services page, bookable through the appointment form.
    'tests' => [
        'dexa' => 'Bone density (DEXA) scan',
        'body-composition' => 'DEXA body composition analysis',
        'sleep-study' => 'Sleep study (in-home)',
        'echo' => 'Echocardiogram',
        'ecg' => 'Electrocardiogram (ECG)',
        'stress-test' => 'Stress test',
        'holter' => 'Holter monitor',
        'lung-function' => 'Lung function test',
        'xray' => 'X-ray',
        'lab' => 'Laboratory tests',
        'vaccination' => 'Vaccination',
        'minor-surgery' => 'Minor outpatient surgery (consultation)',
    ],

    // Appointment form: when the patient would like to come. The centre calls back to confirm a real time.
    'time_windows' => [
        'morning' => 'Morning',
        'afternoon' => 'Afternoon',
        'evening' => 'Evening',
        'any' => 'Any time',
    ],
    'weekdays' => ['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'],
    'days_ahead' => 60,

    // Dialysis enquiry choices.
    'dialysis' => [
        'situations' => [
            'new' => 'Not on dialysis yet; my doctor has referred me or says I may need it',
            'transfer' => 'On dialysis at another unit and would like to transfer',
            'visiting' => 'Visiting Trinidad and need dialysis during my stay',
            'information' => 'I would like information for a family member',
        ],
        'schedules' => [
            'mwf' => 'Monday, Wednesday, Friday',
            'tts' => 'Tuesday, Thursday, Saturday',
            'either' => 'Either pattern',
        ],
        'shifts' => ['morning' => 'Morning', 'afternoon' => 'Afternoon', 'evening' => 'Evening', 'any' => 'No preference'],
    ],

    // Careers: the roles a 24-hour centre with A&E, CCU, dialysis, lab and imaging recruits for.
    // No vacancies are published today, so the general application is the main route.
    'career_roles' => [
        'registered-nurse' => 'Registered nurse',
        'nursing-assistant' => 'Enrolled nursing assistant',
        'patient-care' => 'Patient care assistant',
        'dialysis' => 'Dialysis nurse or technician',
        'lab' => 'Medical laboratory technologist',
        'radiography' => 'Radiographer',
        'physician' => 'Physician',
        'admin' => 'Reception, records or administration',
        'other' => 'Other',
    ],
    'availability' => [
        'full-time' => 'Full-time',
        'part-time' => 'Part-time',
        'shifts' => 'Shift work, including nights',
        'relief' => 'Relief or locum',
    ],

    /*
     * The "Media" page of the Google Site: journal publications and newspaper columns
     * by Cross Crossing physicians. Titles and outlets only (most links have gone dead).
     */
    'media' => [
        'research' => [
            ['title' => 'Cardiovascular risk assessment', 'outlet' => 'West Indian Medical Journal (2009)'],
            ['title' => 'Predictors of ten-year survival following acute myocardial infarction in San Fernando, Trinidad', 'outlet' => 'Journal article'],
        ],
        'press' => [
            ['title' => 'Unhealthy handbags', 'outlet' => 'Trinidad Express'],
            ['title' => 'Heart disease', 'outlet' => 'Trinidad Guardian'],
            ['title' => 'Hypertension', 'outlet' => 'Trinidad and Tobago Heart Foundation newsletter'],
            ['title' => 'Nothing to snore about (insomnia and sleep)', 'outlet' => 'Trinidad Express'],
            ['title' => 'A disease of the nervous system (multiple sclerosis)', 'outlet' => 'Trinidad Express'],
            ['title' => 'To purge or not to purge ("worm out")', 'outlet' => 'Trinidad Express'],
            ['title' => 'Obesity in children on the rise', 'outlet' => 'Trinidad Express, the Ministry of Health and CTNT'],
        ],
    ],

    // Self-checks the Google Site links to, kept with their original providers.
    'self_checks' => [
        ['title' => 'Are you at risk for diabetes?', 'body' => 'A one-minute prediabetes risk test. If you are at risk, talk to us about testing to confirm.', 'url' => 'https://www.cdc.gov/prediabetes/risktest/index.html', 'source' => 'US Centers for Disease Control and Prevention'],
        ['title' => 'Are you at risk for a fracture?', 'body' => 'The FRAX tool estimates your 10-year fracture risk. If you score moderate to high, you may need a bone density scan; talk to your doctor.', 'url' => 'https://frax.shef.ac.uk/FRAX/', 'source' => 'University of Sheffield'],
    ],

    /*
     * Photo metadata for photo(): native size of public/img/{key}-*.webp.
     * Filled in by scripts/photos.py; see config/photo-credits.php for the source of each.
     */
    'photos' => require __DIR__.'/photos.php',
];

<?php

/*
 * Every photo on the site and where it came from. The centre's own photos are from its
 * Google Site (sites.google.com/site/ccmctt), used for this proposal; replace them with
 * higher-resolution originals. The rest are from Wikimedia Commons (October 2026);
 * attribution is required by each licence, and CC BY-SA photos stay under their licence.
 */
$own = fn (string $title) => ['title' => $title, 'author' => 'Cross Crossing Medical Centre', 'license' => "The centre's own photo, from its website", 'license_url' => null, 'source' => 'https://sites.google.com/site/ccmctt/', 'own' => true];

return [
    'building' => $own('The centre on Oliver Avenue, with the CCMC sign over the entrance'),
    'lettering' => $own('Cross Crossing Medical Centre lettering at reception'),
    'emergency-sign' => $own('The Emergency sign'),
    'renal-sign' => $own('Renal Centre & Dialysis Unit sign'),
    'hospital-sign' => $own('The Hospital sign'),
    'reception' => $own('Reception and waiting area'),
    'lab-coat' => $own('A CCMC lab coat and framed certificates'),
    'direction-sign' => $own('Roadside sign pointing to the centre'),
    'building-street' => $own('The approach along the street to the centre'),
    // A GE Lunar vendor sample ("Patient: Sample, Report"), as shown on the centre's website: not
    // a real patient's report and not the centre's own photo. Replace before launch (README).
    'dexa-report' => ['title' => 'A sample DEXA body-composition report (GE Lunar), as shown on the centre\'s website', 'author' => 'GE Medical Systems (Lunar) sample, via the centre\'s website', 'license' => 'Shown on the centre\'s current website; to be replaced', 'license_url' => null, 'source' => 'https://sites.google.com/site/ccmctt/self-evaluation/obesity', 'own' => true],
    'san-fernando' => ['title' => 'STAPP 036 San Fernando Panorama.jpg', 'author' => 'Grueslayer', 'license' => 'CC BY-SA 4.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:STAPP_036_San_Fernando_Panorama.jpg'],
    'dialysis' => ['title' => 'Hemodialysis machine INNOVA.jpg', 'author' => 'Vitaly Pospelov', 'license' => 'CC BY-SA 3.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/3.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Hemodialysis_machine_INNOVA.jpg'],
    'laboratory' => ['title' => 'Hospital das Clínicas (42898632534).jpg', 'author' => 'Governo do Estado de São Paulo', 'license' => 'CC BY 2.0', 'license_url' => 'https://creativecommons.org/licenses/by/2.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Hospital_das_Cl%C3%ADnicas_(42898632534).jpg'],
    'imaging' => ['title' => 'Medical professional examines chest X-ray in a hospital setting.jpg', 'author' => 'Shixart1985 (Nenad Stojkovic)', 'license' => 'CC BY 2.0', 'license_url' => 'https://creativecommons.org/licenses/by/2.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Medical_professional_examines_chest_X-ray_in_a_hospital_setting.jpg'],
    'surgery' => ['title' => 'Operating-room 1.jpg', 'author' => 'Yonsei Gunwoo Hospital', 'license' => 'CC BY 4.0', 'license_url' => 'https://creativecommons.org/licenses/by/4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Operating-room_1.jpg'],
    'cardiac' => ['title' => 'Vital signs monitor display.jpg', 'author' => 'Petty Officer 1st Class James Stenberg, U.S. Navy', 'license' => 'Public domain', 'license_url' => null, 'source' => 'https://commons.wikimedia.org/wiki/File:Vital_signs_monitor_display.jpg'],
    'nursing' => ['title' => "Nurse at St Jude's Hospital, St Lucia, Caribbean, 2006 (10711209966).jpg", 'author' => 'Department of Foreign Affairs and Trade (AusAID)', 'license' => 'CC BY 2.0', 'license_url' => 'https://creativecommons.org/licenses/by/2.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Nurse_at_St_Jude%27s_Hospital,_St_Lucia,_Caribbean,_2006._Photo-_AusAID_(10711209966).jpg'],
    'consultation' => ['title' => 'The Stethoscope, Peru.jpg', 'author' => 'Alex Proimos', 'license' => 'CC BY 2.0', 'license_url' => 'https://creativecommons.org/licenses/by/2.0', 'source' => 'https://commons.wikimedia.org/wiki/File:The_Stethoscope,_Peru.jpg'],
    'vaccination' => ['title' => 'Influenza Vaccine (51551576704).jpg', 'author' => 'Pete from Liverpool, UK', 'license' => 'CC0', 'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/', 'source' => 'https://commons.wikimedia.org/wiki/File:Influenza_Vaccine_(51551576704).jpg'],
    'dental' => ['title' => 'A dentists office in Dubai.jpg', 'author' => 'Challiyan', 'license' => 'CC BY-SA 4.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:A_dentists_office_in_Dubai.jpg'],
    'ward' => ['title' => 'St John of God Midland Private Hospital, August 2026 10.jpg', 'author' => 'Samuel Wiki', 'license' => 'CC0', 'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/', 'source' => 'https://commons.wikimedia.org/wiki/File:St_John_of_God_Midland_Private_Hospital,_August_2026_10.jpg'],
    'emergency' => ['title' => 'CHUM Emergency Level Resuscitation.jpg', 'author' => 'Calvin411', 'license' => 'CC BY-SA 4.0', 'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:CHUM_Emergency_Level_Resuscitation.jpg'],
];

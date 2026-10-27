<x-layouts.site title="Privacy notice" description="How Cross Crossing Medical Centre collects, uses and protects personal and health information sent through this website, under the Data Protection Act, 2011 of Trinidad and Tobago.">
    <x-page-header title="Privacy notice" lead="How we handle the personal and health information you send through this website." code="DPA" label="Privacy" photo="lab-coat" photo-alt="A Cross Crossing Medical Centre lab coat beside framed certificates" />
    <div class="wrap mt-12 md:mt-16">
        <p class="max-w-3xl rounded-xl bg-soft p-4 text-[0.9375rem] font-semibold">Draft for the centre's review: this notice must be checked by the centre and its legal adviser before the site goes live.</p>
        <div class="prose-copy measure mt-10 text-lg">
            <h2>Who we are</h2>
            <p>{{ ccmc('name') }}, {{ ccmc('address.street') }}, {{ ccmc('address.area') }}, {{ ccmc('address.city') }}, Trinidad and Tobago ("the centre", "we"). You can contact us about your information at <a href="mailto:{{ ccmc('email') }}">{{ ccmc('email') }}</a> or on {{ format_phone(main_phone()) }}.</p>

            <h2>What this website collects</h2>
            <p>Only what you type into a form, and the files you choose to attach:</p>
            <ul>
                <li><strong>Appointment requests:</strong> the patient's name and date of birth, the clinic or test, the days and times that suit, a short reason, and an optional referral letter.</li>
                <li><strong>New patient registration:</strong> the patient's name, date of birth, address, emergency contact, ID type, insurer, and optional photos of the ID and insurance card.</li>
                <li><strong>Dialysis enquiries:</strong> the patient's situation, preferred sessions and an optional referral or dialysis summary.</li>
                <li><strong>Job applications:</strong> your CV, certificates, experience and availability.</li>
                <li><strong>Messages:</strong> what you write to us.</li>
            </ul>
            <p>For every form we also keep your phone number, optional email address, how you prefer to be contacted, the page you sent it from, and the date and time you gave consent.</p>
            <p>We do not use advertising or tracking cookies. The website sets only the two cookies that keep forms secure (a session cookie and a security token).</p>

            <h2>Why we use it</h2>
            <p>To call you back, book the appointment or assessment you asked for, open a patient file, or consider your job application. We use it only for the purpose you consented to on the form, and never sell or share it for marketing.</p>
            <p>Sensitive personal information, including health information, is handled with the extra care the Data Protection Act, 2011 requires.</p>

            <h2>Who can see it</h2>
            <p>Each request is seen only by the team that handles it (front desk and appointments, registration and medical records, or human resources) and by the centre's administrators. Photos of ID and insurance cards are stored privately, off the public website, and can be opened only by the registration and medical records team. Every opening is logged with the staff member and the time.</p>
            <p>Confirmation emails contain your reference number only, never health or identity details. Test results are never published on this website or sent by email.</p>

            <h2>How long we keep it</h2>
            <p>Appointment and dialysis requests and messages: 12 months after the request is closed, unless they become part of a patient file. Registration details become part of the patient's medical record and are kept as medical records must be. Job applications: six months, unless you are hired.</p>

            <h2>Your rights</h2>
            <p>You can ask to see the information we hold about you, ask us to correct it, or withdraw your consent, by writing to <a href="mailto:{{ ccmc('email') }}">{{ ccmc('email') }}</a> or asking at reception. Withdrawing consent does not affect care already given.</p>

            <h2>Security</h2>
            <p>The website uses an encrypted (HTTPS) connection. Staff sign in with individual accounts, each limited to their own team's work, and inactive accounts are switched off.</p>
        </div>
    </div>
</x-layouts.site>

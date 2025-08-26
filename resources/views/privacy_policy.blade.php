@extends('layout.app')

@section('title-block')
    Privacy Policy - D.N B Motors V
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/privacy-policy.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<main class="privacy-policy-page">
    <div class="page-banner">
        <div class="container">
            <h1>Privacy Policy</h1>
        </div>
    </div>

    <div class="privacy-content">
        <div class="container">
            <div class="policy-text">
                <p class="intro">
                    This privacy notice discloses the privacy practices for this web site. This privacy notice applies solely to information collected by this web site. It will notify you of the following:
                </p>

                <ol class="notice-list">
                    <li>What personally identifiable information is collected from you through the web site, how it is used and with whom it may be shared.</li>
                    <li>What choices are available to you regarding the use of your data.</li>
                    <li>The security procedures in place to protect the misuse of your information.</li>
                    <li>How you can correct any inaccuracies in the information.</li>
                </ol>

                <section class="policy-section">
                    <h2>Information Collection, Use, and Sharing</h2>
                    <p>
                        We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.
                    </p>
                    <p>
                        We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.
                    </p>
                    <p>
                        Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.
                    </p>
                </section>

                <section class="policy-section">
                    <h2>Your Access to and Control Over Information</h2>
                    <p>
                        You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:
                    </p>
                    <ul class="control-list">
                        <li>See what data we have about you, if any.</li>
                        <li>Change/correct any data we have about you.</li>
                        <li>Have us delete any data we have about you.</li>
                        <li>Express any concern you have about our use of your data.</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>Security</h2>
                    <p>
                        We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.
                    </p>
                    <p>
                        Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a closed lock icon at the bottom of your web browser, or looking for "https" at the beginning of the address of the web page.
                    </p>
                    <p>
                        While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.
                    </p>
                    <p>
                        If you feel that we are not abiding by this privacy policy, you should contact us immediately via telephone or via email.
                    </p>
                </section>

                <section class="policy-section">
                    <h2>Cookies</h2>
                    <p>
                        We use "cookies" on this site. A cookie is a piece of data stored on a site visitor's hard drive to help us improve your access to our site and identify repeat visitors to our site. For instance, when we use a cookie to identify you, you would not have to log in a password more than once, thereby saving time while on our site. Cookies can also enable us to track and target the interests of our users to enhance the experience on our site. Usage of a cookie is in no way linked to any personally identifiable information on our site.
                    </p>
                    <p>
                        Some of our business partners may use cookies on our site (for example, advertisers). However, we have no access to or control over these cookies.
                    </p>
                </section>

                <section class="policy-section">
                    <h2>Links</h2>
                    <p>
                        This web site contains links to other sites. Please be aware that we are not responsible for the content or privacy practices of such other sites. We encourage our users to be aware when they leave our site and to read the privacy statements of any other site that collects personally identifiable information.
                    </p>
                </section>

                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p>If you have any questions about this Privacy Policy, please contact us:</p>
                    <ul>
                        <li><strong>Phone:</strong> (405) 210-6854</li>
                        <li><strong>Email:</strong> d.nbmotorsv@gmail.com</li>
                        <li><strong>Address:</strong> 917 Sw 29th st, OKC, OK, 73109</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')

@endpush

@endsection 
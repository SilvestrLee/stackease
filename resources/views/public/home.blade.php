@extends('layouts.public')

@section('content')

<section class="se-ref-hero">
    <div class="se-ref-container se-ref-hero-grid">
        <div class="se-ref-hero-copy">
            <div class="se-ref-pill">Digital tools. Simplified.</div>

            <h1>
                Access the tools your<br>
                business needs.<br>
                We handle the rest.
            </h1>

            <p>
                StackEase helps businesses and creators request, pay for, set up, and manage approved digital tools with ease.
            </p>

            <div class="se-ref-hero-actions">
                <a href="{{ route('concierge') }}" class="se-ref-btn se-ref-btn-primary">Request Setup Help</a>
                <a href="{{ route('services') }}" class="se-ref-btn se-ref-btn-outline">Explore Services</a>
            </div>

            <div class="se-ref-trust">
                <span>🛡</span>
                Secure • Reliable • Trusted by businesses across Nigeria
            </div>

            <div class="se-ref-users">
                <div class="se-ref-avatars">
                    <span></span><span></span><span></span><span></span>
                </div>
                <p>Join 500+ businesses already using StackEase</p>
            </div>
        </div>

        <div class="se-ref-dashboard">
            <div class="se-ref-dashboard-sidebar">
                <div class="se-ref-dash-logo"></div>
                <a class="active">Overview</a>
                <a>My Requests</a>
                <a>Invoices</a>
                <a>Subscriptions</a>
                <a>Support Tickets</a>
                <a>Account Settings</a>

                <div class="se-ref-help">
                    <small>Need help?</small>
                    <strong>Contact Support</strong>
                </div>
            </div>

            <div class="se-ref-dashboard-main">
                <div class="se-ref-dashboard-top">
                    <h3>Overview</h3>
                    <p>Welcome back, Admin 👋</p>
                </div>

                <div class="se-ref-stats">
                    <div>
                        <small>Active Subscriptions</small>
                        <strong>12</strong>
                        <span>+2 this month</span>
                    </div>
                    <div>
                        <small>Pending Requests</small>
                        <strong>2</strong>
                        <span>Awaiting review</span>
                    </div>
                    <div>
                        <small>Unpaid Invoices</small>
                        <strong>1</strong>
                        <span>₦45,500.00</span>
                    </div>
                    <div>
                        <small>Renewals Due Soon</small>
                        <strong>3</strong>
                        <span>Next 30 days</span>
                    </div>
                </div>

                <div class="se-ref-activity">
                    <h4>Recent Activity</h4>

                    <div class="se-ref-activity-row">
                        <span></span>
                        <p>Invoice #INV-4290 was paid<br><small>May 16, 2025 · 10:45 AM</small></p>
                        <em>Paid</em>
                    </div>

                    <div class="se-ref-activity-row">
                        <span></span>
                        <p>Canva Teams request approved<br><small>May 17, 2025 · 01:15 PM</small></p>
                        <em>Approved</em>
                    </div>

                    <div class="se-ref-activity-row">
                        <span></span>
                        <p>Google Workspace setup completed<br><small>May 25, 2025 · 4:20 PM</small></p>
                        <em>Completed</em>
                    </div>

                    <div class="se-ref-activity-row">
                        <span></span>
                        <p>Support ticket #TIC-118 replied<br><small>May 25, 2025 · 08:10 AM</small></p>
                        <em>Replied</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="se-ref-providers">
    <div class="se-ref-container">
        <p>WE HELP YOU ACCESS AND MANAGE TOOLS FROM LEADING PROVIDERS</p>

        <div class="se-ref-provider-row">
            <span>Canva</span>
            <span>Google Workspace</span>
            <span>▣ Notion</span>
            <span>✣ slack</span>
            <span>zoom</span>
            <span>▦ Microsoft 365</span>
            <span>🛡 VPN</span>
        </div>
    </div>
</section>

<section class="se-ref-section">
    <div class="se-ref-container">
        <div class="se-ref-section-head">
            <span>OUR SERVICES</span>
            <h2>Digital tools for every business need</h2>
            <p>We handle setup, payment, access delivery, and ongoing management.</p>
        </div>

        <div class="se-ref-service-grid">
            <article><div>C</div><h3>Canva Teams Support</h3><p>Setup, payment, and team management for Canva Teams.</p><a>Learn more →</a></article>
            <article><div>G</div><h3>Google Workspace</h3><p>Get Google Workspace for your team with expert setup and support.</p><a>Learn more →</a></article>
            <article><div>N</div><h3>Notion Setup</h3><p>Workspace setup, team access, and ongoing support for Notion.</p><a>Learn more →</a></article>
            <article><div>S</div><h3>Slack Setup</h3><p>Get your team connected with Slack workspace setup.</p><a>Learn more →</a></article>
            <article><div>Z</div><h3>Zoom Business</h3><p>Professional Zoom setup for meetings, webinars and teams.</p><a>Learn more →</a></article>
            <article><div>V</div><h3>VPN Solutions</h3><p>Secure and reliable VPN setup for your business needs.</p><a>Learn more →</a></article>
            <article><div>M</div><h3>Microsoft 365</h3><p>Microsoft 365 setup and support for productivity and collaboration.</p><a>Learn more →</a></article>
            <article><div>+</div><h3>More Tools</h3><p>Need something else? We can help with other business tools.</p><a>Learn more →</a></article>
        </div>
    </div>
</section>

<section class="se-ref-process" id="how-it-works">
    <div class="se-ref-container">
        <div class="se-ref-section-head">
            <span>HOW IT WORKS</span>
            <h2>Simple process. Zero stress.</h2>
            <p>From request to setup, we make it easy.</p>
        </div>

        <div class="se-ref-process-row">
            <article><div>1</div><h3>Submit Request</h3><p>Tell us the tool, plan, seats, and setup you need.</p></article>
            <article><div>2</div><h3>Receive Invoice</h3><p>We review and send a clear FX-buffered invoice.</p></article>
            <article><div>3</div><h3>Make Payment</h3><p>Pay securely via Paystack or bank transfer.</p></article>
            <article><div>4</div><h3>We Handle the Rest</h3><p>We setup, deliver access, and manage it for you.</p></article>
            <article><div>5</div><h3>You Stay Productive</h3><p>Focus on your business while we handle the rest.</p></article>
        </div>

        <div class="se-ref-center">
            <a href="{{ route('concierge') }}" class="se-ref-btn se-ref-btn-primary">Start a Request</a>
        </div>
    </div>
</section>

<section class="se-ref-section">
    <div class="se-ref-container">
        <div class="se-ref-section-head">
            <span>WHY STACKEASE?</span>
            <h2>Built for businesses. Backed by trust.</h2>
        </div>

        <div class="se-ref-why-row">
            <article><div>🛡</div><h3>Secure &amp; Compliant</h3><p>We handle sensitive access with strict security and privacy standards.</p></article>
            <article><div>₦</div><h3>Transparent Pricing</h3><p>We review and send fair and no hidden charges.</p></article>
            <article><div>●</div><h3>Expert Support</h3><p>Real people, fast responses, and dedicated support.</p></article>
            <article><div>⚙</div><h3>Reliable &amp; Timely</h3><p>We deliver on time and manage renewals so you don’t have to.</p></article>
        </div>

        <div class="se-ref-dark-cta">
            <div>
                <h2>Ready to simplify your digital stack?</h2>
                <p>Submit your request now and let us handle the rest.</p>
            </div>

            <a href="{{ route('concierge') }}" class="se-ref-btn se-ref-btn-primary">Request Setup Help →</a>
        </div>
    </div>
</section>

@endsection
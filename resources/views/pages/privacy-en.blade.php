@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'BagiResep Privacy Policy. We are committed to protecting your personal data with the highest security standards.')

@section('content')
<section class="relative bg-walnut-900 overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(ellipse_at_top,rgba(217,164,65,0.3),transparent_70%)]"></div>
    <div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-20 md:py-28 text-center relative">
        <p class="text-amber-400/60 text-xs uppercase tracking-[0.4em] font-bold mb-4">Privacy Policy</p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-tight">Your Privacy,<br>Our Responsibilities</h1>
        <p class="text-cream-300/50 text-base mt-6 max-w-xl mx-auto leading-relaxed">We are fully committed to protecting the personal data of every BagiResep user.</p>
        <p class="text-cream-400/30 text-xs mt-8">Berlaku efektif: {{ date('d F Y') }}</p>
    </div>
</section>

<div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-16 md:py-24">
    <div class="prose prose-lg max-w-none">

        <div class="mb-16">
            <p class="text-base text-gray-500 leading-relaxed">BagiResep is a cooking recipe sharing platform managed by<strong class="text-charcoal-500">Strike the Budi of Anarchy</strong>. This policy explains how we collect, use, disclose and protect your information when using our services. By accessing BagiResep, you agree to the practices described in this policy.</p>
        </div>

        <div class="space-y-16">
            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">01</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Information Collected</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>We collect information that you provide directly or that is generated automatically when using the platform:</p>
                    <div class="bg-cream-50 rounded-2xl p-6 border border-cream-200 space-y-3">
                        <p><strong class="text-charcoal-500">Account Information.</strong>Name, email address, and encrypted password provided during registration.</p>
                        <p><strong class="text-charcoal-500">User Content.</strong>Recipes, photos, descriptions, ingredients, cooking steps, ratings, and reviews uploaded to the platform.</p>
                        <p><strong class="text-charcoal-500">Interaction Data.</strong>Your bookmarks, searches and category preferences within the platform.</p>
                        <p><strong class="text-charcoal-500">Technical Data.</strong>IP address, browser type, operating system and pages visited for security and diagnostic purposes.</p>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">02</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Use of Information</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>The information collected is used to:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Provide and maintain platform services</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Personalize the user experience</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Send important account-related communications</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Detect and prevent suspicious activity</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Analyze usage for feature improvements</div>
                        <div class="bg-green-50/70 rounded-xl p-4 border border-green-100 text-sm">Enforce Terms of Use</div>
                    </div>
                    <div class="bg-red-50/70 rounded-2xl p-5 border border-red-100 mt-6">
                        <p class="text-red-600 font-semibold text-sm mb-2">We never:</p>
                        <ul class="space-y-1.5 text-red-600 text-sm">
                            <li>Selling personal data to third parties</li>
                            <li>Using your data for targeted advertising</li>
                            <li>Sharing contact information without explicit permission</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">03</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Data Protection</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>We implement technical and organizational security measures to protect your data:</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">01</span>
                            <p><strong class="text-charcoal-500">Encryption.</strong>Passwords are hashed using the bcrypt algorithm. Data in transit is protected with TLS/SSL encryption.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">02</span>
                            <p><strong class="text-charcoal-500">Limited Access.</strong>Only BagiResep administrators have access to sensitive data, with strict authentication.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">03</span>
                            <p><strong class="text-charcoal-500">Monitoring.</strong>Our systems are regularly checked for known security vulnerabilities.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">04</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Cookies</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>BagiResep uses essential session cookies that are required for basic platform functionality — such as maintaining login state and protecting against CSRF attacks. These cookies are temporary and are deleted when you close your browser.</p>
                    <p>We<strong class="text-charcoal-500">do not use</strong>tracking cookies, advertising cookies, or third party cookies in any form.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">05</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Data Storage</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>Your data is stored on servers located in Indonesia. We retain account information as long as your account is active. Deleted content will be kept for a maximum of 30 days before being permanently deleted. Data may remain in system backups for up to 90 days.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">06</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">User Rights</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>You have full rights over your personal data:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Access rights</p>
                            <p class="text-sm text-gray-400">View your data at any time via the Profile page</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Correction Rights</p>
                            <p class="text-sm text-gray-400">Update your name, email, and password</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Right of Erasure</p>
                            <p class="text-sm text-gray-400">Delete recipes, reviews, or entire accounts</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl p-5">
                            <p class="font-bold text-charcoal-500 mb-1 text-sm">Portability Rights</p>
                            <p class="text-sm text-gray-400">Request a copy of the data in a structured format</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">07</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Children</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>ShareRecipes is not intended for individuals under the age of 13. We do not knowingly collect personal information from children. If you are a parent or guardian and become aware that your child has provided us with personal data, please contact us immediately for deletion of that data.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">08</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Policy Changes</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>This policy may be updated from time to time to reflect changes in practice or legal requirements. Material changes will be announced via email or notice on the platform. Continued use of the service after changes constitutes your consent.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">09</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Contact</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>For questions, data requests, or privacy concerns:</p>
                    <div class="flex flex-col sm:flex-row gap-4 mt-4">
                        <a href="https://wa.me/6285600841078" target="_blank" rel="noopener" class="flex items-center gap-3 bg-white border border-gray-200 hover:border-green-300 rounded-2xl px-5 py-4 transition-all duration-200 group">
                            <span class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-xl group-hover:bg-green-100 transition-colors">WA</span>
                            <div><p class="font-bold text-sm text-charcoal-500">WhatsApp</p><p class="text-xs text-gray-400">0856-0008-41078</p></div>
                        </a>
                        <a href="mailto:icoth@bbg.ac.id" class="flex items-center gap-3 bg-white border border-gray-200 hover:border-amber-300 rounded-2xl px-5 py-4 transition-all duration-200 group">
                            <span class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-xl group-hover:bg-amber-100 transition-colors">@</span>
                            <div><p class="font-bold text-sm text-charcoal-500">E-mail</p><p class="text-xs text-gray-400">icoth@bbg.ac.id</p></div>
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection

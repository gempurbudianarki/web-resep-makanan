@extends('layouts.app')

@section('title', 'Terms of Service')
@section('meta_description', 'BagiResep Terms of Service. Fair and transparent terms to keep our community quality high.')

@section('content')
<section class="relative bg-walnut-900 overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(ellipse_at_top,rgba(217,164,65,0.3),transparent_70%)]"></div>
    <div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-20 md:py-28 text-center relative">
        <p class="text-amber-400/60 text-xs uppercase tracking-[0.4em] font-bold mb-4">Terms of Use</p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-tight">Rules<br>the Fair</h1>
        <p class="text-cream-300/50 text-base mt-6 max-w-xl mx-auto leading-relaxed">Healthy communities are built on clear and transparent rules.</p>
        <p class="text-cream-400/30 text-xs mt-8">Berlaku efektif: {{ date('d F Y') }}</p>
    </div>
</section>

<div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-10 py-16 md:py-24">
    <div class="prose prose-lg max-w-none">

        <div class="mb-16">
            <p class="text-base text-gray-500 leading-relaxed">Welcome to BagiResep. By accessing or using our platform, you agree to these Terms of Use. Please read carefully. If you do not agree to these terms, do not use our services.</p>
        </div>

        <div class="space-y-16">
            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">01</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Definition</h2>
                </div>
                <div class="space-y-3 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p><strong class="text-charcoal-500">"Platforms"</strong>refers to the BagiResep website located at Bagiresep.fun and all related services.</p>
                    <p><strong class="text-charcoal-500">"User"</strong>refers to every individual who accesses or uses the Platform, whether registered or not.</p>
                    <p><strong class="text-charcoal-500">"Content"</strong>refers to recipes, photos, text, comments, ratings and other materials that Users upload to the Platform.</p>
                    <p><strong class="text-charcoal-500">"We"</strong>refers to the BagiResep manager.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">02</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">User Account</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>You are responsible for maintaining the confidentiality of your account credentials. All activities that occur under your account are your responsibility.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>Each individual is only allowed to have one account. Duplicate accounts, fake accounts, or impersonation are prohibited.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>You must be at least 13 years old to register for an account at BagiResep.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">03</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">User Content</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>By uploading Content to the Platform, you represent and warrant that:</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>The content is either your original creation or you have legal permission to share it.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>The uploaded photos are your own shots, not downloaded from the internet without permission.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mt-2 flex-shrink-0"></span>
                            <p>The content does not violate any other party's intellectual property rights.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">04</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Prohibited Content</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>The following content is strictly prohibited on the Platform:</p>
                    <div class="bg-red-50/70 rounded-2xl p-5 border border-red-100 space-y-3 text-red-700">
                        <p class="font-semibold text-sm mb-2">Violations may result in content removal, suspension, or permanent account deletion:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Pornography or sexually explicit content</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Hate speech or discrimination</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Violence or threats</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Illegal content under Indonesian law</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Spam or commercial advertising</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Fraud or phishing</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Malware or malicious code</p>
                            <p class="flex items-start gap-2"><span class="text-red-400 mt-0.5">&#x2715;</span>Copyright infringement</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">05</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">User Behavior</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>We expect every User to:</p>
                    <div class="space-y-3">
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span>Interact politely and respectfully with fellow community members</p>
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span>Provide ratings and reviews based on real experience</p>
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span>Use polite language in comments and reviews</p>
                        <p class="flex items-start gap-3"><span class="text-green-500 mt-0.5">&#x2713;</span>Report infringing content via contact channels</p>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">06</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Intellectual Property Rights</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>You retain copyright in the Content you create. By uploading Content, you grant BagiResep a non-exclusive, royalty-free, and global license to display and distribute that Content on the Platform. This license terminates when you remove Content from the Platform.</p>
                    <p>The name "bagiresep", logo, interface design and source code are the intellectual property of the Platform manager and are protected by law.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">07</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Limitation of Liability</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>The Platform is provided “as is” without warranty of any kind. We are not responsible for:</p>
                    <div class="space-y-2">
                        <p>- Cooking results that do not match expectations based on the recipe</p>
                        <p>- Disruption of service or system maintenance</p>
                        <p>- Content uploaded by other Users</p>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">08</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Enforcement</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>We reserve the right, at our sole discretion, to:</p>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="bg-yellow-50/70 rounded-xl p-4 border border-yellow-100 flex items-start gap-3">
                            <span class="text-yellow-600 font-bold">I</span>
                            <p class="text-sm">Delete content that violates the terms</p>
                        </div>
                        <div class="bg-orange-50/70 rounded-xl p-4 border border-orange-100 flex items-start gap-3">
                            <span class="text-orange-600 font-bold">II</span>
                            <p class="text-sm">Suspend accounts for repeat violations</p>
                        </div>
                        <div class="bg-red-50/70 rounded-xl p-4 border border-red-100 flex items-start gap-3">
                            <span class="text-red-600 font-bold">III</span>
                            <p class="text-sm">Permanently delete accounts for serious violations</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">09</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Applicable law</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>These terms are regulated by the laws of the Republic of Indonesia. Every dispute will be resolved by deliberation first, and if no agreement is reached, through the competent courts in Indonesia.</p>
                </div>
            </section>

            <section>
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-amber-500 font-display text-3xl font-bold leading-none">10</span>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">Contact</h2>
                </div>
                <div class="space-y-4 text-gray-500 leading-relaxed ml-0 sm:ml-12">
                    <p>For questions, violation reports, or appeal requests:</p>
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

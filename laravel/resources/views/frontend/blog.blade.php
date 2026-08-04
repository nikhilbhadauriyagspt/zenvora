@extends('layouts.app')

@section('title', 'Compliance Blog & Insights | Zenvora Global Solutions')
@section('meta_description', 'Explore legal breakdowns, tax guides, GST rules, and trademark filing briefings written by the CAs and legal advisors of Zenvora.')

@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative py-28 bg-slate-50 border-b border-slate-100 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-newspaper text-[10px]"></i> Zenvora Briefings
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                Corporate Compliance <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Insights & Guides.</span>
            </h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                Legal breakdowns, tax advisories, and administrative frameworks written directly by our panel of Chartered Accountants and corporate attorneys.
            </p>
        </div>
    </section>

    <!-- Main Blog Section -->
    <section class="py-24 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-16">
                <button class="blog-filter-btn active text-xs font-black uppercase tracking-wider py-2.5 px-6 rounded-full border border-brand-500 bg-brand-500/10 text-brand-700 transition-all font-bold" data-category="all">
                    All Articles
                </button>
                <button class="blog-filter-btn text-xs font-black uppercase tracking-wider py-2.5 px-6 rounded-full border border-slate-200 text-slate-650 hover:bg-slate-50 transition-all font-bold" data-category="business-startup">
                    Business Setup
                </button>
                <button class="blog-filter-btn text-xs font-black uppercase tracking-wider py-2.5 px-6 rounded-full border border-slate-200 text-slate-650 hover:bg-slate-50 transition-all font-bold" data-category="tax">
                    Tax & GST
                </button>
                <button class="blog-filter-btn text-xs font-black uppercase tracking-wider py-2.5 px-6 rounded-full border border-slate-200 text-slate-650 hover:bg-slate-50 transition-all font-bold" data-category="intellectual-property">
                    Intellectual Property
                </button>
            </div>

            <!-- Blog Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch" id="blog-grid">
                @forelse ($blogs as $blog)
                    <div class="blog-card bg-white border border-slate-200 rounded-3xl p-5 hover:border-brand-500 transition-all duration-300 flex flex-col justify-between" 
                         data-category="{{ $blog->category_slug }}">
                        
                        <div>
                            <!-- Image cover -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden mb-5 border border-slate-100">
                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                            </div>

                            <!-- Meta tags -->
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-block text-[9px] font-black text-brand-700 bg-brand-500/10 border border-brand-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                    {{ $blog->category }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-bold">{{ $blog->read_time }}</span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-base font-extrabold text-slate-900 leading-snug hover:text-brand-500 transition-colors">
                                <a href="{{ route('blog.detail', $blog->id) }}">
                                    {{ $blog->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-xs text-slate-500 mt-3.5 leading-relaxed font-semibold">
                                {{ $blog->excerpt }}
                            </p>
                        </div>

                        <!-- Author Block -->
                        <div class="mt-8 pt-5 border-t border-slate-150 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2.5">
                                <img src="{{ asset($blog->author_avatar) }}" alt="{{ $blog->author }}" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                <div>
                                    <span class="text-[10px] font-extrabold text-slate-900 block leading-none">{{ $blog->author }}</span>
                                    <span class="text-[9px] text-slate-400 font-bold block mt-0.5">{{ $blog->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('blog.detail', $blog->id) }}" class="text-[10px] font-black uppercase tracking-wider text-brand-600 flex items-center gap-1 hover:text-brand-500 transition-colors font-bold">
                                Read Post <i class="fa-solid fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-12 text-slate-500">
                        No articles published yet. Check back soon!
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-slate-50 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Have a corporate compliance issue?</h2>
            <p class="text-slate-500 text-sm max-w-xl mx-auto font-semibold">
                Speak directly to Priyanka Sharma or Tushar Sudheesh regarding your specific legal structure or tax filings.
            </p>
            <div class="pt-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-xs font-bold text-white accent-gradient hover:opacity-95 transition-all">
                    <i class="fa-solid fa-calendar-check mr-2"></i> Book Free Consultation Call
                </a>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.blog-filter-btn');
        const blogCards = document.querySelectorAll('.blog-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.className = 'blog-filter-btn text-xs font-black uppercase tracking-wider py-2.5 px-6 rounded-full border border-slate-200 text-slate-650 hover:bg-slate-50 transition-all font-bold';
                });

                btn.className = 'blog-filter-btn active text-xs font-black uppercase tracking-wider py-2.5 px-6 rounded-full border border-brand-500 bg-brand-500/10 text-brand-700 transition-all font-bold';

                const category = btn.getAttribute('data-category');

                blogCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    if (category === 'all' || cardCategory === category) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endsection

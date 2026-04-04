@extends('app')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent py-6 px-12 flex justify-between items-center">
        <div class="text-2xl font-['Noto_Serif'] font-bold tracking-tighter">LUXEESTATE</div>
        <div class="hidden md:flex space-x-8 text-sm uppercase tracking-widest font-medium">
            <a href="#" class="hover:text-gold transition-colors">Collections</a>
            <a href="#" class="hover:text-gold transition-colors">Virtual Tours</a>
            <a href="#" class="hover:text-gold transition-colors">About</a>
            <a href="#" class="hover:text-gold transition-colors">Contact</a>
        </div>
        <button class="bg-primary text-white px-8 py-3 text-xs uppercase tracking-widest font-bold transition-all hover:bg-gold">List a Property</button>
    </nav>

    <!-- Hero -->
    <section class="relative h-screen flex items-center px-12 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1600585154340-be6199f7d009" alt="Modern Villa" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-charcoal/20"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl">
            <h1 class="text-8xl font-['Noto_Serif'] text-white leading-none mb-8 -ml-1">Reshape Your<br>Reality</h1>
            <div class="bg-white/90 backdrop-blur-md p-2 flex items-center w-full max-w-2xl mt-12">
                <input type="text" placeholder="Location" class="flex-1 bg-transparent border-none focus:ring-0 px-6 py-4 text-sm">
                <div class="h-8 w-px bg-charcoal/10"></div>
                <select class="flex-1 bg-transparent border-none focus:ring-0 px-6 py-4 text-sm">
                    <option>Property Type</option>
                    <option>Villa</option>
                    <option>Penthouse</option>
                </select>
                <button class="bg-charcoal text-white px-10 py-4 text-xs uppercase tracking-widest font-bold">Search</button>
            </div>
        </div>
    </section>

    <!-- Featured -->
    <section class="py-32 px-12">
        <div class="flex justify-between items-end mb-16">
            <h2 class="text-4xl font-['Noto_Serif']">Featured Collection</h2>
            <a href="#" class="text-xs uppercase tracking-widest font-bold border-b border-gold pb-1">View All Properties</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Property 1 -->
            <div class="group cursor-pointer">
                <div class="aspect-[4/5] overflow-hidden mb-6">
                    <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811" alt="The Obsidian Sanctuary" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-['Noto_Serif'] mb-1">The Obsidian Sanctuary</h3>
                        <p class="text-sm text-charcoal/60">Beverly Hills, CA</p>
                    </div>
                    <div class="text-lg font-['Noto_Serif'] font-bold">$24,500,000</div>
                </div>
            </div>
            <!-- Property 2 -->
            <div class="group cursor-pointer mt-24">
                <div class="aspect-[4/5] overflow-hidden mb-6">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750" alt="The Zenith Penthouse" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-['Noto_Serif'] mb-1">The Zenith Penthouse</h3>
                        <p class="text-sm text-charcoal/60">New York, NY</p>
                    </div>
                    <div class="text-lg font-['Noto_Serif'] font-bold">$18,200,000</div>
                </div>
            </div>
            <!-- Property 3 -->
            <div class="group cursor-pointer">
                <div class="aspect-[4/5] overflow-hidden mb-6">
                    <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d" alt="Marquina Villa" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-['Noto_Serif'] mb-1">Marquina Villa</h3>
                        <p class="text-sm text-charcoal/60">Bel Air, CA</p>
                    </div>
                    <div class="text-lg font-['Noto_Serif'] font-bold">$15,750,000</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="bg-charcoal text-white py-32 px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-24">
            <div>
                <span class="material-symbols-outlined text-gold text-4xl mb-6">auto_awesome</span>
                <h4 class="text-xl font-['Noto_Serif'] mb-4">Curated Listings</h4>
                <p class="text-sm text-white/60 leading-relaxed">Only the most architecturally significant properties make it into our private collection.</p>
            </div>
            <div>
                <span class="material-symbols-outlined text-gold text-4xl mb-6">vr_pano</span>
                <h4 class="text-xl font-['Noto_Serif'] mb-4">Virtual Reality Tours</h4>
                <p class="text-sm text-white/60 leading-relaxed">Experience every corner of your future home from anywhere in the world with 8K clarity.</p>
            </div>
            <div>
                <span class="material-symbols-outlined text-gold text-4xl mb-6">concierge</span>
                <h4 class="text-xl font-['Noto_Serif'] mb-4">Bespoke Concierge</h4>
                <p class="text-sm text-white/60 leading-relaxed">From private jet transfers to interior design consultations, we handle every detail.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-off-white py-24 px-12 border-t border-charcoal/5">
        <div class="flex flex-col md:flex-row justify-between items-start gap-12">
            <div class="text-2xl font-['Noto_Serif'] font-bold">LUXEESTATE</div>
            <div class="flex flex-wrap gap-12">
                <div class="flex flex-col space-y-4">
                    <span class="text-xs uppercase tracking-widest font-bold">Browse</span>
                    <a href="#" class="text-sm hover:text-gold">Penthouses</a>
                    <a href="#" class="text-sm hover:text-gold">Villas</a>
                    <a href="#" class="text-sm hover:text-gold">Mansions</a>
                </div>
                <div class="flex flex-col space-y-4">
                    <span class="text-xs uppercase tracking-widest font-bold">Company</span>
                    <a href="#" class="text-sm hover:text-gold">About Us</a>
                    <a href="#" class="text-sm hover:text-gold">Journal</a>
                    <a href="#" class="text-sm hover:text-gold">Contact</a>
                </div>
            </div>
            <div class="max-w-xs w-full">
                <span class="text-xs uppercase tracking-widest font-bold mb-4 block">Newsletter</span>
                <div class="flex border-b border-charcoal pb-2">
                    <input type="email" placeholder="Your email address" class="bg-transparent border-none focus:ring-0 text-sm w-full">
                    <button class="text-gold uppercase text-[10px] font-bold">Join</button>
                </div>
            </div>
        </div>
        <div class="mt-24 pt-8 border-t border-charcoal/5 text-[10px] uppercase tracking-widest text-charcoal/40 flex justify-between">
            <span>&copy; 2026 LuxeEstate. All rights reserved.</span>
            <div class="flex space-x-6">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
            </div>
        </div>
    </footer>
</div>
@endsection

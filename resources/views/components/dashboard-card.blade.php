@props([
    'title' => '',
    'value' => '0',
    'type' => 'primary', // 'primary' (navy) or 'secondary' (crimson)
])

<div class="bg-white border border-neutral-divider shadow-sm rounded-none p-6 relative overflow-hidden group">
    <div class="absolute top-0 left-0 w-1 h-full {{ $type === 'primary' ? 'bg-brand-navy' : 'bg-brand-crimson' }}"></div>
    
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-neutral-body uppercase tracking-widest mb-1">
                {{ $title }}
            </p>
            <h3 class="text-3xl font-serif font-bold text-brand-navy">
                {{ $value }}
            </h3>
        </div>
        <div class="p-3 bg-neutral-bg {{ $type === 'primary' ? 'text-brand-navy' : 'text-brand-crimson' }}">
             {{ $slot }} {{-- This is where the icon will go --}}
        </div>
    </div>
</div>
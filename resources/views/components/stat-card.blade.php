<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
    <div class="flex items-center">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl bg-{{ $color }}-50 text-{{ $color }}-600 mr-4 transition-transform group-hover:scale-110">
            <i class="{{ $icon }}"></i>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $title }}</p>
            <p class="text-xl font-black text-slate-800">{{ $value }}</p>
        </div>
    </div>
</div>

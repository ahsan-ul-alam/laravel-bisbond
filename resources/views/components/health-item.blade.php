<div class="p-6 flex items-start group hover:bg-slate-50 transition-colors">
    <div class="mt-1">
        @if($check['status'] === 'ok')
            <div class="w-8 h-8 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-xs">
                <i class="fas fa-check"></i>
            </div>
        @elseif($check['status'] === 'warning')
            <div class="w-8 h-8 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center text-xs">
                <i class="fas fa-exclamation"></i>
            </div>
        @else
            <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center text-xs">
                <i class="fas fa-times"></i>
            </div>
        @endif
    </div>
    <div class="ml-4 flex-1">
        <div class="flex items-center justify-between mb-1">
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ $check['title'] }}</h4>
            @if($check['action_url'])
                <a href="{{ $check['action_url'] }}" class="text-[10px] font-black text-indigo-600 uppercase hover:underline flex items-center">
                    Configure <i class="fas fa-arrow-right ml-1"></i>
                </a>
            @endif
        </div>
        <p class="text-xs text-slate-500 font-bold leading-relaxed">{{ $check['message'] }}</p>
        @if($check['suggestion'])
            <p class="text-[10px] text-slate-400 mt-2 font-bold italic">💡 Tip: {{ $check['suggestion'] }}</p>
        @endif
    </div>
</div>

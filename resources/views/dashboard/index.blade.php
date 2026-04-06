@extends('bisbond::layouts.app')

@section('title', 'System Overview')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                    <i class="fas fa-cubes fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Modules Enabled</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['modules_enabled'] }} / 4</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full {{ $stats['health_status'] === 'Healthy' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} mr-4">
                    <i class="fas fa-heartbeat fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">System Health</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['health_status'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-route fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Routes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['route_count'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-terminal fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Commands</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['command_count'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Health Checks -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Configuration Health Check</h3>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase">Live Status</span>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($healthChecks as $check)
                        <div class="flex items-start p-4 rounded-lg {{ $check['status'] === 'ok' ? 'bg-green-50' : ($check['status'] === 'warning' ? 'bg-yellow-50' : 'bg-red-50') }}">
                            <div class="flex-shrink-0 mt-1">
                                @if($check['status'] === 'ok')
                                    <i class="fas fa-check-circle text-green-500"></i>
                                @elseif($check['status'] === 'warning')
                                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                @else
                                    <i class="fas fa-times-circle text-red-500"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-800">{{ $check['title'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $check['message'] }}</p>
                                @if($check['suggestion'])
                                    <p class="text-xs text-indigo-600 mt-1 font-medium">Suggestion: {{ $check['suggestion'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Module Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($modules as $name => $enabled)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 {{ $enabled ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                <i class="fas fa-{{ $name === 'formatter' ? 'language' : ($name === 'invoice' ? 'file-invoice' : ($name === 'sms' ? 'sms' : 'credit-card')) }}"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 capitalize">{{ $name }}</h4>
                                <p class="text-xs text-gray-500">{{ $enabled ? 'Active & Running' : 'Disabled' }}</p>
                            </div>
                        </div>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $enabled ? 'bg-green-400 opacity-75' : 'bg-gray-400' }}"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 {{ $enabled ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('bisbond.settings.index') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-700">Configure Modules</span>
                        <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-500"></i>
                    </a>
                    <a href="{{ route('bisbond.invoice.preview') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-700">View Sample Invoice</span>
                        <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-500"></i>
                    </a>
                    <a href="{{ route('bisbond.system.routes') }}" class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-700">Explorer Routes</span>
                        <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-500"></i>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="font-bold mb-2">Need Help?</h3>
                <p class="text-indigo-100 text-sm mb-4">Check our documentation for advanced configuration and API usage.</p>
                <a href="#" class="inline-block bg-white text-indigo-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-50 transition">
                    Documentation
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<div>
    @section('title', 'Dashboard')

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Soal</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_questions']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['today_transactions']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-1">Total Paket</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_packages'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-1">Transaksi Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_transactions'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-1">Revenue Hari Ini</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Transactions --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
            </div>
            @if(count($recentTransactions) > 0)
                <div class="divide-y">
                    @foreach($recentTransactions as $tx)
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $tx['user'] }}</p>
                                <p class="text-sm text-gray-500">{{ $tx['package'] }} · {{ $tx['invoice'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">{{ $tx['amount'] }}</p>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    {{ $tx['status'] === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $tx['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $tx['status'] === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ strtoupper($tx['status']) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="p-4 text-center text-gray-500">Belum ada transaksi</p>
            @endif
        </div>

        {{-- Recent Users --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-gray-900">User Terbaru</h3>
            </div>
            @if(count($recentUsers) > 0)
                <div class="divide-y">
                    @foreach($recentUsers as $user)
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $user['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $user['email'] }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs px-2 py-1 rounded-full 
                                    {{ $user['role'] === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ strtoupper($user['role']) }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1">{{ $user['date'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="p-4 text-center text-gray-500">Belum ada user</p>
            @endif
        </div>
    </div>
</div>

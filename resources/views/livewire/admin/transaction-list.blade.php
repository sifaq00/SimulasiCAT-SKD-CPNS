<div>
    @section('title', 'Transaksi')

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Total Transaksi</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Berhasil</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['paid'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="text-xl font-bold text-blue-600">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" wire:model.live.debounce.300ms="search" 
                    placeholder="Nama, email, atau invoice..." 
                    class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" class="w-full rounded-lg border-gray-300">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="expired">Expired</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" wire:model.live="dateFrom" class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" wire:model.live="dateTo" class="w-full rounded-lg border-gray-300">
            </div>
        </div>
    </div>

    {{-- Table --}}
    {{-- Mobile Card View --}}
    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($transactions as $tx)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-mono text-xs text-gray-500">{{ $tx->invoice_number }}</p>
                        <h3 class="font-bold text-gray-900">{{ $tx->user->name }}</h3>
                        <p class="text-xs text-gray-400">{{ $tx->user->email }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $tx->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $tx->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $tx->status === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $tx->status === 'expired' ? 'bg-gray-100 text-gray-700' : '' }}">
                        {{ strtoupper($tx->status) }}
                    </span>
                </div>

                <div class="border-t border-b border-gray-50 py-2 my-2">
                    <p class="text-sm text-gray-600 mb-1">Item:</p>
                    <p class="font-medium text-gray-900 text-sm">
                         {{ $tx->package?->name ?? $tx->bundle?->name ?? '-' }}
                    </p>
                </div>

                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">{{ $tx->created_at->format('d M Y H:i') }}</span>
                    <span class="font-bold text-blue-600">Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        @empty
             <div class="text-center p-8 text-gray-500 bg-white rounded-xl">
                Tidak ada transaksi ditemukan.
            </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-mono text-sm">{{ $tx->invoice_number }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $tx->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $tx->user->email }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $tx->package?->name ?? $tx->bundle?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium">
                                Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $tx->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $tx->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $tx->status === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $tx->status === 'expired' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ strtoupper($tx->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $tx->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada transaksi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

<x-filament::page>
    <h2 class="text-2xl font-bold mb-6">Welcome, {{ $user->name }} 👑</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Products -->
        <div class="p-6 bg-gradient-to-tr from-blue-100 to-blue-50 border border-blue-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-blue-800 font-semibold">Products</div>
                    <div class="text-3xl font-bold text-blue-900">{{ $productCount }}</div>
                </div>
                <div class="text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="p-6 bg-gradient-to-tr from-green-100 to-green-50 border border-green-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-green-800 font-semibold">Orders</div>
                    <div class="text-3xl font-bold text-green-900">{{ $orderCount }}</div>
                </div>
                <div class="text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M9 13h6m-6 4h6m-8 4h10M5 7h14l-1 14H6L5 7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Brands -->
        <div class="p-6 bg-gradient-to-tr from-purple-100 to-purple-50 border border-purple-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-purple-800 font-semibold">Brands</div>
                    <div class="text-3xl font-bold text-purple-900">{{ $brandCount }}</div>
                </div>
                <div class="text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h2.28a1 1 0 01.95.68L8.5 6H19a1 1 0 011 1v2H6.42l-.94-2.34A1 1 0 004.5 6H4a1 1 0 01-1-1V4zM5 10h14l-1.34 6.68A2 2 0 0115.72 18H8.28a2 2 0 01-1.94-1.32L5 10z" />
                    </svg>
                </div>
            </div>
        </div>

    </div>
</x-filament::page>

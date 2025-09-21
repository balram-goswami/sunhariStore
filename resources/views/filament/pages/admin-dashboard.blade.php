<x-filament::page>
    <h2 class="text-2xl font-bold mb-6">Welcome, {{ $user->name }} 👑</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

        <!-- Users -->
        <div class="p-6 bg-gradient-to-tr from-blue-100 to-blue-50 border border-blue-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-blue-800 font-semibold">All Users</div>
                    <div class="text-3xl font-bold text-blue-900">{{ $userCount }}</div>
                </div>
                <div class="text-blue-600">
                    <x-heroicon-o-users class="h-8 w-8" />
                </div>
            </div>
        </div>

        

        <!-- Products -->
        <div class="p-6 bg-gradient-to-tr from-blue-100 to-blue-50 border border-blue-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-blue-800 font-semibold">All Products</div>
                    <div class="text-3xl font-bold text-blue-900">{{ $productCount }}</div>
                </div>
                <div class="text-blue-600">
                    <x-heroicon-o-cube class="h-8 w-8" />
                </div>
            </div>
        </div>

       

        <!-- Orders -->
        <div class="p-6 bg-gradient-to-tr from-green-100 to-green-50 border border-green-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-green-800 font-semibold">All Orders</div>
                    <div class="text-3xl font-bold text-green-900">{{ $orderCount }}</div>
                </div>
                <div class="text-green-600">
                    <x-heroicon-o-shopping-bag class="h-8 w-8" />
                </div>
            </div>
        </div>

        <!-- Brands -->
        <div class="p-6 bg-gradient-to-tr from-purple-100 to-purple-50 border border-purple-200 shadow-md rounded-2xl hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-purple-800 font-semibold">All Brands</div>
                    <div class="text-3xl font-bold text-purple-900">{{ $brandCount }}</div>
                </div>
                <div class="text-purple-600">
                    <x-heroicon-o-tag class="h-8 w-8" />
                </div>
            </div>
        </div>

    </div>
</x-filament::page>

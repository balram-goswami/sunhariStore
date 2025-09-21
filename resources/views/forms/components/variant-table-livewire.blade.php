
<div class="overflow-x-auto">
    <table class="w-full border border-gray-200 rounded-lg">
        <thead class="bg-gray-100">
            <tr class="border-b border-gray-200">
                <th class="px-2 py-2 text-xs text-left">Label</th>
                <th class="px-2 py-2 text-xs text-left" width="100px">SKU</th>
                <th class="px-2 py-2 text-xs text-left" width="100px">Regular Price</th>
                <th class="px-2 py-2 text-xs text-left" width="100px">Sale Price</th>
                <th class="px-2 py-2 text-xs text-left" width="60px">Stock</th>
                <th class="px-2 py-2 text-xs text-left" width="60px">Status</th>
                <th class="px-2 py-2 text-xs text-left" width="60px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(count($variations) > 0)
                @foreach($variations as $index => $variation)
                    @if($variation['is_deleted'])
                        @continue
                    @endif
                    <tr class="border-b border-gray-200"
                    style="{{ $variation['is_outdated'] ? 'background-color: #e57b7b;' : '' }}">
                        <td class="px-2 py-2">
                            <span class="text-sm text-black rounded border border-blue-300" style="padding:2px 5px;">{{ $variation['label'] ?? 'N/A' }}</span>
                        </td>
                        <td class="px-2 py-2">
                            <input wire:change="updateVariation({{ $index }}, 'sku', $event.target.value)" wire:model="data.variations.product_variations.{{ $index }}.sku" type="text" value="{{ $variation['sku'] ?? 'N/A' }}"
                             class="text-sm bg-transparent text-black rounded" style="width: 80px; padding:1px 5px;">
                        </td>
                        <td class="px-2 py-2 ">
                            <input wire:change="updateVariation({{ $index }}, 'price', $event.target.value)" wire:model="data.variations.product_variations.{{ $index }}.price" type="number" value="{{ $variation['price'] ?? 0 }}" step="0.01"
                             class="text-sm bg-transparent text-black rounded" style="width: 80px; padding:1px 5px;">
                        </td>
                        <td class="px-2 py-2 ">
                            <input wire:change="updateVariation({{ $index }}, 'sale_price', $event.target.value)" wire:model="data.variations.product_variations.{{ $index }}.sale_price" type="number" value="{{ $variation['sale_price'] ?? 0 }}" step="0.01"
                             class="text-sm bg-transparent text-black rounded" style="width: 80px; padding:1px 5px;">
                        </td>
                        <td class="px-2 py-2 ">
                            <input wire:change="updateVariation({{ $index }}, 'stock', $event.target.value)" wire:model="data.variations.product_variations.{{ $index }}.stock" type="number" value="{{ $variation['stock'] ?? 0 }}" step="1"
                             class="text-sm bg-transparent text-black rounded" style="width: 60px; padding:1px 5px;">   
                        </td>
                        <td class="px-2 py-2 ">
                            <label for="is_available" class="flex items-center text-sm gap-2">
                                <input wire:change="updateVariation({{ $index }}, 'is_available', $event.target.value)" wire:model="data.variations.product_variations.{{ $index }}.is_available" type="checkbox" value="{{ $variation['is_available'] ?? false }}"
                                 class="text-sm bg-transparent text-black rounded">
                                 Enable
                            </label>
                        </td>
                        <td class="px-2 py-2 ">
                            <button type="button" 
                                    wire:click="removeVariant({{ $index }})"
                                    class="text-white rounded text-xs" style="background-color: #d70000;padding:2px 5px;">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="px-4 text-center text-gray-500" style="padding:5px 10px;font-size:1em;">
                        No variations found. Click "Generate Variants" or select attributes to create product variations.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


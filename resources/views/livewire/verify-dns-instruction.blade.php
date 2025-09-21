@if ($record)
    <div class="text-sm space-y-2">
        <p><strong>To verify ownership of <code>{{ $record->domain }}</code>, add the following DNS record:</strong></p>

        <table class="table-auto w-full border border-gray-200 text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 border">Type</th>
                    <th class="px-4 py-2 border">Host</th>
                    <th class="px-4 py-2 border">Points To</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white">
                    <td class="px-4 py-2 border">CNAME</td>
                    <td class="px-4 py-2 border"><code>verify.{{ $record->domain }}</code></td>
                    <td class="px-4 py-2 border"><code>verify.yourapp.com</code></td>
                </tr>
            </tbody>
        </table>

        <p class="text-yellow-700 font-semibold">⚠️ After updating DNS, click <strong>Verify Domain</strong> to complete
            setup.</p>
    </div>
@endif

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class GoogleSheetExportController extends Controller
{
    public function export()
    {
        try {
            // 1. Initialize Google Client
            $client = new Client();
            $client->setAuthConfig(storage_path('app/google-credentials.json'));
            $client->addScope(Sheets::SPREADSHEETS);

            $service = new Sheets($client);
            $spreadsheetId = env('GOOGLE_SHEET_ID');

            if (!$spreadsheetId) {
                return response()->json(['error' => 'GOOGLE_SHEET_ID not set in .env'], 500);
            }

            // 2. Fetch products
            $products = Product::select('id', 'name', 'description', 'price', 'sale_price', 'slug', 'image')->get();

            if ($products->isEmpty()) {
                return response()->json(['message' => 'No products found to export'], 404);
            }

            // 3. Sheet header
            $values = [[
                'id', 'title', 'description', 'availability', 'condition',
                'price', 'link', 'image_link', 'brand', 'google_product_category'
            ]];

            // 4. Prepare rows
            foreach ($products as $product) {
                // Decide price: sale_price if available, else normal price
                $finalPrice = $product->sale_price ?? $product->price;

                // Handle image (JSON or string)
                $image = '';
                if (!empty($product->image)) {
                    if (is_string($product->image)) {
                        $decoded = json_decode($product->image, true);
                        $image = is_array($decoded) && count($decoded) > 0
                            ? asset('storage/' . $decoded[0])
                            : asset('storage/' . $product->image);
                    } elseif (is_array($product->image) && count($product->image) > 0) {
                        $image = asset('storage/' . $product->image[0]);
                    }
                }

                $values[] = [
                    $product->id,
                    $product->name ?? 'Untitled',
                    strip_tags($product->description ?? ''),
                    'in stock',
                    'new',
                    number_format($finalPrice, 2) . ' INR',
                    route('product', $product->slug),
                    $image,
                    'sunhari', // Brand fixed
                    'Apparel & Accessories > Clothing',
                ];
            }

            // 5. Clear old sheet data
            $service->spreadsheets_values->clear(
                $spreadsheetId,
                'Sheet1!A:Z',
                new Sheets\ClearValuesRequest()
            );

            // 6. Write new data
            $body = new Sheets\ValueRange(['values' => $values]);
            $service->spreadsheets_values->update(
                $spreadsheetId,
                'Sheet1!A1',
                $body,
                ['valueInputOption' => 'RAW']
            );

            return response()->json([
                'message' => '✅ Products exported successfully!',
                'rows' => count($values) - 1
            ]);
        } catch (\Exception $e) {
            Log::error('Google Sheet Export Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Export failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}

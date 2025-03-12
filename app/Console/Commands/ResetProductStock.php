<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ResetProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:reset-stock {product_id} {quantity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Увеличивает запасы товара на указанное количество';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productId = $this->argument('product_id');
        $quantity = $this->argument('quantity');

        $product = Product::find($productId);
        if (!$product) {
            $this->error('Товар не найден.');
            return;
        }

        $product->stock += $quantity;
        $product->save();

        $this->info("Запасы товара {$product->name} увеличены на {$quantity}. Текущий запас: {$product->stock}");
    }
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property string $delivery_address
 * @property float $delivery_price
 * @property float $item_price
 * @property string $notes
 * @property string|null $description
 * @property string $status
 * @property int $seller_id
 * @property int|null $delivery_man_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property DeliveryMan|null $delivery_man
 * @property Seller $seller
 * @property Collection|Delivery[] $deliveries
 * @property Collection|OrderItem[] $order_items
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'delivery_price' => 'float',
		'item_price' => 'float',
		'seller_id' => 'int',
		'delivery_man_id' => 'int'
	];

	protected $fillable = [
		'delivery_address',
		'delivery_price',
		'item_price',
		'notes',
		'description',
		'status',
		'seller_id',
		'delivery_man_id'
	];

	public function delivery_man()
	{
		return $this->belongsTo(DeliveryMan::class);
	}

	public function seller()
	{
		return $this->belongsTo(Seller::class);
	}

	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class);
	}
}

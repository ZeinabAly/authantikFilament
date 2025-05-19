<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\{OrderItem, Transaction, Address, Employee, User};

class Order extends Model
{
    use softDeletes;

    protected $guarded = ['id'];

    // Les constantes pour passer les cmd passée au status livré
    const DELIVERY_SITE = 'Sur place';
    const STATUS_DELIVERED = 'Livrée';

    protected function casts(): array
    {
        return [
            'total' => 'double',
            'subtotal' => 'double',
        ];
    }

    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%")
            ->orWhere('lieu', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('total', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%");
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    
    protected static function boot()
    {
        parent::boot();
        
        // Exécuter cette mise à jour au démarrage du modèle
        static::updateExpiredOrdersAndGetQuery();
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->nocmd = self::noCMD();
        });
    }


    // Pour connaitre le nombre de commande par an 
    private static function noCMD()
    {
        // Préfixe constant
        $prefix = 'CMD';

        // Compteur global : compte toutes les commandes créées depuis le début

        $count = self::count() + 1;

        // Format du compteur avec 5 zéros
        $valuePart = str_pad($count, 5, '0', STR_PAD_LEFT);


        foreach(Order::query()->withTrashed()->get() as $order){
            if("{$prefix}{$valuePart}" === $order->nocmd){
                $count++ ;
                $valuePart = str_pad($count, 5, '0', STR_PAD_LEFT);
            }
        }


        return "{$prefix}{$valuePart}";
    }

    public static function updateExpiredOrdersAndGetQuery()
    {
        // D'abord, mettre à jour toutes les commandes sur place expirées
        self::where('lieu', self::DELIVERY_SITE)
            ->where('status', '!=', self::STATUS_DELIVERED)
            ->where(function($query) {
                $query->where('delivred_date', '<', Carbon::today()->toDateString())
                    ->orWhere('created_at', '<', Carbon::today()->toDateString());
            })
            ->update([
                'status' => self::STATUS_DELIVERED,
                'delivred_date' => DB::raw('DATE_ADD(`created_at`, INTERVAL 3 HOUR)')  // Notez l'utilisation de DB::raw ici
        ]);
                
        // Ensuite retourner une nouvelle requête pour chaîner d'autres opérations
        return self::query();
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'nocmd';
    }

}


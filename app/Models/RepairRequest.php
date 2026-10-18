<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RepairStatus;

class RepairRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'tradesman_id',
        'title',
        'description',
        'location',
        'status',
        'image',
        'admin_notes',
    ];

    protected $casts = [
        'status' => RepairStatus::class,
    ];

    // Accessor สำหรับ backwards compatibility
    public function getImagePathAttribute()
    {
        return $this->image;
    }

    // ผู้แจ้งซ่อม
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // หมวดหมู่งานซ่อม
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ช่างผู้รับผิดชอบ
    public function tradesman()
    {
        return $this->belongsTo(User::class, 'tradesman_id');
    }
}
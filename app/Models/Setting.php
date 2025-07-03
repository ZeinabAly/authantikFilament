<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use softDeletes;
    protected $guarded = ['id']; 

    protected $casts = [
        'opening_hours' => 'array',
        'is_active' => 'boolean',
        'facebookVideos' => 'array'
    ];

    /**
     * Get the singleton instance of restaurant settings
     */
    public static function getInstance()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'AUTHANTIK',
                'primary_color' => '#025239',
                'secondary_color' => '#ce9c2d',
                'accent_color' => '#effbf7'
            ]
        );
    }

    /**
     * Get the logo URL
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? Storage::url($this->logo_path) : null;
    }

    /**
     * Get the menu PDF URL
     */
    public function getMenuPdfUrlAttribute()
    {
        return $this->menu_pdf_path ? Storage::url($this->menu_pdf_path) : null;
    }

    /**
     * Delete old file when updating
     */
    public function updateFile($field, $newPath)
    {
        if ($this->{$field} && Storage::exists($this->{$field})) {
            Storage::delete($this->{$field});
        }
        $this->{$field} = $newPath;
    }
}

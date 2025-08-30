<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdSeeder extends Seeder
{
    /**
     * Seed random custom ads for testing across standard placements.
     */
    public function run(): void
    {
        // Standard placements to cover in the UI
        $placements = array_keys(Ad::PLACEMENTS);

        // Simple demo HTML banners (custom ads). Using inline styles to avoid external assets.
        $colors = ['#2563eb', '#dc2626', '#16a34a', '#7c3aed', '#0ea5e9', '#ef4444'];
        $texts = [
            'Your Ad Here',
            'Sponsored • Homeland',
            'Try Premium Today',
            'Advertise with Us',
            'Limited Offer',
            'Learn More',
        ];

        foreach ($placements as $i => $placement) {
            $bg = $colors[$i % count($colors)];
            $label = $texts[$i % count($texts)];
            $width = '100%';
            $height = in_array($placement, ['sidebar','footer','header']) ? '90px' : '120px';

            // Build simple custom HTML block
            $html = sprintf(
                '<div style="width:%s;height:%s;display:flex;align-items:center;justify-content:center;border-radius:8px;background:%s;color:#fff;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
                    <div style="text-align:center">
                        <div style="font-weight:700;letter-spacing:0.02em">%s</div>
                        <div style="font-size:12px;opacity:.85">Placement: %s</div>
                    </div>
                 </div>',
                $width,
                $height,
                $bg,
                e($label),
                e($placement)
            );

            Ad::updateOrCreate(
                ['placement' => $placement, 'type' => 'custom'],
                [
                    'name' => Str::title(str_replace('-', ' ', $placement)) . ' Test Ad',
                    'slot_id' => '', // not used for custom
                    'is_active' => true,
                    // Casted to array or string is supported by view partial; store plain string
                    'custom_code' => $html,
                ]
            );
        }

        // Optionally add a couple of random duplicate ads per placement to test selection/rotation later
        // Keeping minimal: we only ensure at least one active ad per standard placement.
    }
}

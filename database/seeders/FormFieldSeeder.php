<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormField;

class FormFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormField::updateOrCreate(
            ['name' => 'name'],
            ['label' => 'Company Name', 'type' => 'text', 'order' => 10, 'is_active' => true]
        );

        FormField::updateOrCreate(
            ['name' => 'elevator_pitch'],
            ['label' => 'Elevator Pitch (30-second summary)', 'type' => 'textarea', 'order' => 20, 'is_active' => true]
        );

        FormField::updateOrCreate(
            ['name' => 'mission_vision'],
            ['label' => 'Mission & Vision', 'type' => 'textarea', 'order' => 30, 'is_active' => true]
        );
        
        FormField::updateOrCreate(
            ['name' => 'products_services'],
            ['label' => 'Core Products & Services', 'type' => 'textarea', 'order' => 40, 'is_active' => true]
        );

        FormField::updateOrCreate(
            ['name' => 'target_audience'],
            ['label' => 'Ideal Customer Profile (ICP)', 'type' => 'textarea', 'order' => 50, 'is_active' => true]
        );
        
        FormField::updateOrCreate(
            ['name' => 'value_proposition'],
            ['label' => 'Unique Value Proposition (UVP)', 'type' => 'textarea', 'order' => 60, 'is_active' => true]
        );

        FormField::updateOrCreate(
            ['name' => 'communication_tone'],
            [
                'label' => 'Communication Tone',
                'type' => 'select',
                'options' => ['Formal', 'Friendly', 'Technical', 'Inspirational'],
                'order' => 70,
                'is_active' => true
            ]
        );
    }
}

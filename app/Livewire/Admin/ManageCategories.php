<?php

namespace App\Livewire\Admin;

use App\Models\DocumentCategory;
use Livewire\Component;

class ManageCategories extends Component
{
    public $categories;
    public DocumentCategory $category;

    // Propiedades para el formulario
    public $name = '';
    public $description = '';
    public $color = '#FFFFFF'; // Valor por defecto para el color

    public $confirmingCategoryDeletion = false;
    public $managingCategory = false;

    // Reglas de validación
    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'nullable|string',
        'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/', // Valida que sea un color hexadecimal
    ];

    public function mount()
    {
        $this->loadCategories();
        $this->category = new DocumentCategory();
    }

    public function loadCategories()
    {
        $this->categories = DocumentCategory::orderBy('name')->get();
    }
    
    public function manageCategory(DocumentCategory $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->color = $category->color ?? '#FFFFFF'; // Asigna el color o uno por defecto
        $this->managingCategory = true;
    }

    public function addCategory()
    {
        $this->category = new DocumentCategory();
        $this->name = '';
        $this->description = '';
        $this->color = '#FFFFFF'; // Color por defecto para nuevas categorías
        $this->managingCategory = true;
    }

    public function saveCategory()
    {
        $this->validate();

        $this->category->name = $this->name;
        $this->category->description = $this->description;
        $this->category->color = $this->color; // Guardamos el color
        $this->category->save();

        $this->managingCategory = false;
        $this->loadCategories();
        $this->dispatch('saved');
    }

    public function confirmCategoryDeletion($categoryId)
    {
        $this->category = DocumentCategory::find($categoryId);
        $this->confirmingCategoryDeletion = true;
    }

    public function deleteCategory()
    {
        $this->category->delete();
        $this->confirmingCategoryDeletion = false;
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.admin.manage-categories')
            ->layout('layouts.app');
    }
}
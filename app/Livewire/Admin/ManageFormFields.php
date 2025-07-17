<?php

namespace App\Livewire\Admin;

use App\Models\FormField;
use Livewire\Component;

class ManageFormFields extends Component
{
    public $fields;
    public $showModal = false;

    // We use a simple array to hold the form's state. This is more reliable in Livewire.
    public $state = [];
    public ?int $editingId = null;

    // The validation rules now target the 'state' array.
    protected function rules()
    {
        return [
            'state.name' => 'required|string|regex:/^[a-z_]+$/|max:255',
            'state.label' => 'required|string|max:255',
            'state.type' => 'required|in:text,textarea,select',
            'state.options' => 'nullable|string', // The textarea for options will be a string.
            'state.order' => 'required|integer',
            'state.is_active' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->loadFields();
    }

    public function loadFields()
    {
        $this->fields = FormField::orderBy('order')->get();
    }

    public function newField()
    {
        $this->reset('state', 'editingId'); // Reset everything for a clean form.
        $this->state['is_active'] = true;
        $this->state['order'] = ($this->fields->max('order') ?? 0) + 1;
        $this->state['type'] = 'text'; // Set a default type.
        $this->showModal = true;
    }

    public function edit($fieldId)
    {
        $this->editingId = $fieldId;
        $field = FormField::find($fieldId);
        
        // Populate the state array from the model's data.
        $this->state = $field->toArray();
        // Convert the options array back to a newline-separated string for the textarea.
        $this->state['options'] = is_array($field->options) ? implode("\n", $field->options) : '';
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $dataToSave = $this->state;

        // Convert the options string from the textarea back to an array before saving.
        if ($dataToSave['type'] === 'select') {
            $dataToSave['options'] = array_filter(preg_split('/\r\n|\r|\n/', $dataToSave['options'] ?? ''));
        } else {
            $dataToSave['options'] = null;
        }

        if ($this->editingId) {
            // Find and update the existing field.
            $field = FormField::find($this->editingId);
            $field->update($dataToSave);
        } else {
            // Create a new field.
            FormField::create($dataToSave);
        }

        $this->showModal = false;
        $this->loadFields();
        $this->dispatch('show-toast', message: 'Field saved successfully.', type: 'success');
    }

    // --- Deletion logic remains the same ---
    public $confirmingFieldDeletion = false;
    public ?int $fieldIdToDelete = null;

    public function confirmFieldDeletion($id)
    {
        $this->fieldIdToDelete = $id;
        $this->confirmingFieldDeletion = true;
    }

    public function deleteField()
    {
        FormField::find($this->fieldIdToDelete)->delete();
        $this->confirmingFieldDeletion = false;
        $this->loadFields();
        $this->dispatch('show-toast', message: 'Field deleted successfully.', type: 'info');
    }

    public function render()
    {
        return view('livewire.admin.manage-form-fields')->layout('layouts.app');
    }
}

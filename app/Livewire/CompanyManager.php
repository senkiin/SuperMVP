<?php

namespace App\Livewire;

use App\Models\UserCompany;
use App\Models\FormField;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompanyManager extends Component
{
    public $companies;
    public ?UserCompany $editing = null;
    public $showModal = false;
    public $formFields;
    public $state = [];

    // --- Properties for Deletion ---
    public $confirmingCompanyDeletion = false;
    public ?int $companyIdToDelete = null;

    public function mount()
    {
        $this->loadCompanies();
        $this->formFields = FormField::where('is_active', true)->orderBy('order')->get();
    }

    public function loadCompanies()
    {
        $this->companies = Auth::user()->userCompanies()->get();
    }

    public function newCompany()
    {
        $this->editing = new UserCompany();
        $this->state = [];
        $this->showModal = true;
    }

    public function edit($companyId)
    {
        $this->editing = UserCompany::find($companyId);
        $this->state = $this->editing->manual_data ?? [];
        $this->showModal = true;
    }

    public function save()
    {
        $this->editing->user_id = Auth::id();
        $this->editing->name = $this->state['name'] ?? 'New Company';
        $this->editing->manual_data = $this->state;
        $this->editing->save();

        $this->loadCompanies();
        $this->showModal = false;
        $this->dispatch('show-toast', message: 'Company data saved successfully.', type: 'success');
    }

    // --- New Methods for Deletion ---

    /**
     * Sets the company ID to be deleted and shows the confirmation modal.
     */
    public function confirmCompanyDeletion($companyId)
    {
        $this->companyIdToDelete = $companyId;
        $this->confirmingCompanyDeletion = true;
    }

    /**
     * Deletes the company after confirmation.
     */
    public function deleteCompany()
    {
        // Ensure the user owns the company before deleting
        $company = Auth::user()->userCompanies()->where('id', $this->companyIdToDelete)->first();

        if ($company) {
            // You might want to add logic here to delete associated documents from storage
            // foreach ($company->documents as $document) {
            //     Storage::disk('private')->delete($document->storage_path);
            // }
            $company->delete();
            $this->dispatch('show-toast', message: 'Company deleted successfully.', type: 'info');
        } else {
            $this->dispatch('show-toast', message: 'Error: Company not found or you do not have permission to delete it.', type: 'error');
        }

        $this->loadCompanies();
        $this->confirmingCompanyDeletion = false;
    }


    public function render()
    {
        return view('livewire.company-manager')->layout('layouts.app');
    }
}

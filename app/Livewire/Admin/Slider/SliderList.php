<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Admin\SearchableComponent;

class SliderList extends SearchableComponent
{

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete',
        'refreshComponent' => '$refresh'
    ];    /**
     * searchableFields
     *
     * @return array
     */
    protected function searchableFields(): array
    {
        return ['link'];
    }
    /**
     * deleteConfirm
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteConfirm($id):void
    {
        $slider = Slider::query()->find($id);
        $this->dispatch('deleteSlider',sliderId: $slider->id);
    }
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id):void
    {
        $slider = Slider::query()->find($id)->delete();
        $this->dispatch('refreshComponent');
    }
    public function baseQuery()
    {
        return Slider::query();
    }

    public function changeStatus($id)
    {
        $slider = Slider::query()->find($id);
        if($slider->status)
            $slider->update(['status' => 0]);
        else
            $slider->update(['status' => 1]);
    }
    public function render()
    {
        return view('livewire.admin.slider.slider-list',['sliders' => $this->results]);
    }
}

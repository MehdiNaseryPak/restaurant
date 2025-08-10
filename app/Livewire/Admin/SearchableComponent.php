<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;

abstract class SearchableComponent extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $perpage = 10;
    public $orderBy = 'DESC';
    abstract protected function baseQuery();

    public function getResultsProperty()
    {

        $query = $this->baseQuery();

        if ($this->search && $fields = $this->searchableFields()) {
            $search = $this->search;

            $query->where(function ($q) use ($fields, $search) {
                foreach ($fields as $field) {
                    $fieldParts = explode('.', $field);
                    if (count($fieldParts) > 1) {
                        if(isset($fieldParts[2]))
                        {
                            $relation = $fieldParts[0].'.'.$fieldParts[1];
                            $relationField = $fieldParts[2];
                        }
                        else
                        {
                            $relation = $fieldParts[0];
                            $relationField = $fieldParts[1];
                        }
                        $q->orWhereHas($relation, function ($relQuery) use ($relationField, $search) {
                            $relQuery->where($relationField, 'like', '%' . $search . '%');
                        });
                    } else {
                        // Field is from the main model
                        $q->orWhere($field, 'like', '%' . $search . '%');
                    }
                }
            });
        }

        $paginated = $query->orderBy('created_at',$this->orderBy)->paginate($this->perpage);
        return $paginated;

    }



    public function updatingSearch()
    {
        $this->resetPage();
    }
}

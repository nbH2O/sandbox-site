<?php

namespace App\Livewire\Item;

use Livewire\Component;
use App\Models\Item\Item;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $query = null;

    public $sort = 'updated';

    public $type = 'all';

    public function updateType($val)
    {
        $this->type = $val;
    }

    public function render()
    {      
        $user = Auth()->user();
        // for some reason doing a uery within the with()
        // just doesnt work for type specifically
        // so it has to be super jank like this i guess
        $sql = Item::with(['creator'])
        ->where('name', 'LIKE', '%'.$this->query.'%')
        ->whereHas('type', function ($q) {
            $q->where('is_public', true)
            ->when(true, function ($query) {
                switch ($this->type) {
                    case 'accessory':
                        $query->where('name', 'hat');
                        break;
                    case 'clothing':
                        $query->where('name', 'shirt')
                            ->orWhere('name', 'pants');
                        break;
                    case 'body':
                        $query->where('name', 'figure')
                            ->orWhere('name', 'head')
                            ->orWhere('name', 'face');
                        break;
                    case 'pack':
                        $query->where('name', 'pack');
                        break;
                    
                    default:
                        # code...
                        break;
                }
            });
        })
        ->when($this->sort, function ($query) {
            switch ($this->sort) {
                case 'updated':
                    $query->orderBy('updated_at', 'DESC');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
                case 'cheapest':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'priciest':
                    $query->orderBy('price', 'DESC');
                    break;
                
                default:
                    # code...
                    break;
            }
        });

        if($user) {
            if ($user->isAdmin()) {
                
            } else {
                $sql->where('is_public', true);
            }
        } else {
            $sql->where('is_public', true);
        }
        $sql = $sql->simplePaginate(16);

        
        return view('livewire.item.search', [
            'items' => $sql
        ]);
    }
}

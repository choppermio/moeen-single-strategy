<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{



    public function moashermkmfs()
    {
        return $this->belongsToMany(Moashermkmf::class);
    }


    public function moasheradastrategies()
    {
        return $this->belongsToMany(Moasheradastrategy::class);
    }

    public function children()
    {
        return $this->hasMany(Todo::class, 'collection_id');
    }

    public function countChildrenWithLevelGreaterThan($level)
    {
        $countDone = 0;
        $countNotDone = 0;

        foreach ($this->children as $child) {
            if ($child->level > $level) {
                if ($child->done === 1) {
                    $countDone++;
                } else {
                    $countNotDone++;
                }

                $counts = $child->countChildrenWithLevelGreaterThan($level);

                $countDone += $counts['countDone'];
                $countNotDone += $counts['countNotDone'];
            }
        }

        $totalTasks = $countDone + $countNotDone;
        $percentageDone = $totalTasks > 0 ? ($countDone / $totalTasks) * 100 : 0;

        return [
            'countDone' => $countDone,
            'countNotDone' => $countNotDone,
            'percentageDone' => $percentageDone,
        ];
    }
}


?>
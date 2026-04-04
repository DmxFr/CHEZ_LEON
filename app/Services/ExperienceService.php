<?php
namespace App\Services;

use App\Models\{User, ExperienceLog};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExperienceService
{
    public function award(User $user, string $eventType, int $points, ?string $description = null, ?Model $source = null, ?User $adjustedBy = null): ExperienceLog {
        return DB::transaction(function () use ($user, $eventType, $points, $description, $source, $adjustedBy) {
            $user->increment('experience_points', $points);
            $user->refresh();

            if ($user->recalculateLevel()) {
                $user->save();
            }

            $log = new ExperienceLog([
                'user_id' => $user->id, 'event_type' => $eventType, 'points_earned' => $points,
                'total_after' => $user->experience_points, 'description' => $description,
                'adjusted_by' => $adjustedBy?->id, 'created_at' => now(),
            ]);

            if ($source) {
                $log->loggable_id = $source->getKey();
                $log->loggable_type = get_class($source);
            }
            $log->save();
            return $log;
        });
    }

    public function adminAdjust(User $user, int $delta, string $reason, User $admin)
    {
        // 🛑 Sécurité : L'XP ne peut pas être inférieur à 0
        $user->experience_points = max(0, $user->experience_points + $delta);
        
        // On force la sauvegarde après avoir calculé le niveau
        $user->recalculateLevel();
        $user->save();

        // Création du log (Historique)
        $user->experienceLogs()->create([
            'event_type' => 'admin_adjustment',
            'points_earned' => $delta,
            'description' => "Ajustement par l'admin : {$reason}"
        ]);
    }
}
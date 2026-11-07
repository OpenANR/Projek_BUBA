<?php

namespace App\Observers;

use App\Events\DataChanged;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Quis;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataChangeObserver
{
    public function saved(Model $model): void
    {
        $entity = $this->entityFor($model);

        if ($entity === null || $this->shouldSkip($model) || $this->isNoiseOnly($model)) {
            return;
        }

        $this->broadcast(
            $model,
            $entity,
            $model->wasRecentlyCreated ? 'created' : 'updated'
        );
    }

    public function deleted(Model $model): void
    {
        $entity = $this->entityFor($model);

        if ($entity === null || $this->shouldSkip($model)) {
            return;
        }

        $this->broadcast($model, $entity, 'deleted');
    }

    private function entityFor(Model $model): ?string
    {
        return match (true) {
            $model instanceof Kelas => 'kelas',
            $model instanceof Kategori => 'kategori',
            $model instanceof Materi => 'materi',
            $model instanceof Quis => 'quis',
            $model instanceof Reward => 'reward',
            $model instanceof User => 'siswa',
            default => null,
        };
    }

    private function shouldSkip(Model $model): bool
    {
        // User guru/admin tidak perlu memicu update halaman siswa.
        return $model instanceof User && $model->role !== 'siswa';
    }

    private function isNoiseOnly(Model $model): bool
    {
        if (! $model instanceof User || $model->wasRecentlyCreated) {
            return false;
        }

        $changed = array_keys($model->getChanges());

        if ($changed === []) {
            return true;
        }

        // Perubahan remember_token/updated_at saja tidak perlu memicu reload.
        return array_diff($changed, ['remember_token', 'updated_at']) === [];
    }

    private function broadcast(Model $model, string $entity, string $action): void
    {
        $forStudents = in_array($entity, ['kelas', 'kategori', 'materi', 'quis'], true);

        $studentId = null;

        if ($entity === 'reward' && $model instanceof Reward) {
            $studentId = $model->user_id;
        }

        if ($entity === 'siswa' && $model instanceof User) {
            $studentId = $model->id;
        }

        DataChanged::dispatch(
            entity: $entity,
            action: $action,
            id: (string) $model->getKey(),
            label: $this->labelFor($model, $entity),
            actorId: auth()->id(),
            forStudents: $forStudents,
            studentId: $studentId,
        );
    }

    private function labelFor(Model $model, string $entity): ?string
    {
        $label = match ($entity) {
            'kelas' => $model->nama_kelas,
            'kategori' => $model->nama_kategori,
            'materi' => $model->nama_materi,
            'quis' => $model->pertanyaan,
            'reward' => $model->user?->name,
            'siswa' => $model->name,
            default => null,
        };

        return $label ? Str::limit((string) $label, 80) : null;
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataChanged implements ShouldBroadcast, ShouldDispatchAfterCommit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $entity,
        public string $action,
        public ?string $id = null,
        public ?string $label = null,
        public ?int $actorId = null,
        public bool $forStudents = false,
        public ?int $studentId = null,
    ) {
    }

    public function broadcastOn(): array
    {
        $channels = [
            new PrivateChannel('admin.data'),
        ];

        // Perubahan konten (kelas, kategori, materi, kuis) juga dikirim ke siswa.
        if ($this->forStudents) {
            $channels[] = new PrivateChannel('siswa.data');
        }

        // Event reward hanya dikirim ke siswa yang bersangkutan.
        if ($this->studentId) {
            $channels[] = new PrivateChannel('App.Models.User.' . $this->studentId);
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'data.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'entity' => $this->entity,
            'action' => $this->action,
            'id' => $this->id,
            'label' => $this->label,
            'actor_id' => $this->actorId,
            'student_id' => $this->studentId,
            'at' => now()->toIso8601String(),
        ];
    }
}

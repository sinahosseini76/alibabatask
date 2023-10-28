<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'path',
    ];

    public function attachable()
    {
        return $this->morphTo('attachable');
    }

    public function path()
    {
        return url('storage/' . $this->path);
    }

    public static function saveAttachmentFile(Model $model, UploadedFile $file, string $type)
    {
        $destinationDir = 'attachments/'.$type.'/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
        $fileName = $file->getClientOriginalName();

        if (Storage::disk('public')->exists($destinationDir.$fileName)) {
            $fileName = now()->timestamp . '_' . $fileName;
        }

        Storage::disk('public')->putFileAs($destinationDir, $file, $fileName);

        return self::create([
            'attachable_id' => $model->id,
            'attachable_type' => get_class($model),
            'path' => $destinationDir . $fileName,
        ]);

    }

    public static function simpleSaveAttachmentFile($attachable_id ,$attachable_type ,  $file, string $type)
    {
        $destinationDir = 'attachments/'.$type.'/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($destinationDir.$fileName)) {
            $fileName = now()->timestamp . '_' . $fileName;
        }

        Storage::disk('public')->putFileAs($destinationDir, $file, $fileName);

        return self::create([
            'attachable_id' => $attachable_id,
            'attachable_type' => $attachable_type,
            'path' => $destinationDir . $fileName,
        ]);

    }
}

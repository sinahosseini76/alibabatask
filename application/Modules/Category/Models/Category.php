<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Attachment;
use Modules\Core\Models\CoreModel;


class Category extends CoreModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "category";

    const  STATUS = [
        self::STATUS_ACTIVE ,
        self::STATUS_INACTIVE ,
    ];

    const  STATUS_ACTIVE = 'active';
    const  STATUS_INACTIVE = 'inactive';


    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class,'attachable');
    }

    public function getAttachmentAttribute()
    {
        if($this->attachments->count() > 0){
            return $this->attachments->first()->path();
        }
        return  '-';
    }

    public function articles()
    {
        return $this->hasMany(\Modules\Article\Models\Article::class);
    }

}

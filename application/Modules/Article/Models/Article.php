<?php

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\Admin;
use Modules\Category\Models\Category;
use Modules\Core\Models\Attachment;
use Modules\Core\Models\CoreModel;


class Article extends CoreModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "article";

    const  STATUS = [
        self::STATUS_PENDING ,
        self::STATUS_PUBLISHED ,
        self::STATUS_DRAFT ,
    ];

    const  STATUS_PENDING = 'pending';
    const  STATUS_PUBLISHED = 'published';
    const  STATUS_DRAFT = 'draft';




    public function attachments()
    {
        return $this->morphMany(Attachment::class,'attachable');
    }

    public function getAttachmentAttribute()
    {
        if($this->attachments->count() > 0){
            return $this->attachments->first()->path();
        }
        return  null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}

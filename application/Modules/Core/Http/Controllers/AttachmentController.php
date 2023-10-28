<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Models\Attachment;
use Modules\User\Models\Profile;

class AttachmentController extends CoreController
{
    public function destroy(Attachment $attachment)
    {
        $attachment->delete();
        session()->flash('success-message', 'File Deleted Successfully');
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        Attachment::simpleSaveAttachmentFile($request->attachable_id , $request->attachable_type, $request->attachment, $request->type);
        session()->flash('success-message', 'File Uploaded Successfully');
        return response()->json(['message' => 'File Uploaded Successfully']);
    }
}

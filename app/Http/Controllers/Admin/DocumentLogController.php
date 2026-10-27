<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileAccess;
use Illuminate\View\View;

/** Who opened which uploaded document and when: the audit trail for the Data Protection Act. */
class DocumentLogController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.document-log', [
            'accesses' => FileAccess::with(['file', 'submission', 'user'])->latest('id')->paginate(50),
        ]);
    }
}

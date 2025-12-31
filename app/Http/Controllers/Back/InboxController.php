<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'List Inbox',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Inbox',
                    'link' => route('back.inbox.index')
                ]
            ],
            'list_message' => Inbox::latest()->get()
        ];
        return view('back.pages.inbox.index', $data);
    }

    public function destroy($id)
    {
        Inbox::find($id)->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus');
    }
}

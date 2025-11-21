<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the contact messages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = ContactMessage::latest()->get();
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Display the specified contact message.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\View\View
     */
    public function show(ContactMessage $message)
    {
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Remove the specified contact message from storage.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }
}
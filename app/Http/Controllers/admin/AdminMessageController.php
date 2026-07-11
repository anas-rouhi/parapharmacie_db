<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
// عرض الرسائل
public function index()
{
// كيجيب الميساجات مرتبين من الأحدث للأقدم ويدير Pagination ديال 10 ف الصفحة
$messages = Message::orderBy('created_at', 'desc')->paginate(10);
return view('admin.messages', compact('messages'));
}

// ماركي الميساج بلي تقرا
public function markRead($id)
{
$message = Message::findOrFail($id);
$message->update(['is_read' => true]);

return back()->with('success', 'Message marqué comme lu avec succès !');
}

// مسح الميساج
public function destroy($id)
{
$message = Message::findOrFail($id);
$message->delete();

return back()->with('success', 'Message supprimé avec succès !');
}
}
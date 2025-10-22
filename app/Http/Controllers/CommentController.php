<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Lưu comment mới  
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Comment::create([
            'product_id' => $request->product_id,
            'content' => $request->content,
            'rating' => $request->rating,
            'author_id' => auth()->check() ? auth()->id() : null,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    // Xóa comment (chỉ admin hoặc người tạo)
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Kiểm tra quyền xóa
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $comment->author_id)) {
            $comment->delete();
            return redirect()->back()->with('success', 'Đã xóa bình luận!');
        }
        
        abort(403, 'Bạn không có quyền xóa bình luận này.');
    }
}

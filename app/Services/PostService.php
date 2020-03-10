<?php


namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostService
{

    public function paginate($page = 1, $perPage = 6)
    {
        $items = Post::query()->with('user')
            ->paginate($perPage,['*'],'page',$page)
        ->onEachSide(1);
        return $items;
    }

    public function find($id, $userId)
    {
        $post = Post::query()->with('user')->withCount('likes')->withCount('comments')->findOrFail($id);

        if($userId != null)
        {
            $post->liked = $post->likes->contains($userId);
        }

        return $post;
    }

    public function comments($id, $page = 1)
    {
        $comments = DB::table('comments')->select(DB::raw('comments.desc'),
            DB::raw('comments.id'), DB::raw('users.username'),DB::raw('users.image_url')
            ,DB::raw('count(comment_likes.comment_id) as numberLikes'))
                ->join('users','users.id','=','comments.user_id')
            ->leftJoin('comment_likes','comment_likes.comment_id','=','comments.id')
            ->where('comments.post_id',$id)->groupBy('comments.id')
            ->orderBy('numberLikes','desc')->orderBy('comments.created_at','desc')->paginate(3,['*'],'page',$page);

        return $comments;
    }

    public function createComment($desc, $id, $postId)
    {
        $user = User::query()->findOrFail($id);

        $user->comments()->attach($postId,['desc' => $desc]);
    }

    public function like($postId, $userId)
    {
        $user = User::query()->findOrFail($userId);

        $like = $user->likes()->attach($postId, ['id' => $userId . $postId]);

        $post =  Post::query()->withCount('likes')->findOrFail($postId);

        return $post->likes_count;
    }

    public function unlike($postId, $userId)
    {
        $user = User::query()->findOrFail($userId);

        $like = $user->likes()->detach($postId);

        if(!$like) {
            throw new \Exception();
        }
        $post =  Post::query()->withCount('likes')->findOrFail($postId);

        return $post->likes_count;
    }

    public function isLiked($userId, $postId)
    {

        $user = User::query()->findOrFail($userId);

        $like = $user->likes()->where();

        return true;
    }
}

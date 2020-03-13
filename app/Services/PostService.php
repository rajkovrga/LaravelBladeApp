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

    public function comments($id, $userId,$page = 1)
    {
        $comments = DB::table('comments')->select(DB::raw('comments.desc'),
            DB::raw('comments.id'), DB::raw('users.username'),DB::raw('users.image_url')
            ,DB::raw('count(comment_likes.comment_id) as numberLikes'))
            ->addSelect(['user_liked' => DB::table('comment_likes')
                ->select(DB::raw('count(*)'))
                ->whereColumn('comment_likes.comment_id','=', 'comments.id')
                ->where('comment_likes.user_id',$userId)])
            ->join('users','users.id','=','comments.user_id')
            ->leftJoin('comment_likes','comment_likes.comment_id','=','comments.id')
            ->where('comments.post_id',$id)->groupBy('comments.id')->orderBy('numberLikes','desc')
            ->orderBy('comments.created_at','desc')->paginate(3,['*'],'page',$page);
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

    public function likeComment($commentId, $userId, $postId)
    {
        $user = User::query()->findOrFail($userId);

        $like = $user->commentLikes()->attach($commentId, ['id' => $userId . $commentId]);

        $number = DB::table('comment_likes')->select(DB::raw('count(*) as number'))
            ->join('comments', 'comments.id','=','comment_likes.comment_id')
            ->join('posts','posts.id','=','comments.post_id')
            ->where('comment_likes.comment_id',$commentId)->get();

        return $number;
    }

    public function unlikeComment($commentId, $userId, $postId)
    {
        $user = User::query()->findOrFail($userId);
        $like = $user->commentLikes()->detach($commentId);

        if(!$like) {
            throw new \Exception();
        }

        $number = DB::table('comment_likes')->select(DB::raw('count(*) as number'))
            ->join('comments', 'comments.id','=','comment_likes.comment_id')
            ->join('posts','posts.id','=','comments.post_id')
            ->where('comment_likes.comment_id',$commentId)->get();

        return $number;
    }

    public function edit($id, string $title, string $desc)
    {
        $post = Post::query()->findOrFail($id);

        $post->title = $title;
        $post->desc = $desc;

        $post->saveOrFail();

        return $post;
    }

    public function delete($id)
    {
        $post = Post::query()->findOrFail($id);
        $post->delete($post);

    }

}

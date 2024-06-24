## Changing Comments And Likes UI 

If you want to update comments and likes functions, you can edit in:  
- vendor/usamamuneerchaudhary/

- You need to change {{ $comments->total() }} in comments.blade.php to show all comments' total count. 
- You may hide by commenting 'likes component' for hide like UI.

#### Showing Profile Image in Comments
- Go to vendor/usamamuneerchaudhary/src/Models/Comment.php
- in user() relationship, import App/Models/User
- in comment.blade.php, put this 'src="{{ $comment->user->media ? $comment->user->media->url : $comment->user->avatar() }}" in image src.

#### Fixing Like Feature
For fix geting (-) likes error, you must fix in 
- vendor/usamamuneerchaudhary/commentify/src/scopes/HasLikes.php
- fix this function
public function isLiked(): bool|int  
    {  

          $ip = request()->ip();
          $userAgent = request()->userAgent();
          if (auth()->user()) {
            return User::with('likes')->whereHas('likes', function ($q) {
                $q->where('comment_id', $this->id)
                    ->where('user_id', auth()->user()->id);
            })->count();
        }

        if ($ip && $userAgent) {
            return $this->likes()->forIp($ip)->forUserAgent($userAgent)->count();
        }

        return false;
    }

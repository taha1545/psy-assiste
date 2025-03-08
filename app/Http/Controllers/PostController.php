<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\PostImage;
use App\Models\Like;
use App\Models\Comment;
use App\Models\SavedPost;

class PostController extends Controller
{

    public function index(Request $request)
    {
        try {
            //
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
            ]);
            // 
            $userId = $validated['user_id'] ?? null;
            //
            $posts = Post::with([
                'user:id,name,profile_p',
                'images:id,post_id,image_path',
                'comments' => function ($query) {
                    $query->latest()->limit(1);
                },
                'comments.user:id,name,profile_p'
            ])
                ->withCount(['likes', 'comments'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            // 
            if ($userId) {
                $likedPostIds = Like::where('user_id', $userId)->pluck('post_id')->toArray();
                $savedPostIds = SavedPost::where('user_id', $userId)->pluck('post_id')->toArray();
            } else {
                $likedPostIds = $savedPostIds = [];
            }
            // Map over posts and add `is_liked` and `is_saved` efficiently
            $posts->getCollection()->map(function ($post) use ($likedPostIds, $savedPostIds) {
                $post->is_liked = in_array($post->id, $likedPostIds);
                $post->is_saved = in_array($post->id, $savedPostIds);
                return $post;
            });
            //
            return response()->json($posts);
            //
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function show($id, Request $request)
    {
        try {
            //
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
            ]);
            // 
            $userId = $validated['user_id'] ?? null;
            // 
            $post = Post::with([
                'user:id,name,profile_p',
                'images:id,post_id,image_path',
                'comments' => function ($query) {
                    $query->latest();
                },
                'comments.user:id,name,profile_p'
            ])
                ->withCount(['likes', 'comments'])
                ->findOrFail($id);
            //
            $isLiked = $userId ? $post->likes()->where('user_id', $userId)->exists() : false;
            $isSaved = $userId ? $post->savedByUsers()->where('user_id', $userId)->exists() : false;
            //
            return response()->json([
                'message' => 'Post retrieved successfully',
                'post' => $post,
                'is_liked' => $isLiked,
                'is_saved' => $isSaved
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'content' => 'required|string|max:500',
                'images.*' => 'nullable|image|max:7000',
            ]);
            //
            $post = Post::create([
                'user_id' => $validated['user_id'],
                'content' => $validated['content'],
            ]);
            //
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('post_images', 'public');
                    PostImage::create([
                        'post_id' => $post->id,
                        'image_path' => $path
                    ]);
                }
            }
            //
            return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            //
            $validated = $request->validate([
                'content' => 'sometimes|string|max:500',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            //
            if (isset($validated['content'])) {
                $post->update(['content' => $validated['content']]);
            }
            //
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('post_images', 'public');
                    PostImage::create([
                        'post_id' => $post->id,
                        'image_path' => $path
                    ]);
                }
            }
            //
            return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        //
        $post->delete();
        //
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function like(Request $request, $post_id)
    {
        try {
            // 
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
            // 
            $post = Post::findOrFail($post_id);
            // 
            $existingLike = Like::where('post_id', $post_id)
                ->where('user_id', $validated['user_id'])
                ->first();
            //
            if ($existingLike) {
                //deslike
                $existingLike->delete();
                return response()->json(['message' => 'Post disliked '], 200);
            } else {
                //liek
                $like = Like::create([
                    'post_id' => $post_id,
                    'user_id' => $validated['user_id']
                ]);
                //
                return response()->json(['message' => 'Post liked '], 201);
                //
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function comment(Request $request, $post_id)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'content' => 'required|string|max:500',
            ]);
            //
            $comment = Comment::create([
                'post_id' => $post_id,
                'user_id' => $validated['user_id'],
                'content' => $validated['content'],
            ]);
            //
            return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
            //
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function save(Request $request, $post_id)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
            //
            $post = Post::findOrFail($post_id);
            //
            $existingSave = SavedPost::where('post_id', $post_id)
                ->where('user_id', $validated['user_id'])
                ->first();
            //
            if ($existingSave) {
                $existingSave->delete();
                //
                return response()->json(['message' => 'Post unsaved'], 200);
            } else {
                SavedPost::create([
                    'post_id' => $post_id,
                    'user_id' => $validated['user_id'],
                ]);
                //
                return response()->json(['message' => 'Post saved'], 201);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function likedpost(Request $request)
    {
        try {
            //
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
            // 
            $userId = $validated['user_id'];

            // Get liked and saved post IDs for the user
            $likedPostIds = Like::where('user_id', $userId)->pluck('post_id')->toArray();
            $savedPostIds = SavedPost::where('user_id', $userId)->pluck('post_id')->toArray();

            $likedPosts = Post::whereIn('id', $likedPostIds)
                ->with([
                    'user:id,name,profile_p',
                    'images:id,post_id,image_path',
                    'comments' => function ($query) {
                        $query->latest()->limit(1);
                    },
                    'comments.user:id,name,profile_p'
                ])
                ->withCount(['likes', 'comments'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            // Map over posts and add `is_liked` and `is_saved` efficiently
            $likedPosts->getCollection()->map(function ($post) use ($likedPostIds, $savedPostIds) {
                $post->is_liked = in_array($post->id, $likedPostIds);
                $post->is_saved = in_array($post->id, $savedPostIds);
                return $post;
            });

            return response()->json($likedPosts);
            //
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function userPosts(Request $request)
    {
        try {
            // Validate user_id
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $userId = $validated['user_id'];

            // Get liked and saved post IDs for the user
            $likedPostIds = Like::where('user_id', $userId)->pluck('post_id')->toArray();
            $savedPostIds = SavedPost::where('user_id', $userId)->pluck('post_id')->toArray();

            // Get all posts created by the user
            $userPosts = Post::where('user_id', $userId)
                ->with([
                    'user:id,name,profile_p',
                    'images:id,post_id,image_path',
                    'comments' => function ($query) {
                        $query->latest()->limit(1);
                    },
                    'comments.user:id,name,profile_p'
                ])
                ->withCount(['likes', 'comments'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            // Map over posts and add `is_liked` and `is_saved`
            $userPosts->getCollection()->map(function ($post) use ($likedPostIds, $savedPostIds) {
                $post->is_liked = in_array($post->id, $likedPostIds);
                $post->is_saved = in_array($post->id, $savedPostIds);
                return $post;
            });

            return response()->json($userPosts);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function savedpost(Request $request)
    {
        try {
            //
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
            // 
            $userId = $validated['user_id'];

            // Get liked and saved post IDs for the user
            $likedPostIds = Like::where('user_id', $userId)->pluck('post_id')->toArray();
            $savedPostIds = SavedPost::where('user_id', $userId)->pluck('post_id')->toArray();

            $savedPosts = Post::whereIn('id', $savedPostIds)
                ->with([
                    'user:id,name,profile_p',
                    'images:id,post_id,image_path',
                    'comments' => function ($query) {
                        $query->latest()->limit(1);
                    },
                    'comments.user:id,name,profile_p'
                ])
                ->withCount(['likes', 'comments'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            // Map over posts and add `is_liked` and `is_saved` efficiently
            $savedPosts->getCollection()->map(function ($post) use ($likedPostIds, $savedPostIds) {
                $post->is_liked = in_array($post->id, $likedPostIds);
                $post->is_saved = in_array($post->id, $savedPostIds);
                return $post;
            });

            return response()->json($savedPosts);
            //
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
}

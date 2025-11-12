<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    //
    public function index(Request $request){
        $sort = $request->query('sort','latest');
        $search = $request->query('search');

        $q = Blog::query()
            ->with(['user','likes'])
            ->withLikeCounts()
            ->when($request->user(), function ($query) use ($request){
                $query->withExists([
                    'likes as liked_by_me' => function ($q) use ($request) {
                        $q->where('user_id',$request->user()->id);
                    }
                ]);
            });
        
        if($search){
            $q->where(function($qq) use ($search){
                $qq->where('title','like', "%{$search}%")
                    ->orwhere('description','like', "%{$search}%");
            });
        }

        if($sort === 'most_liked'){
            $q->orderByDesc('likes_count')->orderByDesc('id');
        } else {
            $q->latest('created_at');
        }

        $perPage = (int) $request->query('per_page',10);
        $blogs = $q->paginate($perPage);

        return BlogResource::collection($blogs)->additional([
            'meta' => ['sort'=>$sort, 'search' => $search]
        ]);
    }

    public function show(Blog $blog,Request $request){
        $blog->load(['user','likes'])->loadCount('likes');
        return new BlogResource($blog);
    }

    public function store(StoreBlogRequest $request){
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if($request->hasFile('image')){
            $data['image_path'] = $request->file('image')->store('blogs','public');
        }

        $blog = Blog::create($data)->load(['user','likes'])->loadCount('likes');
        return (new BlogResource($blog))->response()->setStatusCode(201);
    }

    public function update(UpdateBlogRequest $request,Blog $blog){
        $data = $request->validated();
        if($request->hasFile('image')){
            if($blog->image_path) Storage::disk('public')->delete($blog->image_path);
            $data['image_path'] = $request->file('image')->store('blogs','public');
        }
        $blog->update($data);
        $blog->load(['user','likes'])->loadCount('likes');
        return new BlogResource($blog);
    }

    public function destory(Request $request,Blog $blog){
        abort_unless($request->user()->id === $blog->user_id, 403, 'Not Allowed');

        if($blog->image_path) Storage::disk('public')->delete($blog->image_path);
        $blog->delete();
        return response()->json(['message'=> 'Deleted']);
    }
}

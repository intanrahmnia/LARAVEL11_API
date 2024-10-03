<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // Get all posts with pagination
        $posts = Post::latest()->paginate(5);

        // Return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'image'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'           => 'required',
            'content'         => 'required',
            'nama_penulis'    => 'required',
            'divisi_penulis'  => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        // Create post
        $post = Post::create([
            'image'          => $image->hashName(),
            'title'          => $request->title,
            'content'        => $request->content,
            'nama_penulis'   => $request->nama_penulis,
            'divisi_penulis' => $request->divisi_penulis,
        ]);

        // Return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        // Find post by ID
        $post = Post::find($id);

        // Check if post exists
        if (!$post) {
            return response()->json(['message' => 'Post tidak ditemukan'], 404);
        }

        // Return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title'           => 'required',
            'content'         => 'required',
            'nama_penulis'    => 'required',
            'divisi_penulis'  => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find post by ID
        $post = Post::find($id);

        // Check if post exists
        if (!$post) {
            return response()->json(['message' => 'Post tidak ditemukan'], 404);
        }

        // Check if image is not empty
        if ($request->hasFile('image')) {
            // Upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            // Delete old image
            Storage::delete('public/posts/' . basename($post->image));

            // Update post with new image
            $post->update([
                'image'          => $image->hashName(),
                'title'          => $request->title,
                'content'        => $request->content,
                'nama_penulis'   => $request->nama_penulis,
                'divisi_penulis' => $request->divisi_penulis,
            ]);
        } else {
            // Update post without image
            $post->update([
                'title'          => $request->title,
                'content'        => $request->content,
                'nama_penulis'   => $request->nama_penulis,
                'divisi_penulis' => $request->divisi_penulis,
            ]);
        }

        // Return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        // Find post by ID
        $post = Post::find($id);

        // Check if post exists
        if (!$post) {
            return response()->json(['message' => 'Post tidak ditemukan'], 404);
        }

        // Delete image
        Storage::delete('public/posts/'.basename($post->image));

        // Delete post
        $post->delete();

        // Return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}

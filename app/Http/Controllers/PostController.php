<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

   public function index()
   {
      $post = Post::all();
      $name = 'post';
      return view('dashboard.post.index', compact('post','name'));
   }

   public function create()
   {
      $category = PostCategory::all();
      return view('dashboard.post.create', compact('category'));
   }

   public function store(Request $request)
   {
      $validate = $this->validate($request, [
         'post_category_id' => 'required|integer',
         'title' => 'required|string|max:255',
      ]);

      $validate['content'] = 'konten baru';
      $post = Post::create($validate);
      
      $src = $this->getImage($request->content);
      if($src) {
         $arrImageName = $this->imageConverter($src, $post->id);
         $newContent = $this->cleanContent($request->content, $arrImageName);
         $validate['image'] = Storage::url('post/'.$arrImageName[0]); 
         $validate['content'] = $newContent;
         $post->update($validate);
      } else {
         $validate['content'] = $request->content;
         $post->update($validate);
      }
      
      return redirect()->route('post.index')->with('success', 'Post berhasil dibuat');
   }

   // awal custom function
   private function getImage($content)
   {
      $atr = array();
      $doc = new DOMDocument();
      $doc->loadHTML($content);
      $imageTags = $doc->getElementsByTagName('img');
      if($imageTags) {
         foreach($imageTags as $img) {
            array_push($atr, $img->getAttribute('src'));
         }
         return $atr;
      } else {
         return False;
      }
   }

   private function imageConverter($src, $id) 
   {
      $fileName = $id.".jpg"; // diganti id post (ex: 1.jpg)
      $arrImageName = array();
      foreach ($src as $item) {
         $imageName = $this->base64_to_jpg($item, $fileName);
         array_push($arrImageName, $imageName);
      }
      return $arrImageName;
   }

   private function base64_to_jpg($base64_string, $output_file) 
   {
      $ifp = fopen(storage_path('app/post/'.$output_file), 'wb'); 
      $data = explode(',', $base64_string);
      fwrite($ifp, base64_decode($data[1]));  
      fclose($ifp); 
      return $output_file; 
   }

   private function jpg_to_base64($image, $content) 
   {
      $imgName = explode('/storage/post/', $image);
      $base64 = 'data:image/jpg;base64,'.base64_encode(Storage::get('post/'.$imgName[1]));

      $doc = new DOMDocument();
      @$doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
      $i = 0;
      $imageTags = $doc->getElementsByTagName('img');
      foreach($imageTags as $img) {
         $img->setAttribute('src', $base64);
         $i++;
      }
      return $doc->saveHTML();
   }

   private function cleanContent($content, $arrImageName) 
   {
      $doc = new DOMDocument();
      $doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
      $i = 0;
      $imageTags = $doc->getElementsByTagName('img');
      foreach($imageTags as $img) {
         $img->setAttribute('src', Storage::url('post/'.$arrImageName[$i]));
         $i++;
      }
      return $doc->saveHTML();
   }
   // akhir custom function

   public function edit(Post $post)
   {
      $category = PostCategory::all();
      
      if($post->image) {
         $content = $this->jpg_to_base64($post->image, $post->content);
         $post->content = $content;
      } 
      
      return view('dashboard.post.edit', compact('post', 'category'));
   }

   public function update(Request $request, Post $post)
   {
      $validated = $this->validate($request, [
         'post_category_id' => 'required|integer',
         'title' => 'required|string|max:255',
      ]);

      $src = $this->getImage($request->content);
      if($src) {
         $arrImageName = $this->imageConverter($src, $post->id);
         $newContent = $this->cleanContent($request->content, $arrImageName);
         $validate['image'] = Storage::url('post/'.$arrImageName[0]); 
         $validate['content'] = $newContent;
      } else {
         $validate['content'] = $request->content;
      }
      
      $post->update($validated);
      return redirect()->route('post.index')->with('success', 'Post berhasil diupdate');;
      
   }

   public function destroy(Post $post)
   {
      Post::destroy($post->id);
      if ($post->image) {
         $imgName = explode('/storage/post/', $post->image);
         Storage::delete('post/'.$imgName[1]);
      };
      Session::flash('success', 'Berhasil Menghapus Materi');
      return redirect()->route('post.index');
   }

}
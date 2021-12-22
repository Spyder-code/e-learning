<?php

namespace App\Http\Controllers;

use App\Post;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PageController extends Controller
{
   public function index() 
   {
      return view('user.index');
   }

   private function cleanContent($content) 
   {
      $doc = new DOMDocument();
      @$doc->loadHTML($content,  LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
      $imageTags = $doc->getElementsByTagName('img');
      $h5 = $doc->getElementsByTagName('h5');
      $p = $doc->getElementsByTagName('p');
      if($imageTags->length != 0) {
         $imageTags->item(0)->parentNode->removeChild($imageTags->item(0));
         $h5->item(0)->parentNode->removeChild($h5->item(0));
         return $doc->saveHTML();
      } else {
         return $content;
      } 
   }

   private function getPaginator(Request $request, $items) 
   {
      $total = count($items); 
      $page = $request->page ?? 1; // mendapatkan halaman request saat ini, halaman pertama null
      $perPage = 5; // banyak item untuk ditampilkan
      $offset = ($page - 1) * $perPage; // nilai offset (banyak item yg di skip)
      $newItems = array();
      foreach ($items as $item) {
         array_push($newItems, $item->toArray());
      }
      
      $items = array_slice($newItems, $offset, $perPage);
      $post = array();
      foreach ($items as $item) {         
         $model = new Post;
         $model->id = $item['id'];
         $model->fill($item);
         $model->created_at = $item['created_at'];
         $model->updated_at = $item['updated_at'];
         array_push($post, $model);
      }
      
      return new LengthAwarePaginator($post, $total, $perPage, $page, [
          'path' => $request->url(),
          'query' => $request->query()
      ]);
   }

   public function post(Request $request, $postname) 
   {
      switch ($postname) {
         case 'berita':
            $post = array();
            $berita = Post::where('post_category_id', '1')->orderBy('created_at','DESC')->get();
            foreach ($berita as $item) {
               $content = $this->cleanContent($item->content);
               $item->content = $content;
               array_push($post, $item);
            }

            $paginator = $this->getPaginator($request, $post);
            return view('user.post')->with('post', $paginator)->with('postname', $postname);
            break;
         case 'artikel':
            $post = array();
            $artikel = Post::where('post_category_id', '2')->orderBy('created_at','DESC')->get();
            foreach ($artikel as $item) {
               $content = $this->cleanContent($item->content);
               $item->content = $content;
               array_push($post, $item);
            }

            $paginator = $this->getPaginator($request, $post);
            return view('user.post')->with('post', $paginator)->with('postname', $postname);
            break;
         case 'pengumuman':
            $post = array();
            $pengumuman = Post::where('post_category_id', '3')->orderBy('created_at','DESC')->get();
            foreach ($pengumuman as $item) {
               $content = $this->cleanContent($item->content);
               $item->content = $content;
               array_push($post, $item);
            }

            $paginator = $this->getPaginator($request, $post);
            return view('user.post')->with('post', $paginator)->with('postname', $postname);
            break;
      }
   }

   public function postDetail($postname, $id)
   {
      switch ($postname) {
         case 'berita':
            $post = Post::where('id', $id)->where('post_category_id', '1')->first();
            $recentPost = Post::where('post_category_id', '1')->orderBy('created_at','DESC')->get();
            return view('user.postdetail', compact('post', 'recentPost'));
            break;
         case 'artikel':
            $post = Post::where('id', $id)->where('post_category_id', '2')->first();
            $recentPost = Post::where('post_category_id', '2')->orderBy('created_at','DESC')->get();
            return view('user.postdetail', compact('post', 'recentPost'));
            break;
         case 'pengumuman':
            $post = Post::where('id', $id)->where('post_category_id', '3')->first();
            $recentPost = Post::where('post_category_id', '3')->orderBy('created_at','DESC')->get();
            return view('user.postdetail', compact('post', 'recentPost'));
            break;
      }
   }
   

   // public function berita(Request $request) 
   // {
   //    $berita = array();
   //    $post = Post::where('post_category_id', '1')->orderBy('created_at','DESC')->get();
   //    foreach ($post as $item) {
   //       $content = $this->cleanContent($item->content);
   //       $item->content = $content;
   //       array_push($berita, $item);
   //    }
   //    $paginator = $this->getPaginator($request, $berita);
   //    return view('user.blog')->with('berita', $paginator);
   // }

   // public function beritaDetail($id) 
   // {
   //    $berita = Post::find($id);
   //    $post = Post::where('post_category_id', '1')->get();
   //    return view('user.blogdetail', compact('berita', 'post'));
   // }
   
}
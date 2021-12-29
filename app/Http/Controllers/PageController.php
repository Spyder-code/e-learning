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
      $post = array();
      $berita = Post::where('post_category_id', '1')->orderBy('created_at','DESC')->take(4)->get();
      foreach ($berita as $item) {
         $content = $this->cleanContent($item->content);
         $content = $this->trimContent($content, 150);
         $item->content = $content;
         array_push($post, $item);
      }

      return view('user.index', compact('post'));
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

   private function trimContent($content, $maxLength)
   {
      $tags = array();
      $result = "";
  
      $is_open = false;
      $grab_open = false;
      $is_close = false;
      $in_double_quotes = false;
      $in_single_quotes = false;
      $tag = "";
  
      $i = 0;
      $stripped = 0;
  
      $stripped_text = strip_tags($content);
  
      while ($i < strlen($content) && $stripped < strlen($stripped_text) && $stripped < $maxLength) {
         $symbol  = $content[$i];
         $result .= $symbol;
 
         switch ($symbol) {
            case '<':
               $is_open = true;
               $grab_open = true;
               break;
            case '"':
               if ($in_double_quotes) 
                  $in_double_quotes = false;
               else
                  $in_double_quotes = true;
               break;
            case "'":
              if ($in_single_quotes)
                 $in_single_quotes = false;
              else
                 $in_single_quotes = true;
              break;

            case '/':
               if ($is_open && !$in_double_quotes && !$in_single_quotes) {
                  $is_close  = true;
                  $is_open   = false;
                  $grab_open = false;
               }
               break;
            case ' ':
               if ($is_open)
                  $grab_open = false;
               else
                  $stripped++;
               break;
            case '>':
               if ($is_open) {
                  $is_open   = false;
                  $grab_open = false;
                  array_push($tags, $tag);
                  $tag = "";
               } else if ($is_close) {
                  $is_close = false;
                  array_pop($tags);
                  $tag = "";
               }
               break;
            default:
               if ($grab_open || $is_close)
                  $tag .= $symbol;
               if (!$is_open && !$is_close)
                  $stripped++;
         }
         $i++;
      }
  
      while ($tags) {
         $result .= "</".array_pop($tags).">";
      }

      $nilai = $this->checkClosedTags($result);
      return $nilai;
   }

   private function checkClosedTags($content) 
   {
      preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $content, $result);
      $openedtags = $result[1];  
      
      preg_match_all('#</([a-z]+)>#iU', $content, $result);
      $closedtags = $result[1];

      unset($closedtags[array_search('br', $closedtags)]);
      $len_opened = count($openedtags);
      if (count($closedtags) == $len_opened) {
         return $content;
      }

      $openedtags = array_reverse($openedtags);
      for ($i=8; $i < $len_opened; $i++) {
         if (!in_array($openedtags[$i], $closedtags) || $openedtags[$i] != 'br') {
            $content = str_replace('</'.$openedtags[$i].'>', '', $content);
         } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);    
         }
      } 
      return $content;
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
               $content = $this->trimContent($content, 150);
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
               $content = $this->trimContent($content, 150);
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
               $content = $this->trimContent($content, 150);
               // dd($content);
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
         case 'informasi-ppdb':
            $post = Post::where('id', $id)->where('post_category_id', '4')->first();
            return view('user.postdetail', compact('post'));
            break;
      }
   }
   
}
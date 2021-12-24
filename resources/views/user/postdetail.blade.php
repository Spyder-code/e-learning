@extends('layouts.user')
@section('content')
<!-- ======= Blog Single Section ======= -->
<section id="blog" class="blog">
   <div class="container" data-aos="fade-up">

      <div class="row">

         <div class="col-lg-8 entries">

            <article class="entry entry-single">

               <div class="entry-img">
                  <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
               </div>

               <h2 class="entry-title">
                  <a href="blog-single.html">{{ ucwords(mb_strimwidth($post->title, 0, 30, '...')) }}</a>
               </h2>

               <div class="entry-meta">
                  <ul>
                     <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                           href="blog-single.html">Admin</a></li>
                     <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-single.html"><time
                              datetime="2020-01-01">{{ date('d F Y', strtotime($post->created_at)) }}</time></a></li>
                     <!-- <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-single.html">12
                           Comments</a></li> -->
                  </ul>
               </div>

               <div class="entry-content">{!! $post->content !!}</div>

               <!-- <div class="entry-footer">
                  <i class="bi bi-folder"></i>
                  <ul class="cats">
                     <li><a href="#">Business</a></li>
                  </ul>

                  <i class="bi bi-tags"></i>
                  <ul class="tags">
                     <li><a href="#">Creative</a></li>
                     <li><a href="#">Tips</a></li>
                     <li><a href="#">Marketing</a></li>
                  </ul>
               </div> -->

            </article><!-- End blog entry -->

            <!-- <div class="blog-author d-flex align-items-center">
               <img src="assets/img/blog/blog-author.jpg" class="rounded-circle float-left" alt="">
               <div>
                  <h4>Jane Smith</h4>
                  <div class="social-links">
                     <a href="https://twitters.com/#"><i class="bi bi-twitter"></i></a>
                     <a href="https://facebook.com/#"><i class="bi bi-facebook"></i></a>
                     <a href="https://instagram.com/#"><i class="biu bi-instagram"></i></a>
                  </div>
                  <p>
                     Itaque quidem optio quia voluptatibus dolorem dolor. Modi eum sed possimus accusantium. Quas
                     repellat voluptatem officia numquam sint aspernatur voluptas. Esse et accusantium ut unde voluptas.
                  </p>
               </div>
            </div> -->

         </div><!-- End blog entries list -->

         <div class="col-lg-4">

            <div class="sidebar">

               <h3 class="sidebar-title">Search</h3>
               <div class="sidebar-item search-form">
                  <form action="">
                     <input type="text">
                     <button type="submit"><i class="bi bi-search"></i></button>
                  </form>
               </div><!-- End sidebar search formn-->

               <h3 class="sidebar-title">Categories</h3>
               <div class="sidebar-item categories">
                  <ul>
                     <li><a href="{{ route('user.post', ['berita']) }}">Berita <span>(25)</span></a></li>
                     <li><a href="{{ route('user.post', ['artikel']) }}">Artikel <span>(12)</span></a></li>
                     <li><a href="{{ route('user.post', ['pengumuman']) }}">Pengumuman <span>(5)</span></a></li>
                  </ul>
               </div><!-- End sidebar categories-->

               @if (isset($recentPost))
               <h3 class="sidebar-title">Recent Posts</h3>
               <div class="sidebar-item recent-posts">
                  <?php $i = 0; ?>
                  @foreach ($recentPost as $item)
                  @if ($i >= 3)
                  @break
                  @endif
                  <div class="post-item clearfix">
                     <img src="{{ asset('front/img/blog/blog-recent-1.jpg') }}" alt="">
                     <h4><a href="blog-single.html">{{ ucwords(mb_strimwidth($item->title, 0, 15, '...')) }}</a></h4>
                     <time datetime="2020-01-01">{{ date('d F Y', strtotime($item->created_at)) }}</time>
                  </div>
                  <?php $i++; ?>
                  @endforeach
               </div><!-- End sidebar recent posts-->
               @endif


            </div><!-- End sidebar -->

         </div><!-- End blog sidebar -->

      </div>

   </div>
</section><!-- End Blog Single Section -->
@endsection
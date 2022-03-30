@extends('layouts.user')
@section('content')
<main id="main">

   <!-- ======= Breadcrumbs ======= -->
   <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
         <ol>
            <li><a href="{{ route('user.index') }}">Home</a></li>
            <li>{{ $postname }}</li>
         </ol>
         <h2>{{ $postname }}</h2>
      </div>
   </section><!-- End Breadcrumbs -->

   <!-- ======= Blog Section ======= -->
   <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

         <div class="row">

            <div class="col-lg-8 entries">
               @foreach ($post as $item)
               <article class="entry">
                  <div class="entry-img">
                     <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
                  </div>
                  <h2 class="entry-title">
                     <a
                        href="{{ route('user.postdetail', [$postname, $item->id, date('Y', strtotime($item->created_at)), $item->slug]) }}">
                        {{ Str::limit($item->title, 20, '...') }}</a>
                  </h2>
                  <div class="entry-meta">
                     <ul>
                        <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a>Admin</a></li>
                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a><time
                                 datetime="2020-01-01">{{ date('d F Y', strtotime($item->created_at)) }}</time></a></li>
                     </ul>
                  </div>
                  <div class="entry-content">
                     {!! $item->content !!}
                     <div class="read-more">
                        <a
                           href="{{ route('user.postdetail', [$postname, $item->id, date('Y', strtotime($item->created_at)), $item->slug]) }}">Baca
                           selengkapnya</a>
                     </div>
                  </div>
               </article><!-- End blog entry -->
               @endforeach

               {{ $post->links() }}

            </div><!-- End blog entries list -->

            <div class="col-lg-4">

               <div class="sidebar">

                  <h3 class="sidebar-title">Cari</h3>
                  <div class="sidebar-item search-form">
                     <form action="">
                        <input type="text">
                        <button type="submit"><i class="bi bi-search"></i></button>
                     </form>
                  </div><!-- End sidebar search formn-->

                  <h3 class="sidebar-title">Kategori</h3>
                  <div class="sidebar-item categories">
                     <ul>
                        <li><a href="{{ route('user.post', ['berita']) }}">Berita <span>(25)</span></a></li>
                        <li><a href="{{ route('user.post', ['artikel']) }}">Artikel <span>(12)</span></a></li>
                        <li><a href="{{ route('user.post', ['pengumuman']) }}">Pengumuman <span>(5)</span></a>
                        </li>
                     </ul>
                  </div><!-- End sidebar categories-->

                  <h3 class="sidebar-title">Post Terbaru</h3>
                  <div class="sidebar-item recent-posts">
                     <?php $i = 0; ?>
                     @foreach ($post as $item)
                     @if ($i >= 3)
                     @break
                     @endif
                     <div class="post-item clearfix">
                        <img src="{{ asset('front/img/blog/blog-recent-1.jpg') }}" alt="">
                        <h4><a
                              href="blog-single.html">{{ Str::limit($item->title, 20, '...') }}</a>
                        </h4>
                        <time datetime="2020-01-01">{{ date('d F Y', strtotime($item->created_at)) }}</time>
                     </div>
                     <?php $i++; ?>
                     @endforeach
                  </div><!-- End sidebar recent posts-->

               </div><!-- End sidebar -->

            </div><!-- End blog sidebar -->

         </div>

      </div>
   </section><!-- End Blog Section -->

</main><!-- End #main -->
@endsection

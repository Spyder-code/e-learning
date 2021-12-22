<!doctype html>
<html lang="en">

<head>

   <title>Data Post - E-learning</title>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="icon" href="{{ asset('img/icon/icon-notebook.png') }}" type="image/x-icon">

   <!--Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,500&display=swap"
      rel="stylesheet">
   <link
      href="https://fonts.googleapis.com/css2?family=Buenard:wght@400;700&family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,500&display=swap"
      rel="stylesheet">
   <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"
      integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous">
   </script>

   <link rel="stylesheet" href="{{ asset('js/writty/writty.css') }}">

</head>

<body>
   <div class="container">

      <div class="topbar">
         <div class="topbar-row">
            <!-- <label class="switch">
               <input id="theme-switch" type="checkbox">
               <div class="switch-slider" title="Theme switch"> <span class="sun"><i class="fas fa-sun"></i></span><span
                     class="moon"><i class="fas fa-moon"></i></span></div>
            </label> -->

            <!-- <button class="topbar-button" onclick="clearStorage()" type="button"><i class="fas fa-pencil-alt"></i>&nbsp;
               Teks Baru</button> -->
            <input type="button" class="topbar-button" id="bSubmit" value="Submit Post" />
            <div class="selectdiv">
               <label>
                  <select name="category">
                     <option disabled> - Pilih Kategori - </option>
                     @foreach ($category as $item)
                     @if ($item->id != 4)
                     <option value="{{ $item->id }}">{{ $item->name }}</option>
                     @endif
                     @endforeach
                  </select>
               </label>
            </div>
            <a href="{{ route('post.index') }}" class="topbar-button" type="button"
               style="float: left; text-decoration: none"><i class="fas fa-arrow-circle-left"></i>&nbsp; Kembali</a>

            <!-- <input id="import-file" type="file" accept=".md,.html"> -->
         </div>
      </div>

      <div class="toolbar">
         <!-- <div class="popup">
            <button type="button" class="popup-button toolbar-button"><i class="fas fa-heading"></i></button>
            <div class="popup-window">
               <button title="Heading format" class="popup-item Heading" data-edit="formatBlock:h1">Heading</button>
               <button title="Subheading format" class="popup-item Subheading"
                  data-edit="formatBlock:h2">Subheading</button>
               <button title="Body format" class="popup-item Body" data-edit="formatBlock:p">Body</button>
               <button title="Caption format" class="popup-item Caption" data-edit="formatBlock:h5">Caption</button>
            </div>
         </div> -->


         <button title="Bold" class="toolbar-button" data-edit="bold"><i class="fas fa-bold"></i></button>
         <button title="Italic" class="toolbar-button" data-edit="italic"><i class="fas fa-italic"></i></button>
         <button title="Underline" class="toolbar-button" data-edit="underline"><i
               class="fas fa-underline"></i></button>
         <button title="Rata Kiri" class="toolbar-button" data-edit="justifyLeft"><i
               class="fas fa-align-left"></i></button>
         <button title="Rata Tengah" class="toolbar-button" data-edit="justifyCenter"><i
               class="fas fa-align-center"></i></button>
         <button title="Rata Kanan" class="toolbar-button" data-edit="justifyRight"><i
               class="fas fa-align-right"></i></button>

         <div class="popup">
            <button title="Image" type="button" class="popup-button toolbar-button no-caret"><i
                  class="fas fa-image"></i></button>
            <div class="popup-window">
               <label class="popup-button" for="imageUpload"><i class="fas fa-arrow-circle-up"></i>&nbsp; Upload
                  Gambar</label>
               <input type="file" name="imageUpload" hidden id="imageUpload" accept=".gif,.jpg,.jpeg,.png">
            </div>
         </div>
         <div class="popup">
            <!-- <button title="Download" class="toolbar-button last"><i class="fas fa-download"></i></button>
            <div class="popup-window">
               <button class="popup-button" onclick="printJS('content','html')"><i class="fas fa-file-pdf"></i>&nbsp;
                  Print or save PDF</button>
               <button class="popup-button" onclick='downloadContent("html")'><i class="fas fa-file-code"></i>&nbsp;
                  Download HTML</button>
               <button class="popup-button" onclick='downloadContent("txt")'><i class="fas fa-file-alt"></i>&nbsp;
                  Download TXT</button>
               <button class="popup-button" onclick='downloadContent("md")'><i class="fas fa-file"></i>&nbsp; Download
                  MD</button>
            </div> -->

         </div>
         <!-- <span id="counter">0</span> -->
      </div>

      <div id="editor" class="editor" style="padding-top: 25px;" data-simplebar data-simplebar-auto-hide="false">
         <div id="content" class="content" contenteditable="true">
            <p>Tulis post baru...✏️</p>
         </div>
      </div>

      <form id="formPost" action="{{ route('post.store') }}" method="post">
         @csrf
         <input type="hidden" name="post_category_id" value="">
         <input type="hidden" name="title" value="">
         <input type="hidden" name="content" value="">
      </form>

   </div>


   <script src="{{ asset('js/writty/writty.js') }}"></script>
   <script src="{{ asset('js/writty/writtyautosave.js') }}"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

   <script>
   $(document).ready(function() {

      $("#bSubmit").on("click", function() {
         const categoryId = $('select[name=category] option').filter(':selected').val();
         const content = document.getElementById('content').innerHTML;

         (async () => {
            const {
               value: judul
            } = await Swal.fire({
               title: 'Judul Post',
               input: 'text',
               inputPlaceholder: 'Masukan judul post baru',
               confirmButtonText: 'Submit',
               inputValidator: (judul) => {
                  return new Promise((resolve) => {
                     if (judul.length <= 255 && judul.length != 0) {
                        $("form input:nth-child(2)").val(categoryId);
                        $("form input:nth-child(3)").val(judul);
                        $("form input:nth-child(4)").val(content);
                        $("#formPost").submit();
                     } else {
                        resolve('Pastikan judul sudah sesuai')
                     }
                  })
               }
            })
         })();

      });

      function isEmpty(el) {
         return !$.trim(el.html())
      }
   });

   clearStorage();
   </script>

</body>

</html>
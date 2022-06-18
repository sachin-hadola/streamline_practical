
<!DOCTYPE html>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<head>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  </head>
  <style>
    * { margin: 0; padding: 0; outline: none; box-sizing: border-box; }
html, body { background-color: #dedede; }
.folder-tree-wrapper { background-color: #fff; width: 900px; min-height: 500px; padding: 20px; margin: 35px auto; border-radius: 3px; box-shadow: 1px 1px 1px 0 rgba(0,0,0,.11); }
.folder-tree { list-style: none; cursor: pointer; padding-left: 20px; }
.folder-tree li { margin-bottom: 10px; font-size: 20px; transition: all .4s ease; position: relative; }
.folder-tree li:hover {  }
.folder-tree li i { color: rgb(242, 176, 53); }
.folder-tree li ul { padding-left: 10px; padding-top: 8px; }
/* .folder-tree ul { display: none; position: relative; } */
.folder-tree ul:before { position: absolute; content: ''; left: -10px; top: 0; width: 2px; height: 100%; background-color: transparent; border-left: dashed 1px #c2c2c2; border-bottom: dashed 1px #c2c2c2; }
.folder-tree li ul li { display: block; margin-bottom: 8px; }
.folder-tree .arrow { position: absolute; top: 11px; left: -20px; width: 8px; height: 8px; transition: all .4s ease; transform: rotate(-90deg); }
.folder-tree .arrow i { color: #595959; transition: all .4s ease; }
.folder-tree .arrow:hover i { color: #292929; }
.folder-tree li.expanded > ul { display: block; }
.folder-tree li.expanded > .arrow { transform: rotate(0deg); }
    </style>
</head>
<body>
<form id="searchform">
    
<div class="folder-tree-wrapper">
<h1 style="padding-bottom: 20px;">Directory Tree Generator</h1>
  <ul class="folder-tree">

                    @foreach($all_data as $key => $value)
                    
                    @if($value->type == 2)
                        <li>
                            <a target="_blank" href="{{env('APP_URL')}}/public/uploads/{{$value->name}}"><i class="fa fa-file"></i> {{$value->name}}</a>
                            <i class="fa fa-trash deletedate" style="padding: 0 10px;" title="Delete" data-id="{{$value->id}}"></i>
                        </li>
                        
                    @endif
                    @if($value->type == 1)
                        <li data-id="{{$value->id}}"><i class="fa fa-folder"></i> {{$value->name}} 
                    @endif

                    <?php $childrendata = $value->children()->get(); ?>

                    @if(count($childrendata) >= 1)
                        <div class="arrow " id="arrliid_{{$value->id}}" data-id="{{$value->id}}"><i class="fa fa-angle-down"></i></div>
                        @endif

                        @if($value->type == 1)
                        <i class="fa fa-plus openmodalclass" data-id="{{$value->id}}" style="padding: 0px 20px;" title="Add" ></i>
                        <i class="fa fa-trash deletedate" title="Delete" data-id="{{$value->id}}"></i>
                        @endif

                        
                        <div class="ddddd_{{$value->id}}"></div>
						
                    </li>
                    
                    
                    @endforeach
                </ul>
                <div>
                <a class="btn btn-primary openmodalclass" data-id="" title="Add" > Add New</a>
</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New</h4>
      </div>
      <div class="modal-body">
      <form id="searchform">
        <lable>Select Option</lable><br>
        <input type="text" name="parent_id" class="parent_id_calss" style="display:none;"> 
        <input type="radio" id="html" name="selection_type" value="1" checked>
            <label for="html">Folder</label> &nbsp;&nbsp;&nbsp;
            <input type="radio" id="css" name="selection_type" value="2">
            <label for="css">File</label><br>

            <div class="folder_input">
                <label for="html">Name</label> &nbsp;&nbsp;&nbsp;
                <input type="text" name="name"> 
            </div>

            <div class="file_input" style="display:none;">
                <label for="html">Select File</label> &nbsp;&nbsp;&nbsp;
                <input type="file" name="file_name"> 
            </div>
</form>
      </div>
      <div class="modal-footer">
      <input type="submit" value="Submit" class="btn btn-success save_data">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

</form>
</body>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script>
      $(document).ready(function() {
        $("input[name$='selection_type']").click(function() {
            var selection_type = $(this).val();
            console.log(selection_type);

            if(selection_type == 1){
                $(".file_input").hide();
                $(".folder_input").show();
            }else{
                $(".folder_input").hide();
                $(".file_input").show();
            }
        });
    });

    $('#searchform').on('submit', function (e) {
      e.preventDefault();
      var formData = new FormData(this);
      console.log(formData)

      $.ajax({
        url: "{{ url('savedata') }}",
        type:"POST",
        data: formData,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    cache: false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response);
          if(response == 1) {
            $('#searchform')[0].reset();
              alert('Data saved successfully.');
                location.reload();
          }
        },
        error: function(error) {
                if(typeof error.responseJSON.errors.name !== "undefined"){
                    alert(error.responseJSON.errors.name[0]);
                }
                if(typeof error.responseJSON.errors.file_name !== "undefined"){
                    alert(error.responseJSON.errors.file_name[0]);
                }
        }
       });
  });

$(document).on('click','body .openmodalclass',function(evt){
    console.log($(this).attr('data-id'));
    $('.parent_id_calss').val($(this).attr('data-id'));
    $('#myModal').modal('show');
});

$(document).on('click','body .deletedate',function(e){
    
    e.preventDefault();
    data_id = $(this).attr('data-id');
    console.log(data_id);
    if (confirm('Are you sure you want to delete?')) {
        $.ajax({
        url: "{{ url('deleteddata') }}",
        type:"POST",
        data: {'id' : data_id},
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success:function(response){
            console.log(response);
          if(response == 1) {
              alert('Data deleted successfully.');
            location.reload();
          }
        },
        error: function(error) {
            
        }
       });
} else {
    
}

      
});



$(document).on('click','body .folder-tree li .arrow',function(evt){
          var data_id = $(this).attr('data-id');
    console.log($(this).attr('data-id'));
    evt.stopPropagation();
        $(this).toggleClass('expanded');
    if($(this).hasClass('expanded')){
        
        
        $.ajax({
               type:'POST',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
               url:"{{route('getmoredata')}}",
               data:{'id':data_id},
               success:function(data) {
                   $('.ddddd_'+data_id).html(data);
               }
            });
    }else{
        $('.ddddd_'+data_id).html('');
    }
		
});

    </script>
</html>

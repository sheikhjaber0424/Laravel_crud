<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container" style="display: flex;justify-content:center;margin-top:50px">
        <div class="col-md-6">
    <form action="/save" method="POST" enctype="multipart/form-data" id="form">
      @csrf
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Product name</label>
          <input type="text" name="product_name" class="form-control"  >
          <span class="text-danger error-text product_name_error"></span>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Upload product image</label>
            <input class="form-control" type="file" name="product_image" id="formFile">
            <span class="text-danger error-text product_image_error"></span>
          </div>
      
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
</div>
    <script>
        $(function(){
           $('#form').on('submit',function(e){
            e.preventDefault();

            var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                        $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix,val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else{
                            $(form)[0].reset();
                            alert(data.msg);
                            // fetchAllProducts();
                        }
                    }
                });
           });
        })
    </script>
</body>
</html>
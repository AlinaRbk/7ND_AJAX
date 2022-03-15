@extends('layouts.app')

@section('content')

<style>
    th div {
    cursor: pointer;
}
</style> 

<div class="container">

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTypeModal">
    Create type
</button>

    <input id="hidden-sort" type="hidden" value="id" />
    <input id="hidden-direction" type="hidden" value="asc" />

    <div id="alert" class="alert alert-success d-none">
    </div>   

<div class="searchAjaxForm">
    <input id="searchValue" type="text">
    <span class="search-feedback"></span>
</div>

    <table id="types-table" class="table table-striped">
        <thead>
        <tr>
            
            <th><div class="types-sort" data-sort="id" data-direction="asc">Id</div></th>
            <th><div class="types-sort" data-sort="title" data-direction="asc">Title</div></th>
            <th><div class="types-sort" data-sort="description" data-direction="asc">Description</div></th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($types as $type) 
        <tr class="type{{$type->id}}">
            <td class="col-type-id">{{$type->id}}</td>
            <td class="col-type-title">{{$type->title}}</td>
            <td class="col-type-description">{{$type->description}}</td>
            <td>
                <button class="btn btn-danger delete-type" type="submit" data-typeId="{{$type->id}}">DELETE</button>
                <button type="button" class="btn btn-primary show-type" data-bs-toggle="modal" data-bs-target="#showTypeModal" data-typeId="{{$type->id}}">Show</button>
                <button type="button" class="btn btn-secondary edit-type" data-bs-toggle="modal" data-bs-target="#editTypeModal" data-typeId="{{$type->id}}">Edit</button>
            </td>
        </tr>
       
        @endforeach
        </tbody>
    </table>

    <table class="template d-none">
        <tr>
            <td class="col-type-id"></td>
            <td class="col-type-title"></td>
            <td class="col-type-description"></td>
            <td>
            <button class="btn btn-danger delete-type" type="submit" data-typeId="">DELETE</button>
            <button type="button" class="btn btn-primary show-type" data-bs-toggle="modal" data-bs-target="#showtTypeModal" data-typeId="">Show</button>
            <button type="button" class="btn btn-secondary edit-type" data-bs-toggle="modal" data-bs-target="#editTypeModal" data-typeId="">Edit</button>
            </td>

        </tr> 

    </table>  




</div>


<script>

     $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        function createRowFromHtml(typeId, typeTitle, typeDescription) {
            $(".template tr").removeAttr("class");
            $(".template tr").addClass("type"+typeId);
          $(".template .delete-type").attr('data-typeId', typeId );
          $(".template .show-type").attr('data-typeId', typeId );
          $(".template .edit-type").attr('data-typeId', typeId );
          $(".template .col-type-id").html(typeId );
          $(".template .col-type-title").html(typeTitle );
          $(".template .col-type-description").html(typeDescription );
         // $(".template input:checkbox").attr('value', typeId);
          
          return $(".template tbody").html();
        }

        console.log("Jquery veikia");
        $("#submit-ajax-form").click(function() {
            let type_title;
            let type_description;
            let sort;
            let direction;


            type_title = $('#type_title').val();
            type_description = $('#type_description').val();
            sort = $('#hidden-sort').val();
            direction = $('#hidden-direction').val();

            $.ajax({
                type: 'POST',
                url: '{{route("type.storeAjax")}}' ,
                data: {type_title: type_title, type_description: type_description, sort:sort, direction:direction  },
                    success: function(data) {
                        console.log(data);
                        if($.isEmptyObject(data.errorMessage)) {
                        $("#types-table tbody").html('');
                     $.each(data.types, function(key, type) {
                        let html;

                    html = createRowFromHtml(type.id, type.title, type.description);
                    $("#types-table tbody").append(html);
                    });

                    $("#createTypeModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.typeTitle +" " +data.typeDescription);
                    
                    $('#type_title').val('');
                    $('#type_description').val('');
               
                         } else {
                      console.log(data.errorMessage);
                      console.log(data.errors);
                      $('.create-input').removeClass('is-invalid');
                      $('.invalid-feedback').html('');
            
                        $.each(data.errors, function(key, error) {
                        console.log(key);
                        $('#'+key).addClass('is-invalid');
                        $('.input_'+key).html("<strong>"+error+"</strong>");
                      });
                    }
                }
            });
        });
    
        $(document).on('click', '.delete-type', function() {
            let typeId;
            typeId = $(this).attr('data-typeId');
            console.log(typeId);
            $.ajax({
                type: 'POST',
                url: '/types/deleteAjax/' + typeId  ,
                success: function(data) {
                   console.log(data);

                    $('.type'+typeId).remove();
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);                    
                }
            });
        });


        $(document).on('click', '.show-type', function() {
            let typeId;
            typeId = $(this).attr('data-typeId');
            console.log(typeId);

            $.ajax({
                type: 'GET',// formoje method POST GET
                url: '/types/showAjax/' + typeId  ,// formoje action
                success: function(data) {
                   $('.show-type-id').html(data.typeId);                   
                   $('.show-type-title').html(data.typeTitle);                                
                   $('.show-type-description').html(data.typeDescription);                                  
                }
            });
        });    

        $(document).on('click', '.edit-type', function() {
            let typeId;
                typeId = $(this).attr('data-typeId');
                console.log(typeId);
                $.ajax({

                    type: 'GET',// formoje method POST GET
                    url: '/types/showAjax/' + typeId  ,// formoje action
                    success: function(data) {
                    $('#edit_type_id').val(data.typeId);                   
                    $('#edit_type_title').val(data.typeTitle);                                  
                    $('#edit_type_description').val(data.typeDescription);                                  
                }
            });
        });

        $(document).on('click', '#update-type', function() {

let typeId;
let type_title
let type_description;

typeId = $('#edit_type_id').val();
type_title = $('#edit_type_title').val();
type_description = $('#edit_type_description').val();
$.ajax({
    type: 'POST',// formoje method POST GET
    url: '/types/updateAjax/' + typeId  ,// formoje action
    data: {type_title: type_title, type_description: type_description  },
    success: function(data) {
      //  $('.show-client-id').html(data.clientId);f

      // $(".client"+clientid+ " " + ".col-client-id").html(data.clientId)
      $(".type"+typeId+ " " + ".col-type-title").html(data.typeTitle)
      $(".type"+typeId+ " " + ".col-type-description").html(data.typeDescription)
      
        $("#alert").removeClass("d-none");
        $("#alert").html(data.successMessage);
        
        $("#editTypeModal").hide();
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css({overflow:'auto'});

    }                            
                
            });
          
        });

        $('.types-sort').click(function() {
          let sort;
          let direction;
          sort = $(this).attr('data-sort');
          direction = $(this).attr('data-direction');
          $("#hidden-sort").val(sort);
          $("#hidden-direction").val(direction);
          if(direction == 'asc') {
            $(this).attr('data-direction', 'desc');
          } else {
            $(this).attr('data-direction', 'asc');
          }

          $.ajax({
                type: 'GET',// formoje method POST GET
                url: '{{route("type.indexAjax")}}'  ,// formoje action
                data: {sort: sort, direction: direction },
                success: function(data) {
                  console.log(data.types);
                    $("#types-table tbody").html('');
                     $.each(data.types, function(key, type) {
                          let html;
                          html = createRowFromHtml(type.id, type.title, type.description);
                          // console.log(html)
                          $("#types-table tbody").append(html);
                     });
                
                }
            });
        });

        $(document).on('input', '#searchValue', function() {
            let searchValue = $('#searchValue').val();
            let searchFieldCount= searchValue.length;
            
            if(searchFieldCount == 0) {
            console.log("Field is empty");
            $(".search-feedback").css('display', 'block');
            $(".search-feedback").html("Field is empty");
          } else if (searchFieldCount != 0 && searchFieldCount< 3 ) {
            console.log("Min 3");
            $(".search-feedback").css('display', 'block');
            $(".search-feedback").html("Min 3");
          } else {
            $(".search-feedback").css('display', 'none');
          console.log(searchFieldCount);

          console.log(searchValue);
         
          $.ajax({
                type: 'GET',
                url: '{{route("type.searchAjax")}}'  ,
                data: {searchValue: searchValue},
                success: function(data) {

                  if($.isEmptyObject(data.errorMessage)) {
                    //sekmes atvejis
                    $("#types-table").show();
                    $("#alert").addClass("d-none");
                    $("#types-table tbody").html('');
                     $.each(data.types, function(key, type) {
                          let html;
                          html = createRowFromHtml(type.id, type.title, type.description);
                          // console.log(html)
                          $("#types-table tbody").append(html);
                     });                             
                  } else {
                        $("#types-table").hide();
                        $('#alert').removeClass('alert-success');
                        $('#alert').addClass('alert-danger');
                        $("#alert").removeClass("d-none");
                        $("#alert").html(data.errorMessage); 
                  }                            
                }
            });
          }
        });
    })

</script>


@endsection   